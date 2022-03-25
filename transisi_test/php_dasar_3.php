<?php
$kalimat = "Jakarta adalah ibukota negara Republik Indonesia";

$kalimat_array = explode(' ', strtolower($kalimat));
$kata = '';
$kata2 = '';
$kata3 = '';
$i = 0;
$y = 0;	
		//Unigram
		foreach ($kalimat_array as $ka) {
			$kata .= $ka.', ';
		}
		$kata = substr($kata, 0, -2);
		echo "Unigram : ".$kata."\n";
		
		
		//Bigram
		foreach ($kalimat_array as $ka) {
			if ($i < 1) {
				$kata2 .= $ka.' ';
				$i++;
			} else {
				$kata2 .= $ka.', ';
				$i = 0;
			}
		}
		$kata2 = substr($kata2, 0, -2);
		echo "Bigram : ".$kata2."\n";
		
		//Trigram
		
		foreach ($kalimat_array as $ka) {
			if ($y < 2) {
				$kata3 .= $ka.' ';
				$y++;
			} else {
				$kata3 .= $ka.', ';
				$y = 0;
			}
		}
		$kata3 = substr($kata3, 0, -2);
		echo "Trigram : ".$kata3."\n";
?>