<?php
require_once "DBConnect.php";
$db = new DBConnect();
echo $db->getUserErrorMessage();

require_once "Command.php";
$command = new Command($db);

while (true) {
    $line = readline("Entrez votre commande : ");
    
    if(preg_match('/^([a-zA-Z]+)\s+(\d+)$/', $line, $matches) === 1) {
        $cmd = $matches[1];
        $id = $matches[2];
    } else {
        $cmd = $line;
    }
    
    switch ($cmd) {
        case "list":
            $command->list();
            break;
        case "detail":
            $command->detail($id);
            break;
            case "create":
            $command->create();
            break;
        default:
            echo "Commande inconnue : " . $cmd . "\n";
            break;
    }
}