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

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;
use de\themarcraft\ggh\Verletzung;

if (isset($_GET['id'])){
    $patient = PatientenAkte::getPatientById($_GET['id']);
    $verletzungen = [new Verletzung('scan_'.$_POST['scan'], 1, 1500)];
    $val = true;
    $verletzungenCounter = 0;
    $behandelnde = [];
    foreach (Mitarbeiter::getMitarbeiter() as $mitarbeiter){
        if (isset($_POST['arzt'.$mitarbeiter->getDienstnummer()])){
            $behandelnde[] = Mitarbeiter::getMitarbeiterById($mitarbeiter->getDienstnummer());
        }
    }
    if (!isset($_POST['anmerkungen'])){
        $_POST['anmerkungen'] = "";
    }
    $patient->addEintrag($_POST['datum'], $_POST['zeit'], $verletzungen, $behandelnde, $_POST['preis'], $_POST['anmerkungen']);
    header("Location: /?s=akte&id=".$_GET['id'].$suffix);
}

?>