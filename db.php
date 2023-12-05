<?php

class DatabaseConnection
{
    private static $instance;
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    private function __construct($servername, $username, $password, $dbname)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public static function getInstance($servername, $username, $password, $dbname)
    {
        if (!self::$instance) {
            self::$instance = new self($servername, $username, $password, $dbname);
        }
        return self::$instance;
    }

    public function connect()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

// Usage example:

$servername = "localhost";
$username = "root";
$password = "123";
$dbname = "study-support";

$dbConnection = DatabaseConnection::getInstance($servername, $username, $password, $dbname);

$dbConnection->connect();

$connection = $dbConnection->getConnection();
