<?php
	include 'language/lang.pt.php';

	$params = [
		/* MySQL Connection Properties
		 * Options to initialize the connection with your Database.
		*/
		'mysql.host' => '131.196.198.157', // Host of your Database
		'mysql.username' => 'oraphaleao', // User of your Database
		'mysql.port' => '3306', // Port used to connection of your Database
		'mysql.password' => 'Mik@el9568', // Password of your Database
		'mysql.database' => 'sell', // Name of your Database
		'mysql.params' => ';charset=utf8', // Params used on the connection of MySQL


		/* System of your CMS 
		 * Used to know the "PATH" of your OS.
		 * @Options: Windows / Linux / MacOS
		*/
		'system.operator' => 'Windows',


		/* Options of Site in itself
		 * Have options of CMS.
		*/
		'site_name' => 'Havana', // Name of your Website
		'site_description' => '', // Brief description about your site.
		'site_description_meta' => '', // Description of your site to go into meta tags.
		'site_keywords' => '', // Keywords to putinto meta tags.
		'site_theme' => 'havana', // Theme that you will use on your website.
		'site_closed' => false, // Determines if your Site is closed or not.
		'site_url' => 'http://127.0.0.1', // Without the slash at the end.
		'site_language' => 'pt', // Language you will use on your website.
		'site_cloudflare' => false, // Determines if will pick IP of "REMOTE_ADDR" or IP delivered by CloudFlare.

		/**
		 * Options to Whitelist
		 */
		'whitelist_count_hits' => 15, // Determines the quantity of answers u need to hit
	];

	$params += [
		/* System Configs
		 * Here goes some System variables used over the CMS.
		*/
		'site_full_url' => $params['site_url'] . '/tpl/' . $params['site_theme'], // Used to shorten the url at template system.

		/* External Sites Options
		 * Here goes some options like Recaptcha and Discord.
		*/
		'hcaptcha_enabled' => false, // Determines if recaptcha at register is enabled or not.
		'hcaptcha_secret_key' => '0x7923903B0d6a449C95553845dF0B3a56a7D7856F', // Secret key offered by the Recaptcha.
		'hcaptcha_public_key' => 'd3278620-d250-4de7-a00f-56fa591066bc', // Public key offered by the Recaptcha (Used at template System). 
		'discord_url' => 'https://discord.gg/tWG43YyDvV', // Used on discord widget. (If empty, will be disabled at template system).
	];

?>
