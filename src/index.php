<?php



require_once './vendor/autoload.php';
require_once './routings/BaseRouter.php';
require_once './graphs/GraphQlListener.php';
use types\GraphQlListener;
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");


$graphServer = new GraphQlListener();
$graphServer->listen();
