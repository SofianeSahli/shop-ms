<?php



require_once './vendor/autoload.php';
require_once './routings/BaseRouter.php';
require_once './graphs/GraphQlListener.php';
require './models/Category.php';

use types\GraphQlListener;

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();



$graphServer = new GraphQlListener();
$graphServer->listen();
