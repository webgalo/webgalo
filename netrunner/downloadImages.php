<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

$cycleNumber = 6;

$firstCard = 100;
$cardQuantity = 120;


for($i = $firstCard; $i <= ($firstCard + $cardQuantity); $i++){
	$cardID = str_pad(($i+$cycleNumber*1000), 5 ,"0",STR_PAD_LEFT);
	
	//$curl = curl_init("http://netrunnerdb.com/web/bundles/netrunnerdbcards/images/cards/en-large/".str_pad($i, 5 ,"0",STR_PAD_LEFT).".png");
	$curl = curl_init("http://netrunnerdb.com/web/bundles/netrunnerdbcards/images/cards/en/".$cardID.".png");
	//$curl = curl_init("http://www.cardgamedb.com/forums/uploads/an/ffg_ADN18_".str_pad($i, 2 ,"0",STR_PAD_LEFT).".png");


	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$resultCurl = curl_exec($curl);

	$filename = "bc0f047c-01b1-427f-a439-d451eda".$cardID;

	file_put_contents("png/".$filename.".png", $resultCurl);

	//$file = fopen("netrunner/bc0f047c-01b1-427f-a439-d451eda05".str_pad($i, 3 ,"0",STR_PAD_LEFT).".png","rb");

	//image(imagecreatefromstring(file_get_contents($filename)), "output.png");

	$convResult = imagejpeg(imagecreatefromstring(file_get_contents("png/".$filename.".png")), "jpg/".$filename.".jpg", 100);
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