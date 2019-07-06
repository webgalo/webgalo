<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('twitter-api-php-master/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
		'oauth_access_token' => "115378629-XJx3xDTfvVSsg5ZqaPGoOfLV2FuJCZeDZ3ElEiQ4",
		'oauth_access_token_secret' => "kJx3qSm4Uz0HjF2odLQRUADwgd4kkVd4Bzn8r8duBazkm",
		'consumer_key' => "sHyrvmfBGKUJPs4jZh0S1Qmm7",
		'consumer_secret' => "X6A6xSNkEIZi4b7jn2kHG2ii5hyRcYucDwW34Xu1lU1LviQ6tt"
);

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

$url = "https://api.twitter.com/1.1/statuses/update.json";
$requestMethod = "POST";
$postfields = array(
    'status' => 'Primeiro tweet de teste da API #twitterAPI'
);

echo $twitter->buildOauth($url, $requestMethod)
	->setPostfields($postfields)
	->performRequest();

?>