<?php
namespace De\PassionForCode;
/**
 * Returns the pronounciated string representation of a number in English, e.g.
 * '1' will return 'one'. As of right now, only positive numbers between 0 and
 * 999 are supported.
 * @param $int The number to transform
 * @return string The pronounciated string
 */
function numberToString($int) {
	// if it is not a number, we don't do anything
	if(!is_integer($int) ) return $int;

	// mapping array
	$map[0] = 'zero';
	$map[1] = 'one';
	$map[2] = 'two';
	$map[3] = 'three';
	$map[4] = 'four';
	$map[5] = 'five';
	$map[6] = 'six';
	$map[7] = 'seven';
	$map[8] = 'eight';
	$map[9] = 'nine';
	$map[10] = 'ten';
	$map[11] = 'eleven';
	$map[12] = 'twelve';
	$map[13] = 'thirteen';
	$map[14] = 'fourteen';
	$map[15] = 'fifteen';
	$map[16] = 'sixteen';
	$map[17] = 'seventeen';
	$map[18] = 'eighteen';
	$map[19] = 'nineteen';
	$map[20] = 'twenty';
	$map[30] = 'thirty';
	$map[40] = 'forty';
	$map[50] = 'fifty';
	$map[60] = 'sixty';
	$map[70] = 'seventy';
	$map[80] = 'eighty';
	$map[90] = 'ninety';
	$map[100] = 'hundred';

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
			$string .= $map[ $digits[2] ] . ' ' . $map[100];
		} /*endOfCase3*/

		case 2: {
		  //little correction, if $string get already a value.
			$string .=  strlen($string)> 0 && !($digits[1] == 0 && $digits[0] == 0) ? ' and ' : '';
			// check if a direkt mapping is possible
			// its possible when whe have 20, 30, 40... or a number < 20.
			if( ($digits[1]*10 + $digits[0]) % 10 == 0 || ($digits[1]*10+$digits[0]) <= 20) {
				// we need a correction here.
				$map[0] = '';
				$string .= (($digits[1]*10+$digits[0]) <20) ? $map[ ($digits[1]*10+$digits[0]) ] : $map[ $digits[1]*10];
				break;
			} /*EndOfIf*/
			else {
				$string .= $map[ $digits[1] * 10] .'-'. $map[ $digits[0] ];
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
