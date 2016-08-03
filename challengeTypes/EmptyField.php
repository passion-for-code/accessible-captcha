<?php
namespace De\PassionForCode;

/**
 * A class for creating EmptyField-challenges.
 *
	 * A template for this challenge type must implements no placeholder. 
 * A example challenge: If you are not a robot, leave the input field empty. {input_field}
 * @link http://passion-for-code.de/accessible_captcha
 * @author Mohammed Malekzadeh
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 */
class EmptyField implements ChallengeInterface {

	/*
	 * Generates a empty field type challenge.
	 *
 * @return array A array with following key/value pairs [resutl] => ''
	 * @since 1.0
	 */
	public function generateChallenge() {
		// easy job for us.
		$a['result'] = '';
		return $a;
	} //EndOfMethod

}//EndOfClass