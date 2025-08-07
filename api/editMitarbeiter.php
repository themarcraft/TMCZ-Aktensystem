<?php

use de\themarcraft\ggh\Mitarbeiter;

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
    $mitarbeiter = Mitarbeiter::getMitarbeiterById($_GET['id']);
    if (isset($_POST['dienstnummer'])){
        $mitarbeiter->setDienstnummer(intval($_POST['dienstnummer']));
    }
    if (isset($_POST['nachname'])){
        $mitarbeiter->setNachname($_POST['nachname']);
    }
    if (isset($_POST['vorname'])){
        $mitarbeiter->setVorname($_POST['vorname']);
    }
    if (isset($_POST['rang'])){
        $mitarbeiter->setRang($_POST['rang']);
    }
    header("Location: /?s=mitarbeiterverwaltung&success".$suffix);
}