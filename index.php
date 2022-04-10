<?php

/**
 * HeraCMS
 * @author Raphael Leão
 * @version 1.5
 */

namespace HeraCMS;

use PDO;
use Twig;
use Xesau\Router;
use Xesau\SqlXS;
use Xesau\SqlXS\QueryBuilder as QB;
use HeraCMS\Model;

/**
 * Let's verify is have session started here, if have, let's proceed.
 */
if (!session_start()) {
	session_start();
}

/**
 * Here we gonna display some errors, just to development purpose.
 */
ini_set('display_errors', 1);

/**
 * Here we gonna define some Constants to our system works perfectly.
 * (We gonna force some options of PHP too).
 */
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Sao_Paulo');
define('ROOT', dirname(__FILE__));
define('CONTROLLER', __NAMESPACE__ . '\\Controller');

/**
 * Getting the configuration file.
 */
require_once ROOT . '/heraConfig.php';


/**
 * Configurating the autoloader
 */
if ($params['system.operator'] === 'MacOS' || $params['system.operator'] === 'Linux') {
	spl_autoload_register(function ($className) {
		$className = str_replace(['\\', '/', '_'], DIRECTORY_SEPARATOR, $className);

		if (($pos = strpos($className, 'HeraCMS/')) === 0 && $className = substr($className, $pos + strlen('HeraCMS/'))) {
			$path = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $className . '.php';
		} else {
			$path = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . $className . '.php';
		}

		if (is_readable($path)) include_once $path;

		else exit('Could not load class from ' . $path);
	});
} elseif ($params['system.operator'] === 'Windows') {
	spl_autoload_register(function ($className) {
		$className = str_replace(['/', '\\', '_'], DIRECTORY_SEPARATOR, $className);

		if (($pos = strpos($className, 'HeraCMS\\')) === 0 && $className = substr($className, $pos + strlen('HeraCMS\\')))
			$path = __DIR__ . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . $className . '.php';
		else
			$path = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . $className . '.php';
		if (is_readable($path))

			include_once $path;
		else
			exit('Could not load class from ' . $path);
	});
} else {
	exit('Could not load this Operation System');
}


/**
 * Try to create a new PDO connection.
 * Thanks again to Xesau to this wonderful and simple library.
 * @author Aron Van Willigen (Xesau)
 */
try {
	$pdo = new PDO('mysql:dbname=' . $params['mysql.database'] . $params['mysql.params'] . ';port=' . $params['mysql.port'] . ';host=' . $params['mysql.host'], $params['mysql.username'], $params['mysql.password']);
} catch (\PDOexception $ex) {
	App::Error('Couldn\'t connect to the mysql server with details: <br />' . $ex->getMessage(), 'Database connection error');
}
\Xesau\SqlXS\XsConfiguration::init($pdo);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/**
 * Create the file system constructor
 */
$loader = new \Twig_Loader_Filesystem('tpl/' . $params['site_theme'], [
	'debug' => true,
	'cache' => false
]);
$twig = new \Twig_Environment($loader);

$twig->addExtension(new \Twig_Extension_Debug());
$twig->addExtension(new Twig\Extension\StrftimeExtension());
setlocale(LC_ALL, 'pt_BR');

$twig->addFilter(new \Twig_SimpleFilter('lcfirst', 'lcfirst'));
$twig->addFilter('preg_replace', new \Twig_Filter_Function(function ($subject, $pattern, $replacement) {
	return preg_replace($pattern, $replacement, $subject);
}));
$twig->addFilter('var_dump', new \Twig_Filter_Function('var_dump'));

// Setting Timezone on the template system.
$twig->getExtension('core')->setTimezone('America/Sao_Paulo');

/**
 * 1. Get the language file if it is readable
 * 2. Get the page content file if it is readable and apply it to Twig
 */
if (is_readable(ROOT . '/language/lang.' . $params['site_language'] . '.php')) {
	$language = include_once ROOT . '/language/lang.' . $params['site_language'] . '.php';

	$params += [
		'lang' => $lang
	];
}


// Here we gonna define some variables to use over the entire template system.
$params += [
	'messages' => App::setMessages(),
	'savedvalues' => Model\Input::setSavedFields(),
	'app' => new App
];


/**
 * Configurating the router.
 * @author Aron Van Willigen (Xesau)
 */
$router = new Router(function () {
	global $twig, $params, $lang;
});

/**
 * Here goes all Requests of Router to the outside world.
 */
$router->get('/index|/', [CONTROLLER . '\\PageController', 'viewIndex']);
$router->get('/', [CONTROLLER . '\\PageController', 'viewIndex']);
$router->get('/whitelist', [CONTROLLER . '\\PageController', 'viewWhitelist']);

/**
 * Here goes all Posts of Router to the outside world.
 */
$router->post('/whitelist', [CONTROLLER . '\\WhitelistController', 'postWhitelist']);

/**
 * Here the magic happens and everything appears to user. 
 */
$router->dispatchGlobal();
