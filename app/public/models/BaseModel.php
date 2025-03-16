<?php
// app/public/models/BaseModel.php

class BaseModel
{
    protected static $pdo;
    protected $db;  // Instance property for convenience

    function __construct()
    {
        if (!self::$pdo) {
            $host = $_ENV["DB_HOST"];
            $db   = $_ENV["DB_NAME"];
            $user = $_ENV["DB_USER"];
            $pass = $_ENV["DB_PASSWORD"];
            $charset = $_ENV["DB_CHARSET"];

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("Database connection error: " . $e->getMessage());
            }
        }
        // Now assign the static PDO to an instance property for easier use:
        $this->db = self::$pdo;
    }
    public function query($sql, $params = []) {
        $statement = self::$pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }
}
