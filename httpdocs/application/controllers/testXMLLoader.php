<?php

$file = 'Libraries.xml';
$outer = 'Libraries-table';
$inner = 'Libraries';

$xml = simplexml_load_file($file);

foreach( $xml->$outer->$inner as $node )
{
	foreach( $node as $key=>$val )
	{
		echo "$key:: $val\n";
	}
die();
}
