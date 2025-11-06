<?php
namespace routes;

use core\Router;

$router = new Router() ;

$router->get('/',['FruitController','index'] );
$router->get('/fruits/{id}', ['FruitController', 'show']);
$router->post('/fruits', ['FruitController', 'create']);
$router->put('/fruits/{id}', ['FruitController', 'edit']);
$router->delete('/fruits/{id}', ['FruitController', 'delete']);

?>