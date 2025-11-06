<?php
namespace core;

class Router {
    private $routes = [
        //Pour chaque méthode HTTP, on stocke les routes dans un tableau associatif, où la clé est le chemin et la valeur est l'action (contrôleur et méthode).
        "GET" => [],
        "POST" => [],
        "PUT" => [],
        "DELETE" => []
    ];


    public function get($path, $action) {
        $this->routes["GET"][$path] = $action;
    }

    public function post($path, $action) {
        $this->routes["POST"][$path] = $action;
    }
    public function put($path, $action) {
        $this->routes["PUT"][$path] = $action;
    }
    public function delete($path, $action) {
        $this->routes["DELETE"][$path] = $action;
    }
    

    //Permet d'enregistrer une route 
    public function getRoutes() {
        return $this->routes;
    }

    private function resolve($method, $uri) {
        foreach ($this->routes[$method] as $path => $action) {
            // Transformer /projects/show/{id} en regex
            $pattern = preg_replace('#\{([\w]+)\}#', '([^/]+)', $path);
            $pattern = "#^" . $pattern . "$#";

            // Tester si l'URL correspond
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Supprimer la route complète du tableau
                // Retourner le controller, la méthode et les paramètres capturés
                return [$action[0], $action[1], $matches];
            }
        }
        return false;
    }


    public function dispatch($method, $path) {
        $action = $this->resolve($method, $path);

    if ($action) {
        [$controllerName, $methodName, $params] = $action;

        // Charger le fichier du contrôleur
        require_once __DIR__ . "/../controllers/{$controllerName}.php";

        // Nom complet de la classe avec namespace
        $fqcn = "Controllers\\{$controllerName}";
        $controller = new $fqcn();

        // Appeler la méthode en passant les paramètres dynamiques
        return $controller->$methodName(...$params);
    } else {
        http_response_code(404);
        echo "404 Not Found";
    }
}

}