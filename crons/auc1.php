<?php
ini_set("memory_limit", "1024M");
define('DB_USER', 'db_user');
define('DB_PASS', 'db_pass,');
define('DB_NAME', 'db_name');
define('REALM_URL', 'http://region.battle.net/api/wow/auction/data/slug');

$ai = new auctionImporter();
$ai->runImport();

class auctionImporter
{
    var $db;
    var $items;

    public function __construct()
    {
        $this->db = new PDO("mysql:dbname=".DB_NAME.";host=127.0.0.1", DB_USER, DB_PASS)
            or die("Unable to connect to database");
        $this->_loadItems();
    }

    /**
     * Run over all the realms and see if there is new data
     * if we have new data for a realm, then we process it
     */
    public function runImport()
    {
        $sql = "SELECT * FROM realm";
        #$sql = "SELECT * FROM realm WHERE slug = 'earthen-ring' AND region = 'eu'";
        foreach( $this->db->query($sql) as $row ) {
            $realmURL = str_replace(
                array('region', 'slug'),
                array($row['region'], $row['slug']),
                REALM_URL
            );
            echo $realmURL,"\n";
            $realmDetails = file_get_contents($realmURL);
            $realmDetails = json_decode($realmDetails);
            #die($realmDetails->files[0]->lastModified ." > " . $row['lastupdated']);
            if( strlen($row['lastupdated']) == 0 || $realmDetails->files[0]->lastModified > $row['lastupdated'] ) {
                if ( $this->_processRealm($row['region'], $row['slug'], $realmDetails->files[0]->url) ) {
                    $this->_updateRealm($row['region'], $row['slug'], $realmDetails->files[0]->lastModified);
                }
            } else {
            	echo "Skipping\n";
            }
            #print_r($realmDetails);
        }
    }

    /**
     * Process the data for a single realm
     */
    private function _processRealm($region, $realm, $url)
    {
        if(!$auctions = file_get_contents($url)) {
            echo "Unable to get auctions for $region $realm\n";
            return false;
        }
        $auctions = json_decode($auctions);
		unset($this->aucData);
        $this->aucData = array();

        // Load up the auction data for alliance and horde
        foreach( $auctions->alliance->auctions as $auction ) {
        	if ( !isset($this->items[$auction->item]) ) {
        		$this->_addItem($auction->item);
        	}
            $this->aucData[$auction->item] = $this->_processAuction($auction, 'alliance');
        }

        foreach( $auctions->horde->auctions as $auction ) {
            $this->aucData[$auction->item] = $this->_processAuction($auction, 'horde');
        }

        // Now insert them all
        $tablename = $region."_".$realm;
        $this->db->query("DELETE FROM `$tablename`");
		$stmt = $this->db->prepare("INSERT INTO `$tablename` VALUES (:itemId, :alliance, :horde);") 
            or die("Prepare died\n");
		foreach($this->aucData as $auc) {
		    $stmt->execute( array (
		        ':itemId'=>$auc->id,
		        ':alliance'=>round($auc->alliance),
		        ':horde'=>round($auc->horde)
		    ) ) or die("Insert failed\n".print_r($db->errorInfo(),true)."\n");
		}
        return true;
    }

    /**
     * Update the lastupdated field for a realm
     */
    private function _updateRealm($region, $slug, $lastupdated) {
        $sql = <<<SQL
UPDATE realm 
SET lastupdated = '$lastupdated'
WHERE region = '$region' AND slug = '$slug'
SQL;
        $this->db->query($sql);
    }

	private function _processAuction( $auction, $faction ) {
	    $factionCount = $faction.'Count';
	    if(isset($this->aucData[$auction->item]) ) {
	        $auc = $this->aucData[$auction->item];
	        $auc->$factionCount++;
	        $auc->$faction = $this->_recalculateAverage(
	            $auc->$faction,
	            $auc->$factionCount,
	            $auction->buyout / $auction->quantity
	        );
	
	    } else {
	        $auc = new stdClass();
	        $auc->id = $auction->item;
	        // Set some first time vars
	        $auc->alliance = 0;
	        $auc->horde = 0;
	        $auc->allianceCount = 0;
	        $auc->hordeCount = 0;
	        $auc->$faction = $auction->buyout / $auction->quantity;
	        $auc->$factionCount = 1;
	    }
	    return $auc;
	}
	
	
	private function _recalculateAverage( $oldAvg, $numberItems, $newVal ) {
	    $numberItems++;
	    return $oldAvg + ( ($newVal - $oldAvg) / $numberItems );
	}
	
	private function _loadItems()
	{
		foreach( $this->db->query("SELECT * FROM item") as $item ) {
			$this->items[$item['id']] = $item['name'];
		}
	}
	
	private function _addItem($itemId)
	{
		if ( $item = @file_get_contents('http://us.battle.net/api/wow/item/'.$itemId) ) {
			file_put_contents(__DIR__.'/items/'.$itemId, $item) or die('Unable to write file');
			$itemDetails = json_decode($item);
			$this->items[$itemDetails->id] = $itemDetails->name;
			$this->db->query($sql = "INSERT INTO item VALUES ( $itemDetails->id, '$itemDetails->name' )");
		}
	}
}
