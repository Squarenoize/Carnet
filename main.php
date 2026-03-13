<?php
require_once "DBConnect.php";
$db = new DBConnect();
echo $db->getUserErrorMessage();

if ($db->getConnection() === null) {
    exit(1);
}

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    if ($line === "list") {
        echo "Affichage list\n";
        break;
    }
}