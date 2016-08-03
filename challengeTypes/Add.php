<?php
namespace De\PassionForCode;
/**
 * A class for creating add challenges
 *
	 * A template for this challenge type must implements the placeholder {arg1}, {arg2}.
 * A example challenge: Anna steals ${arg1} from John. She had ${arg2} before. How much $ does she have now? {input_field}
 *
 * @link http://passion-for-code.de/accessible_captcha
 * @author Mohammed Malekzadeh
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 */
class Add implements ChallengeInterface {

	/**
	 * Generates a add type challenge.
	 *
	 *@return array A array with the following key/value pairs [arg1] => int, [arg2] => int and [result] => int.
	 * @since 1.0
	 */
	public function generateChallenge() {
		$a['arg1'] = mt_rand(0, 20);
		$a['arg2'] = mt_rand(0, 20);
		$a['result'] = $a['arg1'] + $a['arg2'];
		// random decision for string or int representation of a Number.
		$a['arg1'] = mt_rand(0, 1) ? $a['arg1'] : numberToString($a['arg1']);
		$a['arg2'] = mt_rand(0, 1) ? $a['arg2'] : numberToString($a['arg2']);
		return $a;
	} //EndOfMethod
}//EndOfClass