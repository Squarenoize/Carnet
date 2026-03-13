<?php
require_once "config.php";
class DBConnect {
    static private string $host = DB_HOST;
    static private string $username = DB_USER;
    static private string $password = DB_PASSWORD;
    static private string $database = DB_NAME;
    static private string $charset = "utf8mb4";
    private ?PDO $connection = null;
    private string $userErrorMessage = "";

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->connection = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$database . ";charset=" . self::$charset, self::$username, self::$password);
        } catch (PDOException $e) {
            $this->userErrorMessage = "Erreur de connexion : " . $e->getMessage() . "\n";
            $this->connection = null;
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function getUserErrorMessage() {
        return $this->userErrorMessage;
    }
}