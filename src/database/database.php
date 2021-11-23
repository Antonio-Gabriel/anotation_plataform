<?php

class Database {
    
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "book_anotation_db";
    private $connection = Null;

    public function  __construct()
    {
        $this->connection = new PDO("mysql:host={$this->servername};dbname={$this->database}",
            $this->username, $this->password
        );

        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
    }

    public function connect() {
        return $this->connection;
    }

}