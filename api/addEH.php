<?php

use de\themarcraft\ggh\EH_Schein;

include("../de/themarcraft/akten/EH_Schein.php");
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

if (isset($_GET['submit'])) {
    $date = DateTime::createFromFormat("Y-m-d", $_POST['datum']);
    EH_Schein::addEH_Schein(new EH_Schein(-1, $_POST['name'], $date->format("d.m.Y"), $_POST['url']));
    header("Location: /?s=ehscheine&success".$suffix);
}