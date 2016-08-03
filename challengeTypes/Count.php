<?php
namespace De\PassionForCode;

/**
 * A class for creating count  letter in a word challenge.
 *
	 * A template for this challenge type must implements the placeholder {letter}, {word}.
 * A example challenge: How frequently does the letter {letter} appear in {word}? {input_field}
 * @link http://passion-for-code.de/accessible_captcha
 * @author Mohammed Malekzadeh
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 */
class Count implements ChallengeInterface {


	/*
	 * Generates a count type challenge.
	 *
	 *@return array A Array with the following key / value pairs [word] => string, [letter] => string, [result] => int.
	 * @since 1.0
	 */
	public  function generateChallenge() {
		$a['word'] = '';
		$length = mt_rand(8, 12);

		for($i=0; $i < $length; ++$i) {
			$a['word'] .= chr( mt_rand(65, 90) );
		} //EndOfFor
		// choose a letter from the word.
		$a['letter'] = $a['word']{ mt_rand(0, $length-1)};

		for($i=0;$i < $length; ++$i) {
			$a['word'][$i] = mt_rand(0,2)<= 1 ? $a['word'][$i] : $a['letter'];
		}//EndOfFor
		// how often does letter appears in the word
		$a['result'] = substr_count( $a['word'], $a['letter']);
		return $a;
	} //EndOfMethod

}//EndOfClass