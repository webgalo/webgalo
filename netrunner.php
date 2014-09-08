<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

for($i=5001; $i <= 5055; $i++){
	$curl = curl_init("http://netrunnerdb.com/web/bundles/netrunnerdbcards/images/cards/en-large/".str_pad($i, 5 ,"0",STR_PAD_LEFT).".png");
	//$curl = curl_init("http://netrunnerdb.com/web/bundles/netrunnerdbcards/images/cards/en/".str_pad($i, 5 ,"0",STR_PAD_LEFT).".png");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$resultCurl = curl_exec($curl);
	
	$filename = "bc0f047c-01b1-427f-a439-d451eda".str_pad($i, 5 ,"0",STR_PAD_LEFT);
	
	file_put_contents("netrunner/png/".$filename.".png", $resultCurl);
	
	//$file = fopen("netrunner/bc0f047c-01b1-427f-a439-d451eda05".str_pad($i, 3 ,"0",STR_PAD_LEFT).".png","rb");
	
	//image(imagecreatefromstring(file_get_contents($filename)), "output.png");
	
	$convResult = imagejpeg(imagecreatefromstring(file_get_contents("netrunner/png/".$filename.".png")), "netrunner/jpg/".$filename.".jpg", 100);
	
	echo $i." / ".$convResult. "<br>";
}





curl_close($curl);

//faz o download e salva no servidor

function png2jpg($originalFile, $outputFile, $quality) {
	$image = imagecreatefrompng($originalFile);
	imagejpeg($image, $outputFile, $quality);
	imagedestroy($image);
}

?>