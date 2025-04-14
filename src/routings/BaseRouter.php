<?php

class BaseRouter
{
    public static function route()
    {
       $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($uri ===  'shop') {
            echo 'asked for shops';
            //require_once 'controllers/UserController.php';
            //(new UserController())->getByEmail();
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
        }
    }
}
