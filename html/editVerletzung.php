<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;
use de\themarcraft\ggh\Verletzung;

if (!isset($_GET['id'])){
    header('Location: /?error');
    die();
}

$verletzung = Verletzung::getVerletzungById($_GET['id']);

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Verletzung Bearbeiten", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2><a href="/?s=verletzungen<?= $suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Verletzungen</h2>
            <div>
                <form method="post" action="/api/editVerletzung.php?id=<?= $verletzung->getId().$suffix ?>">
                    <div class="mb-3">
                        <label class="form-label" for="bez">Bezeichnung</label>
                        <input type="text" class="form-control" name="bez" id="bez" value="<?= $verletzung->getBezeichnung() ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="preis">Preis</label>
                        <input type="number" class="form-control" name="preis" id="preis" min="0" value="<?= $verletzung->getPreis() ?>" required>
                    </div>
                    <div class="row">
                        <div class="col"><input type="submit" value="Speichern" class="w-100 btn btn-primary"></div>
                        <div class="col"><span class="btn btn-danger w-100" onclick="löschen()">Löschen</span></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function löschen(){
        if (window.confirm("Sicher das du diese Verletzung löschen möchtest?")){
            location.href = '/api/deleteVerletzung.php?id=<?= $_GET['id'] ?>';
        }
    }
</script>
</body>
</html>