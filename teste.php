<?php 

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('max_execution_time', '120');

include("util.php");

mergeImages("https://en.numista.com/catalogue/photos/portugal/5633-original.jpg", "https://en.numista.com/catalogue/photos/portugal/5634-original.jpg", 769);

?>