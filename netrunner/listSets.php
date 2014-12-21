<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


DEFINE('DIRETORIO_OCTGN', "/home/ronaldocunha/OCTGN");
DEFINE('DIRETORIO_NETRUNNER_SETS', DIRETORIO_OCTGN."/GameDatabase/0f38e453-26df-4c04-9d67-6d43de939c77/Sets");

$sets = array();
$d = dir(DIRETORIO_NETRUNNER_SETS);
while (false !== ($entry = $d->read())) {
	if($entry !== "." && $entry !== ".."){
		
		$xml = @simplexml_load_file(DIRETORIO_NETRUNNER_SETS."/".$entry."/set.xml");
		
		if(isset($xml) && $xml != null){
			echo $xml->attributes() . "//". $xml->attributes()["id"] . "<br>";;
		}
		//print_r($xml);
	}
}

//sort($arquivos);


?>