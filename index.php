<?php


define('ROOT', dirname(__FILE__));
require ROOT . '/Config/autoload.php';//must change to __DIR__ demo purpose only
$router = new App\Router();
$router->run();