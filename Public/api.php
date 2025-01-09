<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller;
use Firebase\Factory;

$firebase = (new Factory)->withServiceAccount(__DIR__ . '/../config/firebase_config.json');
$controller = new Controller($firebase);

$controller->handleRequest();

