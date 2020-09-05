<?php
require '../vendor/autoload.php';
require '../class/Rooter/Rooter.php';
use App\Rooter\Rooter;

$uri = (string)$_SERVER['REQUEST_URI'];

$rooter = new Rooter();
$content = $rooter->root($uri);
$pageTitle = $rooter->getPageTitle();
//$header = $rooter->getHeader();

//$rooter->login();

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements/html.php';