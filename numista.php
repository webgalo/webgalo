<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('max_execution_time', '120');

include("util.php");

//SETTINGS.TXT
$coin_type_id = '11420';


// create & initialize a curl session
$curl = curl_init();

// set our url with curl_setopt()
curl_setopt($curl, CURLOPT_URL, $apiAddress."/coins/".$coin_type_id);

// return the transfer as a string, also with setopt()
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($curl, CURLOPT_HTTPHEADER, array('Numista-API-Key:'.$api_key));


// curl_exec() executes the started curl session
// $output contains the output string
$output = curl_exec($curl);

$response = json_decode($output, true);

echo "<pre>";

print_r($response);

echo "</pre>";

echo "<h1>".$response['issuer']['name']." - ".$response['title']."</h1>";
echo "<img src='".$response['obverse']['picture']."'>";
echo "<img src='".$response['reverse']['picture']."'>";

mergeImages($response['obverse']['picture'], $response['reverse']['picture'], $coin_type_id);

// close curl resource to free up system resources
// (deletes the variable made by curl_init)
curl_close($curl);

?>