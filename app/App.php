<?php

namespace HeraCMS;

use Xesau\SqlXS;
use Xesau\SqlXS\QueryBuilder as QB;

/**
 * We gonna use this class to make some functions to the system itself.
 */

class App
{
	/**
	 * Redirect the user to a page
	 * @param {string} $url The url which has to be loaded
	 * @todo Automatically set the url
	 */
	public static function Redirect($url)
	{
		global $params;

		@session_start();
		header("Location:" . $params['url'] . "/" .$url);
	}

	/**
	 * Put messages into the session variable
	 * @param {string} $type  The type of the message (error, success, warning, info)
	 * @param {string} $messge The message
	 * @param {array} $replacement Array with variables to replace
	*/
	public static function Message($type, $message, $replacement = null)
	{
		if(!is_null($replacement)) {
			foreach ($replacement as $string => $replace) {
				$message = preg_replace('/'.$string.'/i', $replace, $message);
			}
		}
		$_SESSION['messages'][] = ['type' => $type, 'message' => strip_tags($message, '<strong><em><br>')];

	}

	/**
	 * Create an error message
	 * @param {string} $title The title of the errorbox
	 * @param {string} $message The errormessage
	*/
	public static function Error($message, $title = 'Error')
	{
		echo '<div class="widget alone">' .
		'<header class="widget-header"><span class="title color-red">' . $title . '</span></header>' .
		'<div class="widget-content">' . $message . "</div>" .
		'</div>';
	}

	/**
	 * Get messages from the session to parse them into Twig
	 * @return {mixed} The messages | null
	*/
	public static function setMessages()
	{
		if(isset($_SESSION['messages']))
		{
			$messages = $_SESSION['messages'];
			unset($_SESSION['messages']);
			return $messages;
		}
		return null;
	}

	/**
	 * Get the real IP of User
	 * @return {string} The machine's IP
	 */
	public static function theIP()
	{
		global $params;
		
		return ($params['site_cloudflare'] ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR']);
	}

	/**
	 * Transform the response into "JSON"
	 * @param {array} All data
	 * 
	 * @return {array} The data converted into JSON
	 */
	public static function convertJSON($data = []) {
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET');
		header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
		header('Access-Control-Allow-Credentials: true');
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Content-Type: application/json; charset=utf-8');
		exit(json_encode($data));
	}
}
?>
