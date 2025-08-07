<?php

use de\themarcraft\ggh\PatientenAkte;

$patient = PatientenAkte::getPatientById($_GET['id']);

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Patient Bearbeiten", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2><a href="/?s=akte&id=<?= $patient->getId().$suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Patient Bearbeiten</h2>
            <form method="post" action="/api/editPatient.php?submit=1&id=<?= $_GET['id'].$suffix ?>">
                <div class="mb-3">
                    <label for="vorname" class="form-label">Vorname</label>
                    <input type="text" class="form-control" name="vorname" id="vorname" value="<?= $patient->getVorname() ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nachname" class="form-label">Nachname</label>
                    <input type="text" class="form-control" name="nachname" id="nachname" value="<?= $patient->getNachname() ?>" required>
                </div>
                <div class="mb-3">
                    <label for="geb" class="form-label">Geburtstag</label>
                    <?php

                    $date = DateTime::createFromFormat("d.m.Y", $patient->getGeburtstag());
                    $geb = $date ? $date->format("Y-m-d") : $patient->getGeburtstag(); // Falls fehlerhaft, Originalwert behalten
                    ?>
                    <input type="date" class="form-control" name="geb" id="geb" value="<?= $geb ?>" required>
                </div>
                <div class="mb-3">
                    <label for="tel" class="form-label">Telefonnummer</label>
                    <input type="tel" class="form-control" name="tel" id="tel" value="<?= $patient->getTelefonnummer() ?>" required>
                </div>
                <div class="mb-3">
                    <label for="job" class="form-label">Job</label>
                    <input list="jobs" type="text" class="form-control" name="job" id="job" value="<?= $patient->getJob() ?>">
                    <datalist id="jobs">
                        <option>Charité</option>
                        <option>Autohaus</option>
                        <option>Polizei</option>
                        <option>Feuerwehr</option>
                        <option>Pizza</option>
                        <option>Braun GmbH</option>
                        <option>Farmer</option>
                        <option>Mechaniker</option>
                        <option>Arbeitslos</option>
                    </datalist>
                </div>
                <div class="mb-3">
                    <label for="anmerkung" class="form-label">Anmerkung</label>
                    <input type="text" class="form-control" name="anmerkung" id="anmerkung" value="<?= $patient->getAnmerkung() ?>">
                </div>
                <input type="submit" value="Speichern" class="btn btn-primary w-100 mb-3">
            </form>
        </div>
    </div>
</div>
</body>
</html>