<?php
require_once "Contact.php";

class ContactManager {
    private DBConnect $db;
    
    /**
     * Constructeur de la classe ContactManager.
     * @param DBConnect $db Une instance de DBConnect pour gérer la connexion à la base de données.
     */
    public function __construct(DBConnect $db) {
        $this->db = $db;
    }

    /**
     * Récupère tous les contacts de la base de données.
     * @return Contact[] Un tableau de contacts.
     */
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

    /**
     * Trouve un contact par son ID.
     * @param int $id L'ID du contact à trouver.
     * @return Contact|null Le contact trouvé ou null s'il n'existe pas.
     */
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

    /**
     * Crée un nouveau contact dans la base de données.
     * @param string $name Le nom du contact.
     * @param string $email L'email du contact.
     * @param string $phoneNumber Le numéro de téléphone du contact.
     * @return void
     */
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

    /**
     * Supprime un contact de la base de données en fonction de son ID.
     * @param int $id L'ID du contact à supprimer.
     * @return void
     */
    public function delete(int $id): void {
        $connection = $this->db->getConnection();
        if ($connection === null) {
            return;
        }
        $stmt = $connection->prepare("DELETE FROM contact WHERE contact_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

}