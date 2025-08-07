<?php

use de\themarcraft\ggh\Eintrag;
use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mitarbeiter = Mitarbeiter::getMitarbeiterById($_SESSION['SSID'] ?? base64_decode(base64_decode($_GET['fivem'])));
$patient = PatientenAkte::getPatientById($_GET['id']);

$behandlung = Eintrag::getEintragById($_GET['eintragId']);

date_default_timezone_set("Europe/Berlin");


include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "MRT/Röntgen Scan", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));

?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <div class="row">
                <div class="col"><h2><a href="/?s=akte&id=<?= $patient->getId() ?>"><i class="fa-solid fa-arrow-left"></i></a> Patientenakte</h2></div>
                <div class="col" style="text-align:right;">
                    <h2><a onclick="löschen()"><i class="text-danger fa-solid fa-trash"></i></a></h2>
                </div>
            </div>
            <table class="table">
                <tbody>
                <tr>
                    <td>Vorname</td>
                    <td><?= $patient->getVorname() ?></td>
                </tr>
                <tr>
                    <td>Nachname</td>
                    <td><?= $patient->getNachname() ?></td>
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
            <div style="text-align: center; width: 100%">
                <img src="/images/<?= str_replace("scan_", "", $behandlung->getVerletzungen()[0]->getBezeichnung()) ?>.jpg" class="mg-auto w-100">
            </div>
        </div>
    </div>
</div>
<script>
    function löschen(){
        if (window.confirm("Sicher das du diesen Eintrag löschen möchtest?")){
            location.href = '/api/deleteEintrag.php?id=<?= $_GET['id'] ?>&eintragId=<?= $_GET['eintragId'] ?>';
        }
    }
</script>

</body>
</html>