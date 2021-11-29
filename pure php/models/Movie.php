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

}