<?php
require_once 'lib/Router.php';
require_once 'app/controllers/PizzaApiController.php';

$router = new Router();

$router->addRoute('items',     'GET',  'PizzaApiController', 'getAll');
$router->addRoute('items/:id', 'GET',  'PizzaApiController', 'get');
$router->addRoute('items',     'POST', 'PizzaApiController', 'create');
$router->addRoute('items/:id', 'PUT',  'PizzaApiController', 'update');

$resource = $_GET['resource'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$router->route($resource, $method);