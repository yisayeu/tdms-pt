<?php
function d()
{
	foreach (func_get_args() as $arg) {
		if ($arg instanceof \Doctrine\ORM\QueryBuilder) {
			$arg = $arg->getDQL();

			foreach (array('SELECT', 'FROM', 'LEFT JOIN', 'WHERE') as $sqlPart) {
				$arg = str_replace($sqlPart, PHP_EOL . $sqlPart . PHP_EOL, $arg);
			}
		}

		echo '<pre>';
		print_r($arg);
		echo '</pre>';
	}
}

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once '../vendor/autoload.php';

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();