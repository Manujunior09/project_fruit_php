<?php
namespace routes;

use core\Router;

$router = new Router() ;

$router->get('/',['FruitController','index'] );
$router->get('/register', ['AuthController', 'register']);
$router->post('/register', ['AuthController', 'registerPost']);
$router->get('/login', ['AuthController', 'login']);
$router->post('/login', ['AuthController', 'loginPost']);
$router->get('/logout', ['AuthController', 'logout']);
$router->get('/fruits/create', ['FruitController', 'create']);
$router->get('/fruits/{id}', ['FruitController', 'show']);
$router->get('/fruits/{id}/edit', ['FruitController', 'edit']); // Affiche le formulaire de modification
$router->post('/fruits', ['FruitController', 'realCreate']);
$router->post('/fruits/{id}', ['FruitController', 'update']); // Traite la mise à jour (via POST)
$router->post('/fruits/{id}/delete', ['FruitController', 'delete']); // Traite la suppression

?>