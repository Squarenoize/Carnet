<?php
require_once "Contact.php";

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
        $contactsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $contacts = [];
        foreach ($contactsData as $data) {
            $contacts[] = new Contact($data);
        }
        return $contacts;
    }

}