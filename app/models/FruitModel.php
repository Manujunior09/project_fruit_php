<?php 

namespace models ;

require_once __DIR__.'/../config/Database.php';

class FruitModel {

    private $connexion;

    public function __construct() {
        $this->connexion = new \config\Database();
    }

    public function getAllFruits() {
        $db = $this->connexion->connect();
        $stmt = $db->query("SELECT * FROM fruits");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFruitById($id) {
        $db = $this->connexion->connect();
        $stmt = $db->prepare("SELECT * FROM fruits WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addFruit($fruit) {
        $db = $this->connexion->connect();
        $stmt = $db->prepare("INSERT INTO fruits (nom, prix, description, image, pouvoir, origine) VALUES (:nom, :prix, :description, :image, :pouvoir, :origine)"); 
        $stmt->execute(['nom' => $fruit['nom'], 'prix' => $fruit['prix'], 'description' => $fruit['description'], 'image' => $fruit['image'], 'pouvoir' => $fruit['pouvoir'], 'origine' => $fruit['origine']]);
        return $db->lastInsertId();

    }

    public function updateFruit($id, $fruit) {

    }

    public function deleteFruit($id) {

    }





}
