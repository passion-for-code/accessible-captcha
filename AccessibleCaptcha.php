<?php
namespace De\PassionForCode;

/**
 * A class for creating accessible captchas.
 *
 * @link http://passion-for-code.de/accessible_captcha
 * @author Mohammed Malekzadeh
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 */
class AccessibleCaptcha {
	private $langDir = 'language';
	/* change this to your Favorite default language.
	 * If the setLanguage method is call with an unsupported language,
	 * it will use this value.
	 */
	private $language = 'german';
	// name of the result field.
	private $nameOfResultField = 'pfc_captcha_result';
	// name of the hidden field
	private $nameOfHiddenField = 'pfc_captcha_id';
	/* here you can modify the input_field that replace the {input_field} in templates.
	 * the key is the attributeName and the value the attributeValue;
	* e. g. 'size'=> 4 ends in size="4"
	 */
	private $inputFieldAttributes = array('size'=> 4);
	/*
	 * put here the name of a not used session variable. We need this for storing captcha informations in it.
	 */
	private $sessionVarName = 'captchaId';
	private $challengeList = array("add", "sub", "mul", "div", "estimate", "count",
		"reverse", "empty_field");
	// the choosen Challenge Id
	private $challengeId;
	// path to dir
	private $pathToClassDir;

	/**
	 * Constructs a new AccessibleCaptcha object.
	 *
	 * @param string $language the language. If nothing is passed, the default
	 * 		language in the property $language is used.
	 * @since 1.0
	 */
	public function __construct($language = false) {
		$this->pathToClassDir = dirname(__FILE__) .'/';
		$this->loadConfig();
		$this->setLanguage($language);
	}/*EndOfFunction*/

	/**
	 * Returns a captcha and all needed input fields.
	 *
	 * @return string The captcha and a hidden input for the captchaID and a text
	 * 		field for the result.
	 * @since 1.0
	 */
	public function getCaptcha() {
		// first import the __number_to_string.php for this language.
		$this->importNumberToStringFile();

		// then choose the challenge type.
		$this->chooseChallenge();

		// then load a text for this challenge.
		$this->loadChallengeText();

		// then generate a challenge
		$this->generateChallenge();

		// then save the Result.
		$this->saveResult();

		// finally return the generated challenge.
		return $this->challenge;
	} /*EndOfFunction*/

	/**
	 * Checks a solved captcha, if it is correct.
	 * If the send post data can be accessed via $_REQUEST, this method can handle
	 * the check fully automatically.
	 *
	 * @param mixed $result If the post data is accessible via $_REQUEST you can
	 * 		pass (false (default)), otherways the input string, that the user has
	 * 		put in the result field.
	 * @param mixed id If the post data is accessible via $_REQUEST you can pass
	 * 		(false (default)), otherways the captchaID.
	 * @param mixed $timeout pass a int value (secounds), if the captcha should
	 * 		have a temporary validation.
	 * @return boolean true, when correct solution, otherways false.
	 * @since 1.0
	 */
	public function checkResult($result = false, $id = false, $timeout = false) {
		$result = $result != false ? $result : $_REQUEST[ $this->getNameOfResultField() ];
		$id = $id != false ? $id : $_REQUEST[$this->getNameOfHiddenField()];
		// get the saved result
		$s = $this->getFromSession($id);
		$this->deleteFromSession($id);
		if(!$s) return false;

		// check if $result == the saved Result in session.
		if( $s['result'] == strtoupper( trim($result) ) ) {
			// When $timeout is false, or the captcha is even valid returns true.
			if(!$timeout || ($s['timestamp']+$timeout) > time() ) return true;
		} /*EndOfIf*/
		return false;
	}/*EndOfFunction*/

	/**
	 * Sets the language.
	 *
	 * @param string $lang The language.
	 * @since 1.0
	 */
	public function setLanguage($lang) {
		if($lang == false || !$this->existsLanguage($lang) ) return;
		$this->language = $lang;
	}

	/*
	 * Sets the attributes of the result field.
	 * The result field is the field, where the user enters the solution for a captcha.
	 *@param array $attributes the key of every entry is the attribute name and the value is the attribute value.
	 * @since 1.0
	 */
	public function setInputFieldAttributes($data) {
		//check if data is no array, we break.
		if(!is_array($data) ) return;
		//First delete the attribute "name", if it is set.
		unset($data['name']);
		$this->inputFieldAttributes = $data;
	} //EndOfMethod

	/**
	 * Sets the allowed list of challenge types.
	 * @param mixed $challengeList A array with a list of allowed challenge types. Or a String 'all', for allow all types.
	 * sinze 1.0
	 */
	public function setChallengeList($challengeList) {
		if(!is_array($challengeList) ) return;
		$this->challengeList = $challengeList;
	} //EndOfMethod.
		public function setSessionVarName($name) {
		if(!is_string($name) ) return;
		$this->sessionVarName = $name;
	}//EndOfMethod
	/**
	 * Sets the path to the language directory.
	 * @param string $pathToDir The relative path to the language directory.
	 * since 1.0
	 */
	public function setLangDir($pathToDir) {
		$this->langDir = $pathToDir;
	} //EndOfMethod

	/**
	 * Checks if a directory with this name exists in the language directory.
	 * 
	 * @param string $lang The language
	 * @return boolean true, if the language exists, otherways false.
	 * since 1.0
	 */
	public function existsLanguage($lang) {
		return file_exists($this->pathToClassDir . $this->langDir .'/'. $lang );
	}
	/**
	 * Returns the name oft the result field. The result field is the field, where
	 * the user must enter the solution.
	 *
	 * @return string the name of the result field.
	 * @since 1.0
	 */
	public function getNameOfResultField() {
		return $this->nameOfResultField;
	}

	/**
	 * Sets the name of the result field. The result field is the field, where the
	 * user must enter the solution.
	 *
	 * @param string $name  the name of the result field.
	 * @since 1.0
	 */
	public function setNameOfResultField($name) {
		$this->nameOfResultField = $name;
	}

	/**
	 * Returns the name of the hidden field. The hidden field is the field,
	 * where the captchaID is saved in.
	 *
	 * @return string the name of the hidden field.
	 * @since 1.0
	 */
	public function getNameOfHiddenField() {
		return $this->nameOfHiddenField;
	}

	/**
	 * Sets the name of the hidden field. The hidden field is the field, where the
	 * captchaID is saved in.
	 *
	 * @param string $name  the name of the hidden field.
	 * @since 1.0
	 */
	public function setNameOfHiddenField($name) {
		$this->nameOfHiddenField = $name;
	}

	///////////////////////////////////////
	// the 3 following protected functions must be overwritten, if the captcha
	// class is used by a framework which blocks the php native session
	// funtionality
	///////////////////////////////////////

	/**
	 * Saves data in the session. This method must be overwritten, if a framework
	 * blocks the native php session functionality.
	 *
	 * @param array $data the data, that must get save.
	 * @param string $id A id as key, to get for accessing the data.
	 * @since 1.0
	 */
	protected function saveInSession($data, $id) {
		// start a session, when no session is started.
		if(!isset($_SESSION) ) session_start();
		$_SESSION[$this->sessionVarName][$id] = $data;
	}/*EndOfFunction*/

	/**
	 * Returns data from session, if it exists. This method must be overwritten,
	 * if a framework blocks the native php session functionality.
	 *
	 * @param string $id The key for accessing the data in the session.
	 * @return mixed false, wehn the key is not in the session, otherways the data array.
	 * @since 1.0
	 */
	protected function getFromSession($id) {
		// start a session, when no session is started.
		if(!isset($_SESSION) ) session_start();
		// check if $result == the saved Result in Session.
		if( isset($_SESSION[$this->sessionVarName][$id]) ) return $_SESSION[$this->sessionVarName][$id];
		return false;
	}/*EndOfFunction*/

	/**
	 * Deletes data from session, if it exists. This method must be overwritten,
	 * if a framework blocks the native php session functionality.
	 *
	 * @param string $id The key for accessing the data in the session.
	 * @since 1.0
	 */
	protected function deleteFromSession($id) {
		// start a session, when no session is started.
		if(!isset($_SESSION) ) session_start();
		if( isset($_SESSION[$this->sessionVarName][$id]) ) unset($_SESSION[$this->sessionVarName][$id]);
	}

	/*
	 * Randomly choose a challenge. The Id of the challenge is saved in the
	 * property challengeId.
	 *
	 * @since 1.0
	 */
	private function chooseChallenge() {
		$this->challengeId = mt_rand(0, count($this->challengeList) -1);
	}

	/*
	 * Loads a challenge text. If a text can be chosen, the text is save in
	 * property $challenge. Otherways it throws a exception.
	 *
	 * @param mixed $stop only needs to handle a recursion for searching a
	 * 		challenge. no changes from outside please.
	 * @throws exception, when no challenge can be found.
	 * @since 1.0
	 */
	private function loadChallengeText($stop = false) {
		$challengeType = $this->challengeList[ $this->challengeId ];
		$includePath = $this->pathToClassDir . $this->	langDir .'/'. $this->language .'/'. $challengeType .'.php';
		include($includePath);
		// from here, we have included an array that calls callenge.
		if(isset($challenge) && is_array($challenge) ) {
			$this->challenge = $challenge[ mt_rand(0, count($challenge)-1) ];
		} else { // Bad job, no such array.
		// we try a other challengeType
		if($stop === false) $stop = $this->challengeId;
			$this->challengeId = $this->challengeId == (count($this->challengeList)-1) ? 0 : $this->challengeId+1;
		// break condition for the recursion
		if($stop === $this->challengeId) throw new ErrorException("Can't find any challenge.", 0);
			$this->loadChallengeText($stop);
		} /*EndOfElse*/
	} /*EndOfFunction*/

	/*
	 * Calls the right method to generates a correct challenge.
	 *
	 * @since 1.0
	 */
	private function generateChallenge() {
		$type = $this->challengeList[ $this->challengeId ];
		call_user_func( array($this, $type) );
	} /*EndOfFunction*/

	/*
	 * Generates a add type challenge.
	 *
	 * @since 1.0
	 */
	private function add() {
		$a['arg1'] = mt_rand(0, 20);
		$a['arg2'] = mt_rand(0, 20);
		$this->result = $a['arg1'] + $a['arg2'];
		// random decision for string or int representation of a Number.
		$a['arg1'] = mt_rand(0, 1) ? $a['arg1'] : numberToString($a['arg1']);
		$a['arg2'] = mt_rand(0, 1) ? $a['arg2'] : numberToString($a['arg2']);
		$this->replace($a);
	} /*EndOfFunction*/


	/*
	 * Generates a sub type challenge.
	 *
	 * @since 1.0
	 */
	private function sub() {
		$a['minuend'] = mt_rand(0, 20);
		$a['subtrahend'] = mt_rand(0, $a['minuend']);
		$this->result = $a['minuend'] - $a['subtrahend'];

		// random decision for string or int representation of a number.
		$a['minuend'] = mt_rand(0,1) ? $a['minuend'] : numberToString($a['minuend']);
		$a['subtrahend'] = mt_rand(0,1) ? $a['subtrahend'] : numberToString($a['subtrahend']);
		$this->replace($a);
	} /*EndOfFunction*/

	/*
	 * Generates a mul type challenge.
	 *
	 * @since 1.0
	 */
	private function mul() {
		$a['arg1'] = mt_rand(0, 10);
		$a['arg2'] = mt_rand(0, 10);

		$this->result = $a['arg1'] * $a['arg2'];
		// random decision for string or int representation of a Number.
		$a['arg1'] = mt_rand(0, 1) ? $a['arg1'] : numberToString($a['arg1']);
		$a['arg2'] = mt_rand(0, 1) ? $a['arg2'] : numberToString($a['arg2']);

		$this->replace($a);
	} /*EndOfFunction*/

	/*
	 * Generates a div type challenge.
	 *
	 * @since 1.0
	 */
	private function div() {
		$a['dividend'] = mt_rand(1, 20);
		// we don't want uneven number.
		if($a['dividend'] % 2 != 0) $a['dividend']++;

		$a['divisor'] = mt_rand(1, $a['dividend']);
		// we want a calculation without rest
		while($a['dividend'] % $a['divisor'] != 0) {
			$a['divisor'] += 2;
			if($a['divisor'] > $a['dividend'] ) $a['divisor'] = 2;
		} /*EndOfWhile*/

		$this->result = $a['dividend'] / $a['divisor'];

		// random decision for string or int representation of a Number.
		$a['dividend'] = mt_rand(0,1) ? $a['dividend'] : numberToString($a['dividend']);
		$a['divisor'] = mt_rand(0,1) ? $a['divisor'] : numberToString($a['divisor']);

		$this->replace($a);
	} /*EndOfFunction*/

	/*
	 * Generates a estimate type challenge.
	 *
	 * @since 1.0
	 */
	private function estimate() {
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
			} /*EndOfIf*/
		} /*EndOfFor*/
		$this->result = $a['arglist'][$index];
		$a['arglist'] = implode(', ', $a['arglist']);
		$this->replace($a);
	} /*EndOfFunction*/

	/*
	 * Generates a count type challenge.
	 *
	 * @since 1.0
	 */
	private function count() {
		$a['word'] = '';
		$length = mt_rand(8, 12);

		for($i=0; $i < $length; ++$i) {
			$a['word'] .= chr( mt_rand(65, 90) );
		} /*EndOfFor*/
		// choose a letter from the word.
		$a['letter'] = $a['word']{ mt_rand(0, $length-1)};

		for($i=0;$i < $length; ++$i) {
			$a['word'][$i] = mt_rand(0,2)<= 1 ? $a['word'][$i] : $a['letter'];
		}//EndOfFor
		// how often does letter appears in the word
		$this->result = substr_count( $a['word'], $a['letter']);
		$this->replace($a);
	} /*EndOfFunction*/

	/*
	 * Generates a empty_field type challenge.
	 *
	 * @since 1.0
	 */
	private function empty_field() {
		// easy job for us.
		$this->result = '';
		$this->replace( [] );
	} /*EndOfFunction*/

	/*
	 * Generates a reverse type challenge.
	 *
	 * @since 1.0
	 */
	private function reverse() {
		$a['word'] = '';
		$length = mt_rand(3, 4);

		for($i=0; $i < $length; ++$i) {
			$a['word'] .= chr( mt_rand(65, 90) );
		} /*EndOfFor*/
		$this->result = strrev($a['word']);
		$this->replace($a);
	} /*EndOfFunction*/

	/*
	 * Replaces the placeholder in the challenge text with the choosen arguments.
	 * After this method is call, the property $callenge should have the complete
	 * challenge.
	 *
	 * @param array $args The args, that the challenge is expected.
	 * @since 1.0
	 */
	private function replace($args) {
		$args['input_field'] = $this->getResultField();
		foreach($args as $key => $value) {
			$this->challenge = str_replace( '{'. $key .'}', $value, $this->challenge);
		} /*EndOfForeach*/
	} /*EndOfFunction*/

	/*
	 * Generates a id for this captcha and calls the method saveInSession to save
	 * the data. The method getChaptcha is calling this method.
	 *
	 * @since 1.0
	 */
	private function saveResult() {
		$id = $this->generateRandomString();

		// check if this id is already in use.
		// if so, make a recursion.
		if( is_array($this->getFromSession($id) ) ) {
			return $this->saveResult();
		} /*EndOfIf*/
		$this->saveInSession(array('result' => $this->result, 'timestamp' => time() ), $id);
		$this->challenge .= '<input type="hidden" name="'. $this->nameOfHiddenField .'" value="'. $id .'" />';
	} /*EndOfFunction*/

	/*
	 * Generates a random string with a specific length from a character set of
	 * [A-Za-z0-9].
	 *
	 * @param int $length The length of the string to generate.
	 * @return string the randomly generated string.
	 * @since 1.0
	 */
	private function generateRandomString($length = 8) {
		$a = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G',
			'H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y',
			'Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q',
			'r','s','t','u','v','w','x','y','z'];
		$str = '';
		$count = count($a)-1;
		for($i=0;$i<$length; ++$i) {
			$str .= $a[ mt_rand(0, $count) ];
		} /*EndOfFor*/
		return $str;
	} /*EndOfFunction*/

	/*
	 * Includes the numberToString file for translating integers to strings.
	 *
	 * @throws exception, when the file can not be loaded.
	 * @since 1.0
	 */
	private function importNumberToStringFile() {
		$path = $this->pathToClassDir . $this->langDir .'/'. $this->language .'/__number_to_string.php';
		if(file_exists($path) ) {
			include($path);
		} else {
			throw new ErrorException("Cant't find $path.", 1);
		} /*EndOfElse*/
	} /*EndOfFunction*/

	/**
	 * Returns a customized result field. The result field is the field, where the
	 * user must enter the solution of the captcha.
	 *
	 * @return string the customized input field
	 * @since 1.0
	 */
	private function getResultField() {
		$inputField = '<input type="text" name="'. $this->nameOfResultField .'" ';
		foreach( $this->inputFieldAttributes as $attribute => $value) {
			$inputField .= $attribute .'="'. $value .'" ';
		}
		$inputField .= '/>';
		return $inputField;
	}

	/*
	 * loads the config file and calls for every defined option the setMethod.
	 * @param string $pathToConfig the relative Path to the config file.
	 * @since 1.0
	 */
	protected function loadConfig($path='config.php') {
		$path = $this->pathToClassDir . $path;
		if(file_exists($path) ) include($path);
		else return;;
		foreach($config as $key => $value) {
			// make a correct setMethod from the string.
				$key = 'set'. ucfirst($key);
			if(method_exists($this, $key) ) {
		$this->$key($value);
			}//EndOfIf
		} //EndOfForeach
	}//EndOfMethod.

	// debug section.
	public function debug() {
		// scan the language dir.
		$languages = scandir($this->langDir);
		$langDir = $this->langDir .'/';

		foreach($languages as $dir) {
			if($dir == '.' || $dir == '..') continue;
			$path = $langDir . $dir;
			if(is_dir($path) ) {
				echo '<li>Checking folder '. $path .'</li>';
				$this->checkFiles($path);
			} /*EndOfIf*/
			else {
				echo '<li>Error: '. $path ."isn't a directory.</li>";
			} /*EndOfElse*/
		}/*EndOfForeach*/
		echo '</ul>';
	} /*EndOfFunction.*/

	private function checkFiles($path) {
		echo "<ul>";
		foreach($this->challengeList as $type) {
			$file = $path .'/'. $type .'.php';
			if(file_exists($file) ) {
				echo '<li>Checking file: '. $file .'</li>';
				$this->checkTemplate($file, $type);
			} /*EndOfIf*/
			else {
				echo "<li>Error: can't find file ". $path ."</li>";
			} /*EndOfElse*/
		} /*EndOfForeach*/
		echo "<ul>";
	} /*EndOfFunction*/

	private function checkTemplate($path, $type) {
		echo '<ul>';
		include($path);
		if(isset($challenge) && is_array($challenge) && count($challenge) > 0) {
			$this->checkPlaceholder($challenge, $type);
		} /*EndOfIf*/
		else {
			echo "<li>Error! Can't find the array 'challenge'</li>";
		} /*EndOfElse*/
		echo '</ul>';
	} /*EndOfFunction*/

	private function checkPlaceholder($c, $type) {
		switch($type) {
			case 'add' :
			case 'mul' : $p = ['arg1', 'arg2']; break;
			case 'sub' : $p = ['minuend', 'subtrahend']; break;
			case 'div' : $p = ['dividend', 'divisor']; break;
			case 'estimate' : $p = ['arg1', 'arglist']; break;
			case 'count' : $p = [ 'letter', 'word' ]; break;
			case 'reverse' : $p = [ 'word' ]; break;
			case 'empty_field' : $p = []; break;
		}/*EndOfSwitch*/
		$p[] = 'input_field';

		for($i=0; $i < count($c); ++$i) {
			$check = true;
			$missingField = array();
			foreach($p as $key) {
				if(substr_count($c[$i], $key) == 0) {
					$missingField[] = "{$key}";
					$check = false;
				}/*EndOfIf*/
			} /*EndOfForeach*/
			// If we have an error in this field, we show the content.
			// the user can search for the phrase.
			if(!$check) echo "<li>Error: In field $i ". implode(', ', $missingField) ." is missing. Look for ". $c[$i] ."</li>";
		} /*EndOfFor*/
	}/*EndOfFunction*/
} /*EndOfClass*/
