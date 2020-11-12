<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('max_execution_time', '120');

include("util.php");

//settings.txt

$coin_type_id = '769';


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

$year = "";
if($response['min_year'] == $response['max_year']){
    $year = $response['min_year'];
}else{
    $year = $response['min_year'] . " - " . $response['max_year'];
}

$coinText = $response['issuer']['name']." - ".$response['title']." ".$year;

echo "<h1>".$coinText."</h1>";
echo "<img src='".$response['obverse']['picture']."'>";
echo "<img src='".$response['reverse']['picture']."'>";

/*
 * 1200px X 675px
The ideal image size and aspect ratio are 1200px X 675px and 16:9, respectively. The maximum file size is 5MB for photos and animated GIFs. You can go up to 15MB if you're posting via their website. You can tweet up to four images per post
 */

mergeImages($response['obverse']['picture'], $response['reverse']['picture'], $coin_type_id);

// close curl resource to free up system resources
// (deletes the variable made by curl_init)
curl_close($curl);

function twit($coinTypeID, $coinText){
    $twitter = new TwitterAPIExchange($settings);
    
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

?>