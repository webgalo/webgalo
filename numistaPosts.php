<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('max_execution_time', '120');

require_once('settings.php');
require_once('twitter-api-php-master/TwitterAPIExchange.php');
require_once("util.php");
require_once("util/db_connect.php");

$twitter = new TwitterAPIExchange(TWITTER_SETTINGS);

$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
$getfields = '?screen_name=numisArgento&tweet_mode=extended&count=150&max_id=1343907924482129922';

$data = $twitter->setGetfield($getfields)
->buildOauth($url, $requestMethod)
->performRequest();

$data = @json_decode($data, true);

echo "<pre>";
//print_r($data);
echo "</pre>";

$sql = array();

foreach ($data as $key => $value) {
  echo "<pre>";
  //print_r($value);
  echo "</pre>";


  $twitterText = utf8_decode($value["full_text"]);

  echo $twitterText."<br>";

  if(strpos($twitterText, 'KM ') === false){
    echo "SEM KM"."<BR>";
    continue;
  }

  if(checkInserted($value["id"])){
    echo "inserted"."<BR>";
    continue;
  }

  $twitterDate = DateTime::createFromFormat("D M d H:i:s O Y", $value["created_at"]);
  $twitterLink = "https://twitter.com/numisArgento/status/".$value["id"];
  $description = substr($twitterText, strpos($twitterText, '- ', strpos($twitterText, ' KM'))+2, (strpos($twitterText, ' /') - strpos($twitterText, '- ', strpos($twitterText, ' KM')) - 2));
  $yearRange = substr($twitterText, strpos($twitterText, '/ ')+2, (strpos($twitterText, ' #') - strpos($twitterText, '/ ') - 2));
  $textFind = substr($twitterText, 0, strpos($twitterText, ' -', strpos($twitterText, ' KM'))) ;
  $issuer = substr($textFind, 0, strpos($textFind, ' KM')) ;
  $kmNumber = substr($textFind, strpos($textFind, 'KM ')+3);
  $textFind = str_replace(" ", "", $textFind);

  $reference = findIDByText($textFind);

  if($reference !== ""){
    list($reference, $id) = explode(";", $reference);
    echo $reference."<br>";
    echo "<img src='/numista/".$id.".jpg'><br>";

    echo "<img src='".$value["entities"]["media"][0]["media_url"]."'><br>";
    $insert = "INSERT IGNORE INTO `celere99`.`numista`
          (`id`,
          `issuer`,
          `km_number`,
          `description`,
          `year_range`,
          `twitter_date`,
          `twitter_link`)
          VALUES
          (".$id.",
          '".mysqli_real_escape_string($conn_i, $issuer)."',
          '".$kmNumber."',
          '".mysqli_real_escape_string($conn_i, $description)."',
          '".$yearRange."',
          '".$twitterDate->format('Y-m-d H:i:s')."',
          '".$twitterLink."');";

      echo $insert."<BR>";
      $sql[] = $insert;
  }else{
    echo "referencia nao encontrada"."<BR>";
  }
}

echo implode("<BR>", $sql);

function findIDByText($textID){

  $match = "";

  $handle = @fopen("numista/twitterReference.csv", "r");
  if ($handle)
  {
      while (!feof($handle))
      {
          $buffer = fgets($handle);
          if(strpos($buffer, $textID.";") !== FALSE){
            $match = $buffer;
            break;
          }
      }
      fclose($handle);
  }

  return $match;
}

function checkInserted($twitterID){
  global $conn_i;

  $select = "SELECT count(*) AS contador FROM celere99.numista WHERE twitter_link like '%".$twitterID."%'";

  $result = mysqli_query($conn_i, $select);

  if($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    return $row["contador"] >= 1;
  }else{
    return false;
  }
}

?>
