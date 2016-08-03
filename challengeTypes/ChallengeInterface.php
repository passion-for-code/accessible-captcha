<?php
namespace de\PassionForCode;

/**
 * Interface for challenges.
 * @author Mohammed Malekzadeh
 * @version 1.0
 */
interface ChallengeInterface {
	/**
	 * Generates the imput for the challenge template. 
	 * @return array The array is used for replacing the placeholder in the template with the given value. so key is the placeholder and value is the value for replacing.
	 */
	public function generateChallenge();
}//EndOfInterface.