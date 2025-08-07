<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\utils\Utils;

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Erste Hilfe Schein hinzufügen", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));

?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2><h2><a href="/?s=ehscheine<?= $suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Erste Hilfe Schein ausstellen</h2>
            <div class="container">
                <form action="/api/addEH.php?submit=1" method="post">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Datum</label>
                        <input type="date" class="form-control" name="datum" required value="<?= date("Y-m-d") ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input value="<?= Utils::getRandomString(10) ?>" type="text" class="form-control form-disabled" name="url" required readonly>
                    </div>
                    <input type="submit" value="Speichern" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>