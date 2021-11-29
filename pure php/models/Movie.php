<?php

require_once(__ROOT__.'/config/Database.php'); 
require_once(__ROOT__.'/utils/Utils.php'); 

class Movie {

    private $table = 'movies';
    private $db = 'movies';
    private $conn;
    private $utils;

    function __construct()
    {
        $this->conn = new Database;
        $this->conn = $this->conn->getConn();
        $this->utils = new Utils;
    }

    public function create($input)
    {
        $statement = "
            INSERT INTO movies 
                (title, category, thumbnail, date_created, date_updated)
            VALUES
            (:title, :category, :thumbnail, :date_created, :date_updated);
        ";
        $input = json_decode( json_decode($input, true), true );
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(
                array(
                    'title' => $input[0]['title'],
                    'category' => $input[0]['category'],
                    'thumbnail' => $input[0]['thumbnail'],
                    'date_created' => date("Y-m-d H:i:s"),
                    'date_updated' => date("Y-m-d H:i:s"),
            ));
            $this->utils->successResponse($input[0]['title'], "Added!");
        } catch (\PDOException $e) {
            $this->utils->errorResponse();
            exit($e->getMessage());
        }    
    }

    public function all()
    {   
        $sql = "
            SELECT * FROM movies.movies;
        ";

        try {
            $result = $this->conn->query($sql);
            $result = $result->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            $this->utils->errorResponse();
            exit($e->getMessage());
        }
    }

    public function update($input, $id)
    {
        $statement = "
            UPDATE movies.movies
            SET 
                title = :title,
                category = :category,
                thumbnail = :thumbnail,
                movie_id = :movie_id,
                date_updated = :date_updated
            WHERE movie_id = :movie_id;
        ";
    
        $input = json_decode( json_decode($input, true), true );
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'movie_id' => (int) $id,
                'title' => $input[0]['title'],
                'category' => $input[0]['category'],
                'thumbnail' => $input[0]['thumbnail'],
                'date_updated' => date("Y-m-d H:i:s"),
            ));
            $this->utils->successResponse($input[0]['title'], "Updated!");
        } catch (\PDOException $e) {
            $this->utils->errorResponse();
            exit($e->getMessage());
        }    
    }

    public function delete($id) 
    {
        $statement = "
            DELETE FROM movies.movies
            WHERE movie_id = :movie_id;
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array('movie_id' => $id));
            $this->utils->successResponse("Movie", "Deleted!");
        } catch (\PDOException $e) {
            $this->utils->errorResponse();
            exit($e->getMessage());
        }  
    }

    public function get($id) 
    {
        $statement = "
            SELECT * FROM movies.movies
            WHERE movie_id = :movie_id;
        ";

        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array('movie_id' => $id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            $this->utils->errorResponse();
            exit($e->getMessage());
        }  
    }

    public function migrate()
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
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $this->utils->successResponse("Migration", "Success!");
        } catch (\PDOException $e) {
            $this->utils->errorResponse();
            exit($e->getMessage());
        }  
    }
}