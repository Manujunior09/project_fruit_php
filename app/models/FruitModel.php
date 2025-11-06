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
        $db = $this->connexion->connect();

        $fields = [
            'nom' => $fruit['nom'],
            'prix' => $fruit['prix'],
            'description' => $fruit['description'],
            'pouvoir' => $fruit['pouvoir'] ?? null,
            'origine' => $fruit['origine'] ?? null,
        ];

        // On ajoute le champ 'image' à la mise à jour SEULEMENT si un nouveau nom d'image est fourni
        if (isset($fruit['image'])) {
            $fields['image'] = $fruit['image'];
        }

        $setClauses = [];
        foreach (array_keys($fields) as $field) {
            $setClauses[] = "$field = :$field";
        }
        $sql = "UPDATE fruits SET " . implode(', ', $setClauses) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        $fields['id'] = $id; // Ajouter l'ID pour le WHERE
        $stmt->execute($fields);
        return $stmt->rowCount();

    }

    public function deleteFruit($id) {
        $db = $this->connexion->connect();
        $stmt = $db->prepare("DELETE FROM fruits WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }
}
