<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('twitter-api-php-master/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
//settings.txt

$twitter = new TwitterAPIExchange(SETTINGS);

$coin_type_id = '10864';

$file = file_get_contents('numista/'.$coin_type_id.'.jpg');
$data = base64_encode($file);

$url    = 'https://upload.twitter.com/1.1/media/upload.json';
$requestMethod = 'POST';
$postfields = array(
    'media_data' => $data
);

$data     = $twitter->buildOauth($url, $requestMethod)->setPostfields($postfields)->performRequest();

/** Store the media id for later **/
$data = @json_decode($data, true);

$mediaId = $data['media_id'];

echo $mediaId."<br>";

if (!$mediaId)
{
    echo "erro<br>";
   // $twitter->fail('Cannot /update status because /upload failed');
}

$url = "https://api.twitter.com/1.1/statuses/update.json";
$requestMethod = "POST";
$postfields = array(
    'status' => 'Brazil - 40 Réis 1889-1912 #coins #numista',
    'media_ids' => $mediaId
);

echo $twitter->buildOauth($url, $requestMethod)
	->setPostfields($postfields)
	->performRequest();

?>