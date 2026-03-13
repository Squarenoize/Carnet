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
        $contacts = $contactManager->findAll();
        foreach ($contacts as $contact) {
            echo $contact . "\n";
        }
        break;
    }
}