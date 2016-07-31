<?php
/* change this to your Favorite default language.
 * If the setLanguage method is call with an unsupported language
 * or with any language,
 * it will use this value.
 * So be sure that this language exists.
 */
$config['language'] = 'german';

/* here you can modify the input_field attributes, where the user enters the solution. 
 * the key is the attributeName and the value the attributeValue;
 * e. g. 'size'=> 4 ends in size="4"
 */
$config['inputFieldAttributes'] = array('size' => 4);

/*
 * put here the name of the input field where the user enters the solution.
 */
$config['nameOfResultField'] = 'pfc_captcha_result';

/*
 * Put here the name of the hidden field, where the captcha id is stored.
	 */
$config['nameOfHiddenField'] = 'pfc_captcha_id';
/*
 * put here the name of the challengeTypes that you want use. delete those that you don't want use.
 * If you want use all, so pass the String 'all', instead an array.
 */
$config['challengeList'] = array("add", "sub", "mul", "div", "estimate", "count",
		"reverse");

/*
 * put here the name of a not used session variable. We need this for storing captcha informations in it.
 */
$config['sessionVarName'] = 'AccessibleCaptchaId';

// the language directory.
$config['langDir'] = 'language';