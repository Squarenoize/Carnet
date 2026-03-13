<?php

class ContactManager {
    private DBConnect $db;

    public function __construct(DBConnect $db) {
        $this->db = $db;
    }

    public function findAll(): array {
        $connection = $this->db->getConnection();
        if ($connection === null) {
            return [];
        }
        $stmt = $connection->query("SELECT * FROM contact");
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $contacts;
    }

}