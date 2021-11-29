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

    public function setup_migration($db)
    {
        if ($this->conn->select_db($db) === false) {
            $this->migration();
            echo('Created');
        }
    }

    public function migration()
    {
        $sql = "
        DROP TABLE IF EXISTS `movies`;
        /*!40101 SET @saved_cs_client     = @@character_set_client */;
        /*!50503 SET character_set_client = utf8mb4 */;
        CREATE TABLE `movies` (
          `title` varchar(100) DEFAULT NULL,
          `category` varchar(100) DEFAULT NULL,
          `thumbnail` varchar(100) DEFAULT NULL,
          `movie_id` bigint NOT NULL AUTO_INCREMENT,
          `date_created` datetime DEFAULT NULL,
          `date_updated` datetime DEFAULT NULL,
          PRIMARY KEY (`movie_id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
            ";
        
        try {
            $result = $this->conn->exec($sql);
            echo "Success!\n";
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