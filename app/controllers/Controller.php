<?php

namespace controllers ;

class Controller {

    public function view ($path, $data = []){
        extract($data);
        ob_start();
        require_once __DIR__ . "/../views/{$path}.php";
        $content = ob_get_clean();
        require_once __DIR__ . "/../views/layout/defaultLayout.php";


    }
}