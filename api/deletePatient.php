<?php

use de\themarcraft\utils\Database;

include("../de/themarcraft/akten/Mitarbeiter.php");
include("../de/themarcraft/akten/Eintrag.php");
include("../de/themarcraft/akten/PatientenAkte.php");
include("../de/themarcraft/akten/Verletzung.php");
include("../de/themarcraft/utils/Database.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!(isset($_SESSION['SSID']) or isset($_GET['fivem']))){
    header("location: /");
    die("403 Forbidden");
}

$suffix = "";
if (isset($_GET['fivem'])){
    $suffix = "&fivem=".$_GET['fivem'];
}

if (isset($_GET['id'])) {
    $db = new Database();
    $pdo = $db->getPdo();
    $statement = $pdo->prepare("DELETE FROM Patientenakte WHERE id = ?");
    $statement->bindValue(1, $_GET['id']);
    $statement->execute();
    header('Location: /?s=patientenakten&success'.$suffix);
}