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

    public function findById(int $id): ?Contact {
        $connection = $this->db->getConnection();
        if ($connection === null) {
            return null;
        }
        $stmt = $connection->prepare("SELECT * FROM contact WHERE contact_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($data) {
            return new Contact($data);
        }
        return null;
    }

    public function create(string $name, string $email, string $phoneNumber): void {
        $connection = $this->db->getConnection();
        if ($connection === null) {
            return;
        }
        $stmt = $connection->prepare("INSERT INTO contact (contact_name, contact_email, contact_phone_number) VALUES (:name, :email, :phone)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phoneNumber);
        $stmt->execute();
    }

}