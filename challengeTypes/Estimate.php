<?php
namespace De\PassionForCode;

/**
 * A class for creating Estimate (calculating shortest distance) challenges.
 *
	 * A template for this challenge type must implements the placeholder {arglist} and {arg1}
 * A example challenge: Which of the numbers in {arglist} has the shortest distance to {arg1}? {input_field}'
 * @link http://passion-for-code.de/accessible_captcha
 * @author Mohammed Malekzadeh
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 */
class Estimate implements ChallengeInterface {

	/*
	 * Generates a estimate type challenge.
	 *
	 * @return array A array with following key/value pairs [arglist] => (string), [arg1] => int and [result] => int 
	 * @since 1.0
	 */
	public function generateChallenge() {
		$a['arg1'] = mt_rand(0, 100);
		// index of the value with the lowest distance
		$index = 0;
		// only a dummy value;
		$lowestDistance = 10000;
		$stop = mt_rand(2, 4);
		for($i=0; $i < $stop; ++$i) {
			$a['arglist'][$i] = mt_rand(0, 100);
			$distance = $a['arg1'] - $a['arglist'][$i];
			// correction of a negative number.
			if($distance < 0) $distance *= -1;
			if($distance < $lowestDistance) {
				$index = $i;
				$lowestDistance = $distance;
			} //endOfIf
		} //EndOfMethod
		$a['result'] = $a['arglist'][$index];
		$a['arglist'] = implode(', ', $a['arglist']);
		return $a;
	} //EndOfMethod


}//EndOfClass