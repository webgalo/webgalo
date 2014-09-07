
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
</head>

<h1>O(s) Número(s) do Smith</h1>

<p><a href='http://en.wikipedia.org/wiki/Smith_number' target=blank>O que são os números Smith?</a> </p>

<p>O vídeo do Numberphile que deu origem a essa página:</p>
<iframe width="560" height="315" src="//www.youtube.com/embed/mlqAvhjxAjo?rel=0" frameborder="0" allowfullscreen></iframe>


<form name="form1" method="post" action="smith.php">
	<p>Teste aqui se o seu telefone é um número Smith!</p>
	<p>
		<input name='telefone' id='telefone' type='text' size='10' maxlength='10' value=''><input type='submit' name='Submit_Enviar' value='Enviar'>
	</p>
</form>


<body>

<?php

include("util.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');



if(count($_POST) > 0){
	$number = $_POST['telefone'];
	if(is_numeric($number)){
		echo "Telefone investigado: ".$number.NEWLINE;
		
		$somaDigitos = sumDigits($number);
		echo "Soma dos digitos do numero: ".$somaDigitos.NEWLINE;
		$numberPrimeFactors = factorize($number);
		print_r($numberPrimeFactors);
		echo NEWLINE;
		$somaDigitosPrimos = 0;
		foreach($numberPrimeFactors as $prime){
			$somaDigitosPrimos += sumDigits((string)$prime);
		}
		echo "Soma dos digitos dos primos: ".$somaDigitosPrimos.NEWLINE;
		
		if($somaDigitos == $somaDigitosPrimos){
			echo "E UM NUMERO SMITH!!!!".NEWLINE;
		}else{
			echo "Nao e um numero Smith... :(".NEWLINE;
		}
	}else{
		echo "Digite apenas os nÃºmeros.";
	}
	
}

function sumDigits($number){
	$sum = 0;
	for($i = 0; $i < strlen($number); $i++){
		$sum += $number[$i];
	}
	return $sum;
}

function factorize($number){
	$primeFactors = array();
	if($number == 1){
		$primeFactors[] = 1;
		return $primeFactors;
	}
	
	$primes = array();
	$file = fopen("primes.txt","r");
	while(! feof($file))
	{
		$linha = fgetcsv($file);
		if($linha != null){
			$primes[] = ($linha[0]);
		}
	}
	
	fclose($file);
	
	foreach($primes as $p){
		if($p*$p > $number){
			break;
		}
		while($number % $p == 0){
			$primeFactors[] = $p;
			$number = $number / $p;
		}
	}
	if($number > 1){
		$primeFactors[] = $number;
	}

	return $primeFactors;
}

?>



</body>


</html>