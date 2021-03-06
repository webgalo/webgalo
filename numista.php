<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//ini_set('max_execution_time', '120');

require_once('settings.php');
require_once('twitter-api-php-master/TwitterAPIExchange.php');
require_once("util.php");

if(isset($_GET['coinID'])){

	 if(!checkCoinID($_GET['coinID'])){
		 numista($_GET['coinID']);
	 }else{
		 echo "Coin ID ".$_GET['coinID']." já foi twittada.";
	 }


}else{

	$bCheckCoin = false;
	while(!$bCheckCoin){
		$f_contents = file("numista/webgalo_coins.csv");
		$line = $f_contents[array_rand($f_contents)];
		$data = explode(";", $line);

		echo "<pre>";
		print_r($data);
		echo "</pre>";

		if(!checkCoinID($data[5])){
			numista($data[5]);
			$bCheckCoin = true;
		}else{
			echo "Coin ID ".$data[5]." já foi twittada.";
		}
	}
}

//check if coin already published
function checkCoinID($id){
	$handle = fopen('numista/published_coins.csv', 'r');
	$valid = false; // init as false
	while (($buffer = fgets($handle)) !== false) {
    if (strpos($buffer, '"'.$id.'"') !== false) {
        $valid = TRUE;
        break; // Once you find the string, you should break out the loop.
    }
	}
	fclose($handle);

	return $valid;
}

function insertCoinID($coinTypeID){
	// TODO colocar no banco de dados. incluir mais campos como a data e o link para o twitter do post.
	file_put_contents('numista/published_coins.csv', '"'.$coinTypeID.'"'."\n", FILE_APPEND | LOCK_EX);
}

function numista($coinID){

  // create & initialize a curl session
  $curl = curl_init();

  // set our url with curl_setopt()
  curl_setopt($curl, CURLOPT_URL, API_ADDRESS ."/coins/".$coinID);

  // return the transfer as a string, also with setopt()
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  curl_setopt($curl, CURLOPT_HTTPHEADER, array('Numista-API-Key:'.API_KEY));


  // curl_exec() executes the started curl session
  // $output contains the output string
  $output = curl_exec($curl);

  $response = json_decode($output, true);

  echo "<pre>";

  print_r($response);

  echo "</pre>";

  $year = "";
  if($response['min_year'] == $response['max_year']){
      $year = $response['min_year'];
  }else{
      $year = $response['min_year'] . " - " . $response['max_year'];
  }

  $catalogue = " ";

  if(isset($response['references'])){
      foreach ($response['references'] as $ref){
          if(isset($ref['catalogue']) && $ref['catalogue']['code'] == "KM"){
              $catalogue = " KM ".$ref['number']." ";
          }
      }
  }

  $coinText = $response['issuer']['name']. $catalogue."- ".$response['title']." / ".$year;

  echo "<h1>".$coinText."</h1>";
  echo "<img src='".$response['obverse']['picture']."'>";
  echo "<img src='".$response['reverse']['picture']."'>";
	echo "<br>";

  mergeImages($response['obverse']['picture'], $response['reverse']['picture'], $coinID);

  // close curl resource to free up system resources
  // (deletes the variable made by curl_init)
  curl_close($curl);

  twit($coinID, $coinText);
}

function twit($coinTypeID, $coinText){

    $twitter = new TwitterAPIExchange(TWITTER_SETTINGS);

    $file = file_get_contents('numista/'.$coinTypeID.'.jpg');
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

		$coinText = htmlspecialchars_decode($coinText);

    $url = "https://api.twitter.com/1.1/statuses/update.json";
    $requestMethod = "POST";
    $postfields = array(
        'status' => $coinText.' #coins #moedas #numista',
        'media_ids' => $mediaId
    );

    echo $twitter->buildOauth($url, $requestMethod)
    ->setPostfields($postfields)
    ->performRequest();

		insertCoinID($coinTypeID);

}
?>
