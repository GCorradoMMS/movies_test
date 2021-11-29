<?php

class Database {
    
    private $host = 'localhost';
    private $user = 'root';
    private $password = 'root';
    private $db = 'movies';
    private $port = 3306;
    private $conn;

    function __construct() {
        try {
            $this->conn = new \PDO(
                "mysql:host=$this->host;port=$this->port;charset=utf8mb4;dbname=$this->db",
                $this->user,
                $this->password
            );
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getConn()
    {
        return $this->conn;
    }

    public function getHost()
    {
        return $this->host;
    }
}