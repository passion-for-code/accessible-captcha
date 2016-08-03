<?php
namespace De\PassionForCode;

/**
 * A class for creating Subtraction challenges.
 *
	 * A template for this challenge type must implements the placeholder {minuend} {subtrahend}
 * A example challenge: At the beginning of the year Anna has ${minuend}. During the year, she spends ${subtrahend}. How much money does Anna have? {input_field}
 * @link http://passion-for-code.de/accessible_captcha
 * @author Mohammed Malekzadeh
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 */
class Sub implements ChallengeInterface {


	/*
	 * Generates a sub type challenge.
	 *
	 * @return array A array with following key/value pairs [minuend] => int [subtrahend] => int and [result] => int
	 * @since 1.0
	 */
	public  function generateChallenge() {
		$a['minuend'] = mt_rand(0, 20);
		$a['subtrahend'] = mt_rand(0, $a['minuend']);
		$a['result'] = $a['minuend'] - $a['subtrahend'];

		// random decision for string or int representation of a number.
		$a['minuend'] = mt_rand(0,1) ? $a['minuend'] : numberToString($a['minuend']);
		$a['subtrahend'] = mt_rand(0,1) ? $a['subtrahend'] : numberToString($a['subtrahend']);
		return $a;
	} //EndOfMethod
}//EndOfClass