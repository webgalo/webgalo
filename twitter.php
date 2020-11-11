<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('twitter-api-php-master/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
// SETTINGS.TXT

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

$requestMethod = "GET";
$getfield = '?screen_name=webgalo&count=20';

$twitter = new TwitterAPIExchange($settings);
/*
$string = json_decode($twitter->setGetfield($getfield)
		->buildOauth($url, $requestMethod)
		->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}

foreach($string as $items)
{
	echo "Time and Date of Tweet: ".$items['created_at']."<br />";
	echo "Tweet: ". $items['text']."<br />";
	echo "Tweeted by: ". $items['user']['name']."<br />";
	echo "Screen name: ". $items['user']['screen_name']."<br />";
	echo "Followers: ". $items['user']['followers_count']."<br />";
	echo "Friends: ". $items['user']['friends_count']."<br />";
	echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
}
*/

$file = file_get_contents('numista/11420.jpg');
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
    'status' => 'Argentina - 50 Centavos (UNICEF) / 1996 #coins #numista',
    'media_ids' => $mediaId
);

echo $twitter->buildOauth($url, $requestMethod)
	->setPostfields($postfields)
	->performRequest();

?>