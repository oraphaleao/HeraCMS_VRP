<?php

namespace HeraCMS\Model;

use HeraCMS;

class Input {
	public static function IsFilled() //TODO: multiple posts
	{
		$input = func_get_args();

		foreach ($input as $key) {
			if(!isset($_POST[$key]) || trim($_POST[$key]) == '') 
				return false;
		}
		return true;
		//return trim($_POST[$post]) != '' && isset($_POST[$post]);
	}

	/**
	 * Save the form fields in a session
	 */
	public static function saveFields()
	{
		$fields = func_get_args();

		$_SESSION['savedfields'] = $fields;
	}

	/**
	 * Get the saved form fields
	 * @return {mixed} $returnvalues The saved form fields | false: there are no form fields saved
	 */
	public static function setSavedFields()
	{
		if(isset($_SESSION['savedfields'])) {
			$returnvalues = $_SESSION['savedfields'][0]; //TODO: remove the [0]
			unset($_SESSION['savedfields']);
			return $returnvalues;
		}
		return false;
	}

	/**
	 * Check a date input
	 * return {boolean} True: the date is right | False: it is not
	 */
	public static function checkDate(array $birth)
	{
		foreach ($birth as $value) {
			if(!is_numeric($value))
				return false;
		}
		return true;
	}
}

?>