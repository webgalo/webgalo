<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

if(!(isset($_GET["cycleNumber"]) && isset($_GET["firstCard"]) && isset($_GET["cardQuantity"]) && isset($_GET["setID"]))){
	header("Location: http://" . $_SERVER["HTTP_HOST"] . "/netrunner/listSets.php");
}

$gameID = "0f38e453-26df-4c04-9d67-6d43de939c77";
$cardPrefix = "bc0f047c-01b1-427f-a439-d451eda";
$setID = $_GET["setID"];
$cycleNumber = $_GET["cycleNumber"];
$firstCard = $_GET["firstCard"];
$cardQuantity = $_GET["cardQuantity"];

$folderStructure = $cycleNumber."/".$gameID."/Sets/".$setID."/Cards/";

echo $folderStructure . "<br>";
if (!file_exists($folderStructure) && !is_dir($folderStructure)) {
	mkdir($folderStructure, 0777, true);
}

for($i = $firstCard; $i < ($firstCard + $cardQuantity); $i++){
	$cardID = str_pad(($i+$cycleNumber*1000), 5 ,"0",STR_PAD_LEFT);
	
	//$curl = curl_init("http://netrunnerdb.com/web/bundles/netrunnerdbcards/images/cards/en-large/".str_pad($i, 5 ,"0",STR_PAD_LEFT).".png");
	//$curl = curl_init("http://www.cardgamedb.com/forums/uploads/an/ffg_ADN18_".str_pad($i, 2 ,"0",STR_PAD_LEFT).".png");
	$curl = curl_init("http://netrunnerdb.com/web/bundles/netrunnerdbcards/images/cards/en/".$cardID.".png");

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$resultCurl = curl_exec($curl);

	$filename = $cardPrefix.$cardID;

	file_put_contents($folderStructure.$filename.".png", $resultCurl);

	$convResult = imagejpeg(imagecreatefromstring(file_get_contents($folderStructure.$filename.".png")), $folderStructure.$filename.".jpg", 100);
	echo $cardID." / ".$convResult. "<br>";
}

curl_close($curl);

//faz o download e salva no servidor

function png2jpg($originalFile, $outputFile, $quality) {
	$image = imagecreatefrompng($originalFile);
	imagejpeg($image, $outputFile, $quality);
	imagedestroy($image);
}

?>