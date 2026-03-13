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
    
    /**
     * Établit une connexion à la base de données en utilisant les paramètres définis dans la classe.
     * En cas d'échec de la connexion, un message d'erreur est stocké dans la propriété $userErrorMessage.
     * @return void
     */
    private function connect() {
        try {
            $this->connection = new PDO("mysql:host=" . static::$host . ";dbname=" . static::$database . ";charset=" . static::$charset, static::$username, static::$password);
        } catch (PDOException $e) {
            $this->userErrorMessage = "Erreur de connexion : " . $e->getMessage() . "\n";
            $this->connection = null;
        }
    }

    /**
     * Retourne la connexion à la base de données.
     * @return PDO|null La connexion PDO ou null si la connexion a échoué.
     */
    public function getConnection() {
        return $this->connection;
    }

    /**
     * Retourne le message d'erreur destiné à l'utilisateur en cas de problème de connexion.
     * @return string Le message d'erreur utilisateur.
     */
    public function getUserErrorMessage() {
        return $this->userErrorMessage;
    }
}