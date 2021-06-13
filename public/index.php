<?php
require '../vendor/autoload.php';
require '../class/Rooter/Rooter.php';
use App\Rooter\Rooter;

$uri = (string)$_SERVER['REQUEST_URI'];

$rooter = new Rooter($uri);
$rooter->setSiteName('PHP Public Class');
$content = $rooter->root();
$pageTitle = $rooter->getPageTitle();
$desc = $rooter->getPageDesc();

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements/html.php';