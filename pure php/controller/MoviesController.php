<?php

require_once(__ROOT__.'/models/Movie.php'); 

class MoviesController {
    private $movie;
    
    function __construct() {
        $this->movie = new Movie;
    }

    public function all()
    {
        return $this->movie->all();
    }

    public function get($id)
    {
        return $this->movie->get($id);
    }
    
    public function create($data)
    {
        return $this->movie->create($data);
    }
    
    public function update($data, $id)
    {
        return $this->movie->update($data, $id);
    }

    public function delete($id) 
    {
        return $this->movie->delete($id);
    }
    
    public function migrate() 
    {
        return $this->movie->migrate();
    }
}