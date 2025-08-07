<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;
include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Verletzung Hinzufügen", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Charité Patienten Akten - Verletzung Hinzufügen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a70d399742.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2><a href="/?s=verletzungen<?= $suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Verletzungen</h2>
            <div>
                <form method="post" action="/api/addVerletzung.php<?= $suffix ?>">
                    <div class="mb-3">
                        <label class="form-label" for="bez">Bezeichnung</label>
                        <input type="text" class="form-control" name="bez" id="bez" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="preis">Preis</label>
                        <input type="number" class="form-control" name="preis" id="preis" min="0" required>
                    </div>
                    <input type="submit" value="Speichern" class="w-100 btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>