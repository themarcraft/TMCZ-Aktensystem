<?php

session_start();

include("de/themarcraft/akten/Mitarbeiter.php");
include("de/themarcraft/akten/Eintrag.php");
include("de/themarcraft/akten/PatientenAkte.php");
include("de/themarcraft/akten/Verletzung.php");
include("de/themarcraft/akten/EH_Schein.php");
include("de/themarcraft/utils/Database.php");
include("de/themarcraft/utils/BerlinVDatabase.php");
include("de/themarcraft/utils/Utils.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['s'])){
    if (isset($_GET['wrong_input'])){
        echo '<div class="alert alert-danger" role="alert">Deine Dienstnummer oder dein Passwort ist falsch, melde dich beim Chefarzt</div>';
    }

    if (isset($_GET['newpasswd_wrong'])){
        echo '<div class="alert alert-danger" role="alert">Dein altes Passwort ist falsch</div>';
    }

    if (isset($_GET['oldpasswd_wrong'])){
        echo '<div class="alert alert-danger" role="alert">Die Passwörter stimmen nicht überein</div>';
    }

    if (isset($_GET['success'])){
        echo '<div onclick="hide()" class="alert alert-success" id="alert" style="cursor: pointer; position: absolute; width: 20%; top: 40%; left: 40%; right: 40%">Erfolgreich gespeichert</div>';
    }

    if (isset($_GET['error'])){
        echo '<div onclick="hide()" class="alert alert-danger" id="alert" style="cursor: pointer; position: absolute; width: 20%; top: 40%; left: 40%; right: 40%">Es gab einen Fehler beim Speichern</div>';
    }

    /*if (!isset($_SESSION['SSID'])){
        if (!isset($_GET['fivem'])){
            include("html/login.html");
            die("1");
        }
    }

    if (isset($_GET['fivem'])){
        if ($_GET['fivem'] == ""){
            include("html/login.html");
            die("2");
        }
    }*/
    switch ($_GET['s'] ?? 'default'){
        case "logout":
            unset($_SESSION['SSID']);
            session_destroy();
            include("html/login.html");
            break;
        case "patientenakten":
            include("html/patientenakten.php");
            break;
        case "akte":
            include("html/patientenakte.php");
            break;
        case "addPatient":
            include("html/patienthinzufuegen.php");
            break;
        case "editPatient":
            include "html/editpatient.php";
            break;
        case "editMitarbeiter":
            include "html/editMitarbeiter.php";
            break;
        case "addMitarbeiter":
            include "html/addMitarbeiter.php";
            break;
        case "mitarbeiterverwaltung":
            include "html/mitarbeiterverwaltung.php";
            break;
        case "addEintrag":
            include("html/addEintrag.php");
            break;
        case "addEintragBeta":
            include("html/addEintragBeta.php");
            break;
        case "editEintrag":
            include("html/editEintrag.php");
            break;
        case "editEintragBeta":
            include("html/editEintragBeta.php");
            break;
        case "addScan":
            include("html/addScan.php");
            break;
        case "viewScan":
            include("html/viewScan.php");
            break;
        case "settings":
            include("html/settings.php");
            break;
        case "verletzungen":
            include("html/verletzungen.php");
            break;
        case "editVerletzung":
            include("html/editVerletzung.php");
            break;
        case "addVerletzung":
            include("html/addVerletzung.php");
            break;
        case "sync":
            include("sync.php");
            break;
        case "addEH":
            include("html/addEH.php");
            break;
        case "ehscheine":
            include("html/ehscheine.php");
            break;
        default:
            include("html/home.php");
    }


    if (isset($_GET['success']) or isset($_GET['error'])) {
        echo '<script>';
        echo "function hide(){document.getElementById('alert').outerHTML = '';}";
        echo 'setTimeout(hide, 3000);';
        echo '</script>';
        echo '<script src="js/fivem.js"></script>';
    }
}elseif (isset($_GET['erstehilfeschein'])){
    include("html/eh_schein.php");
}else{
    echo str_replace('%s', 'Home', file_get_contents($_SERVER['DOCUMENT_ROOT']."/website/_header.html"));
    include("website/index.php");
}
