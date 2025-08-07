<?php

use de\themarcraft\ggh\Verletzung;

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

if (isset($_POST['bez'])){
    if (Verletzung::add(new Verletzung($_POST['bez'], 0, intval($_POST['preis'])))){
        header("location: /?s=verletzungen&success".$suffix);
    }else{
        header("location: /?s=verletzungen&error".$suffix);
    }
}