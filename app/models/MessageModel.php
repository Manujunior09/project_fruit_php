<?php

namespace models;

require_once __DIR__.'/../config/Database.php';

class MessageModel {

    private $connexion;

    public function __construct() {
        $this->connexion = new \config\Database();
    }

    public function create($userId, $subject, $content){
        $db = $this->connexion->connect();
        $stmt = $db->prepare("INSERT INTO messages (user_id, subject, content) VALUES (:user_id, :subject, :content)");
        $stmt->execute(['user_id' => $userId, 'subject' => $subject, 'content' => $content]);
        return $db->lastInsertId();

    }

    public function getAllMessages(){
        $db = $this->connexion->connect();
        // Jointure avec la table users pour récupérer le nom d'utilisateur
        $stmt = $db->prepare("SELECT m.*, u.username 
                             FROM messages m
                             JOIN users u ON m.user_id = u.id
                             ORDER BY m.created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByUserId($userId) {
        $db = $this->connexion->connect();
        $stmt = $db->prepare("SELECT messages.*, users.username 
                             FROM messages 
                             LEFT JOIN users ON messages.user_id = users.id 
                             WHERE messages.user_id = :user_id 
                             ORDER BY messages.id DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}