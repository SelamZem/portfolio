<?php

class Database {
    private $host = 'localhost';        // Database host (use 'localhost' if running XAMPP locally)
    private $db_name = 'portfolio_db';  // Your database name here
    private $username = 'root';         // Default XAMPP username is 'root'
    private $password = '';             // Default XAMPP password is empty
    private $conn;                      // PDO connection variable

    // Constructor (optional for flexibility in environment variables)
    public function __construct($host = null, $db_name = null, $username = null, $password = null) {
        // Allow for dynamic configuration if parameters are passed
        if ($host) $this->host = $host;
        if ($db_name) $this->db_name = $db_name;
        if ($username) $this->username = $username;
        if ($password) $this->password = $password;
    }

    // Method to establish a connection with the database
    public function getConnection() {
        $this->conn = null;  // Set connection to null initially

        try {
            // Create a new PDO connection
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            // Set PDO attributes for error handling and emulation
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exception) {
            // Catch any connection errors and display them
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;  // Return the PDO connection object
    }

    // Method to close the connection (optional)
    public function closeConnection() {
        $this->conn = null;  // Close the connection by setting to null
    }
}

?>
