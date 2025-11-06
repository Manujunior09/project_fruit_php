<?php

// Démarrage de la session nécessaire pour l'authentification
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require_once __DIR__ . '/../core/Router.php';

require_once __DIR__ . '/../routes/web.php';
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
 

$routes = $router->getRoutes();


$router->dispatch($method, $path);

?>