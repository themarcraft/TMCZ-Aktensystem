<?php

use de\themarcraft\utils\BerlinVDatabase;
use de\themarcraft\utils\Database;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db = new Database();
$pdo = $db->getPDO();

$berlinVDB = new BerlinVDatabase();
$berlinVpdo = $berlinVDB->getPDO();

$statement = $berlinVpdo->prepare("SELECT firstname, lastname, job, phone_number, dateofbirth FROM users;");
$statement->execute();
$users = $statement->fetchAll();
foreach ($users as $user) {
    $stmnt = $pdo->prepare("select vorname, nachname from Patientenakte where vorname = ? and nachname = ? LIMIT 1;");
    $stmnt->execute([$user['firstname'], $user['lastname']]);
    if ($stmnt->rowCount() == 0) {
        $insert = $pdo->prepare("INSERT INTO Patientenakte (vorname, nachname, telefonnummer, job, geburtstag) VALUES (?, ?, ?, ?, ?);");
        $insert->bindValue(1, $user['firstname']);
        $insert->bindValue(2, $user['lastname']);
        $insert->bindValue(3, $user['phone_number'] ?? "-");
        $insert->bindValue(4, $user['job']);
        $insert->bindValue(5, $user['dateofbirth']);
        $insert->execute();
    }
}

header("Location: ".$_SERVER['HTTP_REFERER']."&success");

?>