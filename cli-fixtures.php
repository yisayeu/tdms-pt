<?php
require_once 'cli-em.php';

use Doctrine\Common\DataFixtures\Loader;

$loader = new Loader();

$loader->loadFromDirectory(APPLICATION_PATH . '/../library/Tdms/DataFixture');

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

$purger = new ORMPurger();
$executor = new ORMExecutor($em, $purger);
$executor->execute($loader->getFixtures());