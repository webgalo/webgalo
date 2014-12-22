<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');


DEFINE('DIRETORIO_OCTGN', "/home/webgalo/OCTGN");
DEFINE('DIRETORIO_NETRUNNER_SETS', DIRETORIO_OCTGN."/GameDatabase/0f38e453-26df-4c04-9d67-6d43de939c77/Sets");


$sets_data["Double Time"] = array(
		"cycle_number" => "04",
		"first_card" => "101",
		"qty" => 20);

$sets_data["Future Proof"] = array(
		"cycle_number" => "02",
		"first_card" => "101",
		"qty" => 20);

$sets_data["True Colors"] = array(
		"cycle_number" => "04",
		"first_card" => "61",
		"qty" => 20);

$sets_data["All That Remains"] = array(
		"cycle_number" => "06",
		"first_card" => "81",
		"qty" => 20);

$sets_data["Mala Tempora"] = array(
		"cycle_number" => "04",
		"first_card" => "41",
		"qty" => 20);

$sets_data["Creation & Control"] = array(
		"cycle_number" => "03",
		"first_card" => "1",
		"qty" => 55);

$sets_data["Trace Amount"] = array(
		"cycle_number" => "02",
		"first_card" => "21",
		"qty" => 20);

$sets_data["Upstalk"] = array(
		"cycle_number" => "06",
		"first_card" => "1",
		"qty" => 20);

$sets_data["A Study in Static"] = array(
		"cycle_number" => "02",
		"first_card" => "61",
		"qty" => 20);

$sets_data["First Contact"] = array(
		"cycle_number" => "06",
		"first_card" => "41",
		"qty" => 20);

$sets_data["Up and Over"] = array(
		"cycle_number" => "06",
		"first_card" => "61",
		"qty" => 20);

$sets_data["Second Thoughts"] = array(
		"cycle_number" => "04",
		"first_card" => "21",
		"qty" => 20);

$sets_data["Opening Moves"] = array(
		"cycle_number" => "04",
		"first_card" => "1",
		"qty" => 20);

$sets_data["Core"] = array(
		"cycle_number" => "01",
		"first_card" => "1",
		"qty" => 113);

$sets_data["What Lies Ahead"] = array(
		"cycle_number" => "02",
		"first_card" => "1",
		"qty" => 20);

$sets_data["Fear and Loathing"] = array(
		"cycle_number" => "04",
		"first_card" => "81",
		"qty" => 20);

$sets_data["Honor & Profit"] = array(
		"cycle_number" => "05",
		"first_card" => "1",
		"qty" => 55);

$sets_data["Humanity's Shadow"] = array(
		"cycle_number" => "02",
		"first_card" => "81",
		"qty" => 20);

$sets_data["Cyber Exodus"] = array(
		"cycle_number" => "02",
		"first_card" => "41",
		"qty" => 20);

$sets_data["The Spaces Between"] = array(
		"cycle_number" => "06",
		"first_card" => "21",
		"qty" => 20);

$sets_data["The Source"] = array(
		"cycle_number" => "06",
		"first_card" => "101",
		"qty" => 20);

$d = dir(DIRETORIO_NETRUNNER_SETS);
while (false !== ($entry = $d->read())) {
	if($entry !== "." && $entry !== ".."){
		
		$xml = @simplexml_load_file(DIRETORIO_NETRUNNER_SETS."/".$entry."/set.xml");
		
		if(isset($xml) && $xml != null){
			$set_name = $xml->attributes()."";
			
			if(array_key_exists($set_name,$sets_data)){
				echo "<a href='downloadImages.php?cycleNumber=".$sets_data[$set_name]["cycle_number"]."&firstCard=".$sets_data[$set_name]["first_card"]."&cardQuantity=".$sets_data[$set_name]["qty"]."&setID=".$xml->attributes()->id."' target=blank>".$set_name."</a>" . "<br>";
				//echo $set_name . " // ". print_r($sets_data[$set_name], true) . " // " . $xml->attributes()->id . "<br>";
			}else{
				echo $set_name. " // " . $xml->attributes()->id . "<br>";
			}
		}
	}
}

?>