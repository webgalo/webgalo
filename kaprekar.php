<?php
include("util.php");

define("KAPREKAR", "6174");

$highestSteps = 0;
$info = array();
for($i = 0; $i<10000; $i++){
	$number = fillZeros($i, 4);
	echo "chosen number: ".$number.NEWLINE;
	if(allDigitsEqual($number)){
		echo "skipping number".NEWLINE;
		continue;
	}
	
	$steps = 0;
	while($number != KAPREKAR){
		echo sortHighestToLowest($number).NEWLINE;
		echo sortLowestToHighest($number).NEWLINE;
		$number = fillZeros(sortHighestToLowest($number)-sortLowestToHighest($number), 4);
		echo $number.NEWLINE;
		echo "____".NEWLINE;
		$steps++;
	}
	if($steps >= $highestSteps){
		$info[] = $i ."//".$steps;
		$highestSteps = $steps;
	}
}

echo NEWLINE.NEWLINE."Highest Number of Steps: ".$highestSteps;

//print_r($info);

function allDigitsEqual($number){
	$number = (string)$number;
	return ($number[0] == $number[1] && $number[1] == $number[2] && $number[2] == $number[3]);
}

function fillZeros($number, $size){
	if(strlen($number) > $size){
		return $number;
	}
	while(strlen($number) < $size){
		$number = "0".$number;
	}
	
	return $number;
}

function sortHighestToLowest($number){
	
	$numberParts = str_split($number);
	rsort($numberParts);
	return implode('', $numberParts); // abc
}

function sortLowestToHighest($number){

	$numberParts = str_split($number);
	sort($numberParts);
	return implode('', $numberParts); // abc
}

?>