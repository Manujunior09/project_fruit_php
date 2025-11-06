<?php 

namespace models ;

require_once __DIR__.'\config\Database.php';

class FruitModel {

    private $connexion;

    public function __construct() {
        $this->connexion = new Database();
    }

    public function getAllFruits() {

    }

    public function getFruitById($id) {

    }

    public function addFruit($fruit) {

    }

    public function updateFruit($id, $fruit) {

    }

    public function deleteFruit($id) {

    }





}
