<?php

ini_set('display_errors', true);

require_once __DIR__ . '/../vendor/Symfony/Component/HttpFoundation/UniversalClassLoader.php';

use Symfony\Component\HttpFoundation\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Umpirsky' => __DIR__ . '/../src'
));

$loader->register();