<?php

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

use de\themarcraft\ggh\PatientenAkte;

if (isset($_GET['id'])) {
    if (!isset($_POST['job'])){
        $_POST['job'] = "Arbeitslos";
    }

    if (!isset($_POST['anmerkung'])){
        $_POST['anmerkung'] = "";
    }

    if (!empty($_POST['geb'])) {
        $date = DateTime::createFromFormat("Y-m-d", $_POST['geb']);
        $_POST['geb'] = $date ? $date->format("d.m.Y") : $_POST['geb']; // Falls fehlerhaft, Originalwert behalten
    }

    $patient = PatientenAkte::getPatientById($_GET['id']);
    $patient->updatePatient($_POST['vorname'], $_POST['nachname'], $_POST['tel'], $_POST['geb'], $_POST['job'], $_POST['anmerkung']);
    header("Location: /?s=akte&success&id=".$_GET["id"].$suffix);
}