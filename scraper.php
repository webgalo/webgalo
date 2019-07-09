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
$dom->loadFromUrl('https://en.numista.com/catalogue/index.php?mode=avance&p=1&l=&r=&e=bresil&d=&ru=&i=&ca=3&no=&m=&v=&t=&a=1889-2020&w=&dg=&f=&u=&g=&tb=y&tc=y&tn=y&tp=y&tt=y&te=y&cat=y&q=100&o=k');

//$html = $dom->outerHtml;

$div = $dom->find('div [class="catalogue_navigation"]');
echo $div."<BR>";


$div = $dom->find('div [class="description_piece"]');

echo "<pre>";

foreach ($div as $coin){
    echo $coin."<BR>";
}

echo "</pre>";

/*// or
$dom->load('http://google.com');
$html = $dom->outerHtml; // same result as the first example
*/


?>
