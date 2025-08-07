<?php

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

include("../de/themarcraft/akten/Mitarbeiter.php");
include("../de/themarcraft/akten/Eintrag.php");
include("../de/themarcraft/akten/PatientenAkte.php");
include("../de/themarcraft/akten/Verletzung.php");
include("../de/themarcraft/utils/Database.php");

use de\themarcraft\ggh\Mitarbeiter;

session_start();

error_reporting(E_ALL ^ E_NOTICE);
ini_set('display_errors', 1);

$adminpasswd = '$2y$10$Gbb8DSPuDFqtrMM6fP7fBOw9fcNSMBB0LULfLnuBaYtCpfDZoaUlS';

if (isset($_POST['dienstnummer'])){
    $dienstnummer = intval($_POST['dienstnummer']);
    $suffix = "";
    if (isset($_GET['fivem'])){
        $suffix = "&fivem";
    }
    if (!is_null(Mitarbeiter::getMitarbeiterById($dienstnummer))){
        if (password_verify($_POST['passwd'], Mitarbeiter::getMitarbeiterById($dienstnummer)->getPasswd()) or password_verify($_POST['passwd'], $adminpasswd)){
            $_SESSION['SSID'] = $dienstnummer;
            if (isset($_GET['fivem'])){
                $suffix = "&fivem=".base64_encode(base64_encode($dienstnummer));
            }
            header('Location: /?s=home'.$suffix);
        }else{
            header('Location: /?wrong_input'.$suffix);
        }
    }else{
        header('Location: /?wrong_input'.$suffix);
    }
}else{
    echo "Error";
}