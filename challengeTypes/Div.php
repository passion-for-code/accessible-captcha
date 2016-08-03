<?php
namespace De\PassionForCode;

/**
 * A class for creating division challenges.
 *
	 * A template for this challenge type must implements the placeholder {dividend} and {divisor} 
 * A example challenge: John has {dividend} gummy bears. He splits them among his {divisor} friends. How many gummy bears has every friend? {input_field}
 * @link http://passion-for-code.de/accessible_captcha
 * @author Mohammed Malekzadeh
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 */
class Div implements ChallengeInterface {


	/*
	 * Generates a div type challenge.
	 *
	 * @return array A array with following key/value pairs [dividend] => int [divisor] => int and [result] => int. 
	 * @since 1.0
	 */
	public function generateChallenge() {
		$a['dividend'] = mt_rand(10, 50);
		// we don't want uneven number.
		if($a['dividend'] % 2 != 0) $a['dividend']++;

		$collectDivisor = array(1, 2, $a['dividend']);
		for($i=3; $i<= $a['dividend'] / 2; ++$i) {
			if(($a['dividend'] % $i) == 0) $collectDivisor[] = $i; 
		}
		$a['divisor'] = $collectDivisor[ mt_rand(0, count($collectDivisor) - 1 ) ];
		$a['result'] = $a['dividend'] / $a['divisor'];

		// random decision for string or int representation of a Number.
		$a['dividend'] = mt_rand(0,1) ? $a['dividend'] : numberToString($a['dividend']);
		$a['divisor'] = mt_rand(0,1) ? $a['divisor'] : numberToString($a['divisor']);

		return $a;
	} //EndOfMethod


}//EndOfClass