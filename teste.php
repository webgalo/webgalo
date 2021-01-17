<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('max_execution_time', '120');

include_once("util.php");
require_once("util/db_connect.php");

testeSQL();

function testeSQL(){

  global $conn_i;

  $select = "SELECT * FROM celere99.numista";

  $result = mysqli_query($conn_i, $select);

  $dados = array();
  $counter = 0;

  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
  	$dados[$counter]["id"] = $row['id'];
  	$dados[$counter]["issuer"] = utf8_encode($row['issuer']);
  	$dados[$counter]["km_number"] = utf8_encode($row['km_number']);
    $dados[$counter]["description"] = utf8_encode($row['description']);
    $dados[$counter]["year_range"] = utf8_encode($row['year_range']);
    $dados[$counter]["twitter_date"] = utf8_encode($row['twitter_date']);
    $dados[$counter]["twitter_link"] = utf8_encode($row['twitter_link']);

  	$counter++;
  }

  $jsonData = array("records" => $dados);

  // Send the data.
  echo json_encode($jsonData);

}
?>
