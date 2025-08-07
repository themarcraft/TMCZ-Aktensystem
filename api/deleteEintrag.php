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

use de\themarcraft\ggh\Eintrag;
use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;
use de\themarcraft\ggh\Verletzung;

if (isset($_GET['eintragId']) && isset($_GET['id'])){
    $eintrag = Eintrag::deleteEintragById($_GET['eintragId']);
    header("Location: /?s=akte&success&id=".$_GET['id'].$suffix);
}
?>