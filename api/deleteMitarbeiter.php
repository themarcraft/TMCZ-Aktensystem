<?php

use de\themarcraft\ggh\Mitarbeiter;
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
    $id = $_GET['id'];
    $db = new Database();
    $pdo = $db->getPDO();
    $statement = $pdo->prepare("DELETE FROM Mitarbeiter WHERE dienstnummer = ?");
    $statement->bindParam(1, $id);
    $statement->execute();

    header("Location: /?s=mitarbeiterverwaltung&success".$suffix);
}