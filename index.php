<?php
require_once "data/core.php";
$conn = Database::connection();

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$router = new Router();
$router->addRoute('/','dist/index.php');
$router->addRoute('/vtv','dist/productcode.php');
$router->addRoute('/htv','dist/productcode.php');
$router->addRoute('/p','dist/productcode.php');
$router->addRoute('/stats','dist/data.php');
$router->addRoute('/signout','dist/signout.php');
$router->route($uri);