<?php 

namespace HeraCMS\Controller;

use PDO;
use HeraCMS;
use HeraCMS\Twig;
use HeraCMS\Model;
use Xesau\SqlXS\QueryBuilder as QB;

class PageController {

	/* The default page of Website */
	public static function viewIndex() {
		global $params, $twig;

		$params += [
			'page' => 'index',
			'parent' => null,
			'title' => 'Início'
		];

		echo $twig->render('index.html', $params);
	}

	/* Page of Whitelist */
	public static function viewWhitelist() {
		global $params, $twig;

		$params += [
			'page' => 'whitelist',
			'parent' => null,
			'title' => 'Fazer Whitelist'
		];

		echo $twig->render('whitelist.html', $params);
	}
}