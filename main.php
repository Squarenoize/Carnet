<?php
require_once "DBConnect.php";
require_once "ContactManager.php";

$db = new DBConnect();
echo $db->getUserErrorMessage();

$contactManager = new ContactManager($db);

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    if ($line === "list") {
        $contactList = $contactManager->findAll();
        foreach ($contactList as $contact) {
            echo "ID: " . $contact['contact_id'] . ", Name: " . $contact['contact_name'] . ", Email: " . $contact['contact_email'] . ", Phone number: " . $contact['contact_phone_number'] . "\n";
        }
        break;
    }
}