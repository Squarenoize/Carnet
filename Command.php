<?php
require_once "ContactManager.php";

class Command {
    private DBConnect $db;
    private ContactManager $contactManager;

    public function __construct(DBConnect $db) {
        $this->db = $db;
        $this->contactManager = new ContactManager($this->db);
    }

    /**
     * Affiche la liste de tous les contacts.
     * @return void
     */
    public function list() {
        $contacts = $this->contactManager->findAll();
        echo "Liste de tous les contacts :\n";
        foreach ($contacts as $contact) {
            echo $contact . "\n";
        }
    }

    /**
     * Affiche les détails d'un contact spécifique en fonction de son ID.
     * @param int|null $id L'ID du contact à afficher. Si null, une erreur est affichée.
     * @return void
     */
    public function detail(int $id = null) {
        if ($id === null) {
            echo "Veuillez fournir un ID pour afficher les détails d'un contact.\n";
            return;
        }
        $contact = $this->contactManager->findById($id);
        if ($contact) {
            echo "Détail du contact avec l'id " . $id . " :\n";
            echo $contact . "\n";
        } else {
            echo "Contact avec l'id " . $id . " non trouvé.\n";
        }
    }

    /**
     * Crée un nouveau contact en demandant les informations à l'utilisateur.
     * @return void
     */
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
            if ($this->validateEmail($email) === false) {
                echo "Email invalide.\n";
                return;
            }
            if ($this->validatePhoneNumber($phoneNumber) === false) {
                echo "Le numéro doit contenir exactement 10 chiffres.\n";
                return;
            }

            $this->contactManager->create($name, $email, $phoneNumber);
            echo "Contact créé avec succès.\n";

        } else {
            echo "Format incorrect. Veuillez entrer les informations au format : name,email,phoneNumber\n";
        }
    }

    public function update(int $id = null) {
        if ($id === null) {
            echo "Veuillez fournir un ID pour mettre à jour un contact.\n";
            return;
        }
        $contact = $this->contactManager->findById($id);
        if ($contact) {
            echo "Détail du contact avec l'id " . $id . " :\n";
            echo $contact . "\n";
            $answer = readline("Voulez-vous modifier le nom ? (y/n) ");
            if (strtolower($answer) === 'y') {
                $newName = readline("Entrez le nouveau nom : ");
                if (empty($newName)) {
                    echo "Le nom ne peut pas être vide.\n";
                    return;
                }
                $contact->setName($newName);
            }
            $answer = readline("Voulez-vous modifier l'email ? (y/n) ");
            if (strtolower($answer) === 'y') {
                $newEmail = readline("Entrez le nouvel email : ");
                if ($this->validateEmail($newEmail) === false) {
                    echo "Email invalide.\n";
                    return;
                }
                $contact->setEmail($newEmail);
            }
            $answer = readline("Voulez-vous modifier le numéro de téléphone ? (y/n) ");
            if (strtolower($answer) === 'y') {
                $newPhoneNumber = readline("Entrez le nouveau numéro de téléphone : ");
                if ($this->validatePhoneNumber($newPhoneNumber) === false) {
                    echo "Le numéro doit contenir exactement 10 chiffres.\n";
                    return;
                }
                $contact->setPhoneNumber($newPhoneNumber);
            }
            $this->contactManager->update($contact);
            echo "Contact mis à jour avec succès.\n";
        } else {
            echo "Contact avec l'id " . $id . " non trouvé.\n";
        }
    }

    /**
     * Supprime un contact en fonction de son ID.
     * @param int|null $id L'ID du contact à supprimer. Si null, une erreur est affichée.
     * @return void
     */
    public function delete(int $id = null) {
        if ($id === null) {
            echo "Veuillez fournir un ID pour supprimer un contact.\n";
            return;
        }
        $this->contactManager->delete($id);
        echo "Contact avec l'id " . $id . " supprimé (si existant).\n";
    }

    public function help() {
        echo "Commandes disponibles :\n";
        echo "help - Affiche cette aide\n";
        echo "list - Affiche la liste de tous les contacts\n";
        echo "detail {id} - Affiche les détails d'un contact spécifique\n";
        echo "create - Crée un nouveau contact (format : nom,email,numéro de téléphone)\n";
        echo "update {id} - Met à jour un contact spécifique\n";
        echo "delete {id} - Supprime un contact spécifique\n";
        echo "quit - Quitte l'application\n";
    }

    public function unknownCommand(string $cmd) {
        echo "Commande inconnue : " . $cmd . "\n";
    }

    /**
     * Quitte l'application.
     * @return void
     */
    public function quit() {
        echo "Au revoir !\n";
        exit(0);
    }

    private function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function validatePhoneNumber(string $phoneNumber): bool {
        return preg_match('/^\d{10}$/', $phoneNumber) === 1;
    }
}