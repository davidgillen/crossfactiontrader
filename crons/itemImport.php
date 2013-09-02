<?php
ini_set('memory_limit', '256M');

$user = 'db_user';
$pass = 'db_pass';
$dbname = 'db_name';
$db = new PDO("mysql:dbname=$dbname;host=127.0.0.1", $user, $pass) or die("Unable to connect\n");

$sql = "INSERT INTO `item` (`id`,`name`) VALUES (:id, :name)";
$stmt = $db->prepare($sql);

if( @$handle = opendir(__DIR__.'/items') ) {
	while (false !== ($entry = readdir($handle))) {
        $file = file_get_contents(__DIR__.'/items/'.$entry);
        if ( $item = json_decode($file) ) {
        	if( $item->id != NULL and $item->name != NULL ) {
        		$stmt->execute(array(':id'=>$item->id, ':name'=>$item->name));
        	}
        }
    }
} else {
	die("Unable to open item folder\n");
}
