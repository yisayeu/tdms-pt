<?php
require_once 'cli-em.php';

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(
    array(
        'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
    )
);