<?php
class Db
{
    protected $servername;
    protected $username;
    protected $password;
    protected $database;
    public $conn;

    public function __construct()
    {
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->database = "hariyali";

        // Create a new mysqli object
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

        // Check for connection errors
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }

        // Confirm the connection is a valid mysqli object
        if ($this->conn instanceof mysqli) {
            echo "Database connected<br>";
        } else {
            die("Database connection is not a valid mysqli object.<br>");
        }
    }
}
