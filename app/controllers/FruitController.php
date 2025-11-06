<?php

namespace controllers ;

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/FruitModel.php';

class FruitController extends Controller {

    private $fruitModel;

    public function __construct() {
    $this->fruitModel = new \models\FruitModel();

    }

    public function index() {
        $fruits = $this->fruitModel->getAllFruits();
        $this->view('fruits/index', ['fruits' => $fruits, 'title' => 'Accueil des Fruits']);

    }

    public function show($id) {
        $fruit = $this->fruitModel->getFruitById($id);
       $this->view('fruits/show', ['fruit' => $fruit, 'title' => 'Détail du Fruit']);


    }

    public function create() {
        $fruit = $this->fruitModel->addFruit($fruit);
         $this->view('fruits/create', ['title' => 'Ajouter un Fruit']);
    }


    

    public function edit($id) {
        $fruits = $this->fruitModel->updateFruit($id, $fruit);



    }

    public function delete($id) {
        $fruits = $this->fruitModel->deleteFruit($id);



    }


}
