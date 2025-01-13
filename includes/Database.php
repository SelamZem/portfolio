<?php

class Database {
    private $host = 'localhost';        
    private $db_name = 'portfolio_db';  
    private $username = 'root';        
    private $password = '';             
    private $conn;                      

   
    public function __construct($host = null, $db_name = null, $username = null, $password = null) {
        if ($host) $this->host = $host;
        if ($db_name) $this->db_name = $db_name;
        if ($username) $this->username = $username;
        if ($password) $this->password = $password;
    }

  
    public function getConnection() {
        $this->conn = null;  

        try {
           
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
       
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;  
    }
    public function closeConnection() {
        $this->conn = null;  // Close the connection by setting to null
    }
}

?>
