<?php
/**
Prior to running ensure the realm table exists
CREATE TABLE realm (
`id` int(11) NOT NULL AUTO_INCREMENT,
`region` ENUM ('eu','us'),
`name` varchar(20),
`slug` varchar(20),
`lastupdated` int(13),
PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8

CREATE TABLE item (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(20),
PRIMARY KEY(`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
*/

$regions = array('us', 'eu');

$user = 'db_user';
$pass = 'db_pass,';
$dbname = 'db_name';
$db = new PDO("mysql:dbname=$dbname;host=127.0.0.1", $user, $pass) or die("Unable to connect\n");

$realmsql = <<<SQL
INSERT INTO realm
 (region, name, slug)
VALUES (:region, :name, :slug)    
SQL;
$realmstmt = $db->prepare($realmsql);


$tablesql = <<<SQL
CREATE TABLE `:tablename` (
  `itemId` int(11) NOT NULL,
  `allianceAvg` int(11) DEFAULT NULL,
  `hordeAvg` int(11) DEFAULT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
SQL;

foreach( $regions as $region ) {
    $realmlist = json_decode(file_get_contents("http://$region.battle.net/api/wow/realm/status"));
    foreach ( $realmlist->realms as $realm ) {
    $realmstmt->execute(array(
        ":region"=>$region,
        ":name"=>$realm->name,
        ":slug"=>$realm->slug,
    )) or die(print_r($realmstmt->errorInfo(), true));
    $tablename = $region."_".$realm->slug;
    $db->query("DROP TABLE IF EXISTS `$tablename`") 
            or die("Unable to drop $tablename".print_r($db->errorInfo(), true));
    $query = str_replace(":tablename", $tablename, $tablesql);
    $db->query($query);
    }
}
