<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/library'),
    get_include_path(),
)));

require_once 'vendor/autoload.php';

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application.
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Bootstrap doctrine resource. 
$application->getBootstrap()->bootstrap(array('doctrine'));

$em = $application->getBootstrap()->getResource('doctrine')->getEntityManager();

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(
    array(
        'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
    )
);