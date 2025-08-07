<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;

$patient = PatientenAkte::getPatientById($_GET['id']);

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', str_replace("--", "", $patient->getVorname()).' '.str_replace("--", "", $patient->getNachname()), file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <div class="row">
                <div class="col"><h2><a href="/?s=patientenakten"><i class="fa-solid fa-arrow-left"></i></a> Patientenakte</h2></div>
                <div class="col" style="text-align:right;">
                    <h2><a href="/?s=editPatient&id=<?= $patient->getId() ?>"><i class="fa-solid fa-pen-to-square"></i></a>&nbsp;<a onclick="löschen()"><i class="text-danger fa-solid fa-trash"></i></a></h2>
                </div>
            </div>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Vorname</td>
                        <td><?= str_replace("--", "", $patient->getVorname()) ?></td>
                    </tr>
                    <tr>
                        <td>Nachname</td>
                        <td><?= str_replace("--", "", $patient->getNachname()) ?></td>
                    </tr>
                    <tr>
                        <td>Telefonnummer</td>
                        <td><?= $patient->getTelefonnummer() ?></td>
                    </tr>
                    <tr>
                        <td>Job</td>
                        <td><?= $patient->getJob() ?></td>
                    </tr>
                    <tr>
                        <td>Geburtstag</td>
                        <td><?= $patient->getGeburtstag() ?></td>
                    </tr>
                    <tr>
                        <td>Anmerkung</td>
                        <td><?= $patient->getAnmerkung() ?></td>
                    </tr>
                </tbody>
            </table>
            <h3>Einträge</h3>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Verletzung(en)</th>
                    <th scope="col">Preis</th>
                    <th scope="col">Zeit & Datum</th>
                    <th scope="col">Behandelndes Personal</th>
                    <th scope="col">Anmerkungen</th>
                    <th scope="col" style="min-width: 100px"></th>
                </tr>
                </thead>
                <tbody>
                <tr style="cursor: pointer">
                    <!--<td class="table-primary" colspan="0" onclick="location.href = '/?s=addEintrag&id=<?= $patient->getId() ?>'">Behandlung Hinzufügen</td>-->
                    <td class="table-primary" colspan="3" onclick="location.href = '/?s=addEintragBeta&id=<?= $patient->getId() ?>'">Behandlung Hinzufügen</td>
                    <td class="table-info" colspan="3" onclick="location.href = '/?s=addScan&id=<?= $patient->getId() ?>'">MRT / Röntgen Scan Hinzufügen</td>
                </tr>
                <?php
                $eintraege = $patient->getAkteneintraege();
                foreach ($eintraege as $eintrag){
                    if (str_starts_with($eintrag->getVerletzungen()[0]->getBezeichnung(), "scan_")){
                        echo '<tr style="cursor: default"><td style="cursor: pointer" onclick="location.href = `/?s=viewScan&id='.$_GET['id'].'&eintragId='.$eintrag->getId().'`">MRT / Röntgen Scan (Klicken zum Anzeigen)</td><td onclick="location.href = `/?s=viewScan&id='.$_GET['id'].'&eintragId='.$eintrag->getId().'`">'.$eintrag->getPreis().'€</td><td>'.$eintrag->getDatum()." ".$eintrag->getUhrzeit().'</td><td>'.$eintrag->getAerzteString().'</td><td>'.$eintrag->getAnmerkungen().'</td><td onclick="location.href = `/api/deleteEintrag.php?id='.$_GET['id'].'&eintragId='.$eintrag->getId().'`" style="text-align:right;"><i class="fa-solid fa-trash" onclick="location.href = `/api/deleteEintrag.php?id='.$_GET['id'].'&eintragId='.$eintrag->getId().'`"></i></td></tr>';
                    }else{
                        echo '<tr style="cursor: default"><td style="cursor: pointer" onclick="location.href = `/?s=editEintragBeta&id='.$_GET['id'].'&eintragId='.$eintrag->getId().'`">'.$eintrag->getVerletzungenString().'</td><td onclick="location.href = `/?s=editEintrag&id='.$_GET['id'].'&eintragId='.$eintrag->getId().'`">'.$eintrag->getPreis().'€</td><td>'.$eintrag->getDatum()." ".$eintrag->getUhrzeit().'</td><td>'.$eintrag->getAerzteString().'</td><td>'.$eintrag->getAnmerkungen().'</td><td style="text-align:right;"><i class="fa-solid fa-pen-to-square" onclick="location.href = `/?s=editEintrag&id='.$_GET['id'].'&eintragId='.$eintrag->getId().'`"></i>&nbsp;&nbsp;<i class="fa-solid fa-trash" onclick="location.href = `/api/deleteEintrag.php?id='.$_GET['id'].'&eintragId='.$eintrag->getId().'`"></i></td></tr>';
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function löschen(){
        if (window.confirm("Sicher das du die Akte von <?= $patient->getVorname().' '.$patient->getNachname() ?> löschen möchtest?")){
            location.href = '/api/deletePatient.php?id=<?= $patient->getId() ?>';
        }
    }
</script>
</body>
</html>