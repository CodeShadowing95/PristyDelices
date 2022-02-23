<?php

session_start();


class DBController {
    // Database Connection properties
    protected $host = "127.0.0.1";
    protected $user = "root";
    protected $password = "";
    protected $database = "pristydelices";

    // Connection property
    public $conn = null;

    // Call constructor
    // Initialize the connection properties to mySQL database
    public function __construct() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            echo "Échec: ".$this->conn->connect_error;
        }
    }

    // Close the connection
    public function __destruct() {
        $this->closeConnection();
    }

    // Closing connection function
    protected function closeConnection() {
        // If the connection to the database is already set
        if ($this->conn != null) {
            $this->conn->close();
            $this->conn = null;
        }
    }
}