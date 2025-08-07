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

session_start();

if (isset($_GET['submit'])){
    $mitarbeiter = Mitarbeiter::getMitarbeiterById($_SESSION['SSID']);
    if (password_verify($_POST['oldpasswd'], $mitarbeiter->getPasswd())){
        if ($_POST['newpasswd1'] == $_POST['newpasswd2']){
            $mitarbeiter->setPasswd($_POST['newpasswd1']);
            header("Location: /?s=settings&success".$suffix);
        }else{
            header("Location: /?s=settings&newpasswd_wrong".$suffix);
        }
    }else{
        header("Location: /?s=settings&oldpasswd_wrong".$suffix);
    }
}