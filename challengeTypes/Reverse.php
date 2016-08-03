<?php
namespace De\PassionForCode;

/**
 * A class for creating reverse typing string challenges.
 *
	 * A template for this challenge type must implements the placeholder {word}
 * A example challenge: How does the string {word} look like, if the characters are read from right to left? {input_field}
 * @link http://passion-for-code.de/accessible_captcha
 * @author Mohammed Malekzadeh
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 */
class Reverse implements ChallengeInterface {


	/*
	 * Generates a reverse type challenge.
	 *
	 * @return array A array with following key/value pairs [word] => string and [result] => string
	 * @since 1.0
	 */
	public function generateChallenge() {
		$a['word'] = '';
		$length = mt_rand(3, 4);

		for($i=0; $i < $length; ++$i) {
			$a['word'] .= chr( mt_rand(65, 90) );
		} //EndOfFor
		$a['result'] = strrev($a['word']);
		return $a;
	} //endOfMethod

}//EndOfClass