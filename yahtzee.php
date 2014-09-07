<?php

include("util.php");

for ($i=0; $i < 100; $i++){
	
	$bYahtzee = false;
	
	$counter = 1;
	
	while(!$bYahtzee){
		$dice1 = rand(1,6);
		$dice2 = rand(1,6);
		$dice3 = rand(1,6);
		$dice4 = rand(1,6);
		$dice5 = rand(1,6);
		if($dice1 == $dice2 && $dice2 == $dice3 && $dice3 == $dice4 && $dice4 == $dice5){
			echo "YAHTZEE! ". $counter . NEWLINE;
			break;
		}else{
			$counter++;
		}
	}
}

?>