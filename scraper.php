<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
 
/* update your path accordingly 
include_once 'simplehtmldom/simple_html_dom.php';
 
 
$html = file_get_html("numista.com","/catalogue/index.php?e=bresil");

echo $html;
 
$ret =  $html->find('div[class=resultat_recherche] div[class=description_piece]');
 
foreach($ret as $story)
    echo $story->find('a', 0)->plaintext . "<br>";
    
    */

// Assuming you installed from Composer:
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->loadFromUrl('https://en.numista.com/catalogue/index.php?mode=avance&p=1&l=&r=&e=bresil&d=&ru=&i=&ca=3&no=&m=&v=&t=&a=1889-2020&w=&dg=&f=&u=&g=&tb=y&tc=y&tn=y&tp=y&tt=y&te=y&cat=y&q=10&o=k');

//$html = $dom->outerHtml;

$searchInfo = $dom->find('div [class="catalogue_navigation"]');

$initial = strpos($searchInfo, "Display options</a>")+19;
$final = strpos($searchInfo, " coins found.");
$length = $final-$initial;
$totalCoins = substr($searchInfo, $initial, $length);

//echo $searchInfo."<BR>";


$div = $dom->find('div [class="description_piece"]');

echo "<pre>";

foreach ($div as $coin){

    //"⌀ 34.1 mm"
    $initial = strpos($coin, "&#8960;");
    $final = strpos($coin, "mm");
    $length = $final-$initial;
    $diameter = substr($coin, $initial, $length);
    echo $coin."<BR>";
    echo $diameter."<BR>";
}

echo "</pre>";

/*// or
$dom->load('http://google.com');
$html = $dom->outerHtml; // same result as the first example
*/


?>
