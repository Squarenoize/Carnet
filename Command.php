<?php
require_once "ContactManager.php";

class Command {
    private DBConnect $db;

    public function __construct(DBConnect $db) {
        $this->db = $db;
    }

    public function list() {
        $contactManager = new ContactManager($this->db);
        $contacts = $contactManager->findAll();
        foreach ($contacts as $contact) {
            echo $contact . "\n";
        }
    }

    public function detail(int $id = null) {
        if ($id === null) {
            echo "Veuillez fournir un ID pour afficher les détails d'un contact.\n";
            return;
        }
        $contactManager = new ContactManager($this->db);
        $contact = $contactManager->findById($id);
        if ($contact) {
            echo $contact . "\n";
        } else {
            echo "Contact avec l'id " . $id . " non trouvé.\n";
        }
    }

    public function create() {
        $line = readline("Entrez votre contact à créer : (format : name,email,phoneNumber) ");
        $parts = explode(",", $line);
        if (count($parts) === 3) {
            
            $name = trim($parts[0]);
            $email = trim($parts[1]);
            $phoneNumber = trim($parts[2]);

            // Validation basique
            if (empty($name) || empty($email) || empty($phoneNumber)) {
                echo "Tous les champs sont requis.\n";
                return;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Email invalide.\n";
                return;
            }
            if (!preg_match('/^\d{10}$/', $phoneNumber)) {
                echo "Le numéro doit contenir exactement 10 chiffres.\n";
                return;
            }

            $contactManager = new ContactManager($this->db);
            $contactManager->create($name, $email, $phoneNumber);
            echo "Contact créé avec succès.\n";

        } else {
            echo "Format incorrect. Veuillez entrer les informations au format : name,email,phoneNumber\n";
        }
    }

    public function delete(int $id = null) {
        if ($id === null) {
            echo "Veuillez fournir un ID pour supprimer un contact.\n";
            return;
        }
        $contactManager = new ContactManager($this->db);
        $contactManager->delete($id);
        echo "Contact avec l'id " . $id . " supprimé (si existant).\n";
    }

    public function quit() {
        echo "Au revoir !\n";
        exit(0);
    }
}