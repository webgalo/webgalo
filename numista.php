<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('max_execution_time', '120');

require_once('settings.php');
require_once('twitter-api-php-master/TwitterAPIExchange.php');
include("util.php");

//settings.txt

$coin_type_id = '138';


// create & initialize a curl session
$curl = curl_init();

// set our url with curl_setopt()
curl_setopt($curl, CURLOPT_URL, API_ADDRESS ."/coins/".$coin_type_id);

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

mergeImages($response['obverse']['picture'], $response['reverse']['picture'], $coin_type_id);

// close curl resource to free up system resources
// (deletes the variable made by curl_init)
curl_close($curl);

twit($coin_type_id, $coinText);


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
    
    $url = "https://api.twitter.com/1.1/statuses/update.json";
    $requestMethod = "POST";
    $postfields = array(
        'status' => $coinText.' #coins #numista',
        'media_ids' => $mediaId
    );
    
    echo $twitter->buildOauth($url, $requestMethod)
    ->setPostfields($postfields)
    ->performRequest();
    
}

function updateCoinList(){
    /*
     * no notepad++
     * salvar o arquivo como flat XML
     * 
     * procurar: (http.*)(" xlink:type="simple">)([^<]*)(</text:a>)
     * substituir: $1$2$1$4
     * 
     */
    
    
    // create & initialize a curl session
    $curl = curl_init();
    
    // set our url with curl_setopt()
    curl_setopt($curl, CURLOPT_URL, API_ADDRESS ."/users/61674/");
    
    // return the transfer as a string, also with setopt()
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Numista-API-Key:'.API_KEY));
    
    
    // curl_exec() executes the started curl session
    // $output contains the output string
    $output = curl_exec($curl);
    
    $response = json_decode($output, true);
}

?>