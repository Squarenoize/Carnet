<?php
require_once "DBConnect.php";
$db = new DBConnect();
echo $db->getUserErrorMessage();

require_once "Command.php";
$command = new Command($db);

while (true) {
    $line = readline("Entrez votre commande (help, list, detail {id}, create, update {id}, delete {id}, quit): ");
    
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
            $command->detail($id ?? null);
            break;
        case "create":
            $command->create();
            break;
        case "delete":
            $command->delete($id ?? null);
            break;
        case "update":
            $command->update($id ?? null);
            break;
        case "help":
            $command->help();
            break;
        case "quit":
            $command->quit();
            break;
        default:
            echo "Commande inconnue : " . $cmd . "\n";
            break;
    }
}