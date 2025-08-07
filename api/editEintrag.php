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

if (isset($_GET['id'])){
    $verletzungen = [];
    for ($i = 0; $i < 10; $i++){
        $verletzungenCounter = 0;
        $val = true;
        while ($val or $verletzungenCounter < 10){
            if (isset($_POST['verletzung_'.$i.'_'.$verletzungenCounter])){
                if ($_POST['verletzung_'.$i.'_'.$verletzungenCounter] != ""){
                    $verletzungen[] = new Verletzung(bezeichnung: $_POST['verletzung_'.$i.'_'.$verletzungenCounter], anzahl: $_POST['verletzungAnzahl_'.$i.'_'.$verletzungenCounter], ort: $i);
                    $verletzungenCounter++;
                }
            }else{
                $val = false;
                $verletzungenCounter++;
            }
        }
    }
    var_dump($_POST);
    $behandelnde = [];
    $val = "";
    foreach (Mitarbeiter::getMitarbeiter() as $mitarbeiter){
        if (isset($_POST['arzt'.$mitarbeiter->getDienstnummer()])){
            //if ($_POST['arzt'.$mitarbeiter->getDienstnummer()] != ""){
                $behandelnde[] = Mitarbeiter::getMitarbeiterById($mitarbeiter->getDienstnummer());
            //}
            $val.= $mitarbeiter->getDienstnummer().'<br>';
        }
    }
    if (!isset($_POST['anmerkungen'])){
        $_POST['anmerkungen'] = "";
    }

    $eintrag = Eintrag::getEintragById(intval($_GET['eintragId']));

    $eintrag->setDatum($_POST['datum']);
    $eintrag->setUhrzeit($_POST['zeit']);
    $eintrag->setVerletzungen($verletzungen);
    $eintrag->setAerzte($behandelnde);
    $eintrag->setPreis(intval($_POST['preis']));
    $eintrag->setAnmerkungen($_POST['anmerkungen']);

    //$patient->addEintrag($_POST['datum'], $_POST['zeit'], $verletzungen, $behandelnde, $_POST['preis'], $_POST['anmerkungen']);
    header("Location: /?s=akte&success&id=".$_GET['id'].$suffix);
}

?>