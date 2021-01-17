<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('max_execution_time', '120');

require_once('settings.php');
require_once('twitter-api-php-master/TwitterAPIExchange.php');
require_once("util.php");

$twitter = new TwitterAPIExchange(TWITTER_SETTINGS);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$postfields = array(
    'screen_name' => 'numisArgento',
    'count' => 1,
    'max_id' => '1326918418973515778'
);

echo $twitter->buildOauth($url, $requestMethod)
  ->setPostfields($postfields)
  ->performRequest();


?>
