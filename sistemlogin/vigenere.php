<?php

// membuat fungsi enkripsi
function encrypt($key, $text)
{
	
	// inisialisasi variable
	$ki = 0;
	$kl = strlen($key);
	$length = strlen($text);
	
	// lakukan perulangan untuk setiap abjad
	for ($i = 0; $i < $length; $i++)
	{
		// jika text merupakan alphabet
		if (ctype_alpha($text[$i]))
		{
			// jika text merupakan huruf kapital (semua)
			if (ctype_upper($text[$i]))
			{
				$text[$i] = chr(((ord($text[$i]) - ord("A") + ord($key[$ki]) - ord("A")) % 26) + ord("A"));
			}
			// jika text merupakan huruf kecil (semua)
			else
			{
				$text[$i] = chr(((ord($text[$i]) - ord("a") + ord($key[$ki]) - ord("a")) % 26) + ord("a"));
			}
			
			$ki++;
			if ($ki >= $kl)
			{
				$ki = 0;
			}
		}
	}
	
	// mengembalikan nilai text
	return $text;
}

// membuat fungsi dekripsi
function decrypt($key, $text)
{
	// inisialisasi variable
	$ki = 0;
	$kl = strlen($key);
	$length = strlen($text);
	
	// lakukan perulangan untuk setiap abjad
	for ($i = 0; $i < $length; $i++)
	{
		if (ctype_alpha($text[$i]))
		{
			if (ctype_upper($text[$i]))
			{
				$x = ((ord($text[$i]) - ord("A")) - (ord($key[$ki]) - ord("A")) % 26);

				if ($x < 0)
				{
					$x += 26;
				}
				
				$x = $x + ord("A");
				
				$text[$i] = chr($x);
			}
			
			// jika text merupakan huruf kecil (semua)
			else
			{
				$x = ((ord($text[$i]) - ord("a")) - (ord($key[$ki]) - ord("a")) % 26);

				if ($x < 0)
				{
					$x += 26;
				}
				
				$x = $x + ord("a");
				
				$text[$i] = chr($x);
			}

			$ki++;
			if ($ki >= $kl)
			{
				$ki = 0;
			}
		}
	}
	
	// mengembalikan nilai text
	return $text;
}

?>