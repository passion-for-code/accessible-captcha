<?php
namespace De\PassionForCode;
/**
 * Returns the pronounciated string representation of a number in German, e.g.
 * '1' will return 'eins'. As of right now, only positive numbers between 0 and
 * 999 are supported.
 * @param $int The number to transform
 * @return string The pronounciated string
 */
function numberToString($int) {
	// if it is not a number, we don't do anything
	if(!is_integer($int) ) return $int;

	// mapping array
	$map[0] = 'null';
	$map[1] = 'eins';
	$map[2] = 'zwei';
	$map[3] = 'drei';
	$map[4] = 'vier';
	$map[5] = 'fünf';
	$map[6] = 'sechs';
	$map[7] = 'sieben';
	$map[8] = 'acht';
	$map[9] = 'neun';
	$map[10] = 'zehn';
	$map[11] = 'elf';
	$map[12] = 'zwölf';
	$map[13] = 'dreizehn';
	$map[14] = 'vierzehn';
	$map[15] = 'fünfzehn';
	$map[16] = 'sechzehn';
	$map[17] = 'siebzehn';
	$map[18] = 'achtzehn';
	$map[19] = 'neunzehn';
	$map[20] = 'zwanzig';
	$map[30] = 'dreißig';
	$map[40] = 'vierzig';
	$map[50] = 'fünfzig';
	$map[60] = 'sechzig';
	$map[70] = 'siebzig';
	$map[80] = 'achtzig';
	$map[90] = 'neunzig';
	$map[100] = 'hundert';

	// Split the number in digits.
	$digits = array();
		for($i= (strlen($int)-1); $i >= 0; --$i) {
			$base =  pow(10,$i);
			$digits[$i] = floor( $int / $base);
			$int -= $digits[$i]*$base;
		}/*EndOfFor*/

	// build the string.
	$string = '';
	$numOfDigits = count($digits);

	switch($numOfDigits) {
		case 3 : {
			$map[1] = 'ein';
			$string .= $map[ $digits[2] ] . $map[100];
		} /*endOfCase3*/
		case 2: {
			// check if a direct mapping is possible
			// its possible when whe have 20, 30, 40... or a number < 20.
			if( ($digits[1]*10 + $digits[0]) % 10 == 0 || ($digits[1]*10+$digits[0]) <= 20) {
				// we need a correction here.
				$map[0] = '';
				$string .= (($digits[1]*10+$digits[0]) <20) ? $map[ ($digits[1]*10+$digits[0]) ] : $map[ $digits[1]*10];
				break;
			} /*EndOfIf*/
			else {
				// we need a correction, if the first digit is 1.
				$map[1] = 'ein';
				$string .= $map[ $digits[0] ] .'und'. $map[ $digits[1] * 10];
				break;
			} /*EndOfElse*/
		} /*EndOfCase2*/
		case 1: $string 	= $map[ $digits[0] ]; break;
		default:
		  // just return the value for any number not supported yet
			$string = $int;
	} /*EndOfSwitch.*/

	return $string;
} /*EndOfFunction*/
