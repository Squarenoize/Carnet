<?php
class DBConnect {
    static private string $host = "localhost";
    static private string $username = "root";
    static private string $password = "";
    static private string $database = "carnet";
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