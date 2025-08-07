<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;

$patient = PatientenAkte::getPatientById($_GET['id']);
include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "MRT/Röntgen Scan Hinzufügen", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Charité Patienten Akten - MRT/Röntgen Scan Hinzufügen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a70d399742.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2><a href="/?s=akte&id=<?= $patient->getId().$suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Patientenakten</h2>
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
            <form action="/api/addScan.php?id=<?= $_GET['id'].$suffix ?>" method="post">
                <h3>Datum und Zeit</h3>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="datum" placeholder="Datum" value="<?= date("d.m.Y") ?>" required>
                    <input type="text" class="form-control" name="zeit" placeholder="Uhrzeit" value="<?= date("H:i") ?>" required>
                </div>
                <div>
                    <h3>Behandelndes Personal</h3>
                    <?php
                    foreach (Mitarbeiter::getMitarbeiter() as $behandler) {
                        if ($behandler->getDienstnummer() == $mitarbeiter->getDienstnummer()){
                            echo '<div class="form-check mb-3">
                        <input checked class="form-check-input" type="checkbox" id="arzt'.$behandler->getDienstnummer().'" name="arzt'.$behandler->getDienstnummer().'">
                        <label class="form-check-label" for="arzt'.$behandler->getDienstnummer().'">
                            '.$behandler->getVorname().' '.$behandler->getNachname().'
                        </label>
                    </div>';
                        }else{
                            echo '<div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="arzt'.$behandler->getDienstnummer().'" name="arzt'.$behandler->getDienstnummer().'">
                        <label class="form-check-label" for="arzt'.$behandler->getDienstnummer().'">
                            '.$behandler->getVorname().' '.$behandler->getNachname().'
                        </label>
                    </div>';
                        }
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="hirnblutung col">
                        <h2>MRT - Hirnblutung</h2>
                        <?php
                        $i = 1;
                        foreach (scandir("./images/") as $file) {
                            if (str_starts_with($file, "hirnblutung")) {?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="scan" id="hirnblutung<?= $i ?>" value="hirnblutung<?= $i ?>">
                                    <label class="form-check-label" for="hirnblutung<?= $i ?>">
                                        <img src="/images/<?= $file ?>" width="150px">
                                    </label>
                                </div>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                    <div class="tumor col">
                        <h2>MRT - Tumor</h2>
                        <?php
                        $i = 1;
                        foreach (scandir("./images/") as $file) {
                            if (str_starts_with($file, "hirntumor")) {?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="scan" value="hirntumor<?= $i ?>" id="hirntumor<?= $i ?>">
                                    <label class="form-check-label" for="hirntumor<?= $i ?>">
                                        <img src="/images/<?= $file ?>" width="150px">
                                    </label>
                                </div>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                    <div class="ct col">
                        <h2>Röntgen Scans</h2>
                        <?php
                        $i = 1;
                        foreach (scandir("./images/") as $file) {
                            if (str_starts_with($file, "ct")) {?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="scan" id="ct<?= $i ?>" value="ct<?= $i ?>">
                                    <label class="form-check-label" for="ct<?= $i ?>">
                                        <img src="/images/<?= $file ?>" width="150px">
                                    </label>
                                </div>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </div>
                </div>
                <div>
                    <h3>Anmerkungen</h3>
                    <div class="mb-3">
                        <input class="form-control" type="text" placeholder="Anmerkungen" name="anmerkungen">
                    </div>
                </div>
                <div>
                    <h3>Preis</h3>
                    <div class="mb-3">
                        <input class="form-control" placeholder="Preis" name="preis" type="number" value="1500" required>
                    </div>
                </div>
                <input type="submit" value="Speichern" class="btn btn-primary w-100 mb-5">
            </form>
        </div>
    </div>
</div>
</body>
</html>