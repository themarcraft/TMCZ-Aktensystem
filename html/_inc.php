<?php

use de\themarcraft\ggh\Mitarbeiter;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mitarbeiter = Mitarbeiter::getMitarbeiterById($_SESSION['SSID'] ?? base64_decode(base64_decode($_GET['fivem'])));

$suffix = "";
if (isset($_GET['fivem'])){
    $suffix = "&fivem=".$_GET['fivem'];
}