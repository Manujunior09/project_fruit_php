<?php

namespace models ;

require_once __DIR__.'/../config/Database.php';

class UserModel {

    private $connexion;

    public function __construct() {
        $this->connexion = new \config\Database();
    }

    public function createUser($username, $email, $passwordHash, $role = 'user') {
        $db = $this->connexion->connect();
        $stmt = $db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $passwordHash, 'role' => $role]);
        return $db->lastInsertId();
    }

    public function findByUsername($username) {
        $db = $this->connexion->connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findByEmail($email) {
        $db = $this->connexion->connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $db = $this->connexion->connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
