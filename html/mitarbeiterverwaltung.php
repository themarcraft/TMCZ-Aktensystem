<?php

use de\themarcraft\ggh\Mitarbeiter;

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Mitarbeiterverwaltung", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Charité Patienten Akten - Mitarbeiterverwaltung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <?php include("templates/sidebar.php") ?>
            <div class="col">
                <h2>Mitarbeiterverwaltung</h2>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th style="width: 5%"></th>
                    <th scope="col">Vorname</th>
                    <th scope="col">Nachname</th>
                    <th scope="col">Rang</th>
                </tr>
                </thead>
                <tbody>
                <tr onclick="location.href = '/?s=addMitarbeiter'"><td class="table-primary"></td><td colspan="3" class="table-primary">Mitarbeiter einstellen</td></tr>
                <?php
                $aerzte = Mitarbeiter::getMitarbeiter();
                foreach ($aerzte as $arzt){
                    echo '<tr onclick="location.href = `/?s=editMitarbeiter&id='.$arzt->getDienstnummer().$suffix.'`"><td>'.$arzt->getDienstnummer().'</td><td>'.$arzt->getVorname().'</td><td>'.$arzt->getNachname().'</td><td>'.$arzt->getRang().'</td></tr>';
                }
                ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</body>
</html>