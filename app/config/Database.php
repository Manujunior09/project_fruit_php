<?php

namespace config ;

class Database {
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;


    public function __construct() {
        $this->db_host = $_ENV['DB_HOST'];
        $this->db_name = $_ENV['DB_NAME'];
        $this->db_user = $_ENV['DB_USER'];
        $this->db_pass = $_ENV['DB_PASS'];
    }

    public function connect () {

        $dsn = "mysql:host=$this->db_host;dbname=$this->db_name;charset=utf8";
        
        try {
            $conn = new \PDO($dsn, $this->db_user, $this->db_pass);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            // echo "Connexion à la base de données réussie !";
            return $conn;

        } catch(\PDOException $e) {
            echo "Error connecting to database: " . $e->getMessage();
            exit();
        }

    }

}
