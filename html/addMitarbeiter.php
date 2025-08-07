<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;
use de\themarcraft\utils\Database;

$suffix = "";
if (isset($_GET['fivem'])){
    $suffix = "&fivem=".$_GET['fivem'];
}
include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Mitarbeiter Hinzufügen", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2><a href="/?s=mitarbeiterverwaltung<?= $suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Mitarbeiter Bearbeiten</h2>
            <form method="post" action="/api/addMitarbeiter.php?submit=1">
                <div class="mb-3">
                    <label for="dienstnummer" class="form-label">Dienstnummer</label>
                    <input type="number" class="form-control" name="dienstnummer" id="dienstnummer" required>
                </div>
                <div class="mb-3">
                    <label for="vorname" class="form-label">Vorname</label>
                    <input type="text" class="form-control" name="vorname" id="vorname" required>
                </div>
                <div class="mb-3">
                    <label for="nachname" class="form-label">Nachname</label>
                    <input type="text" class="form-control" name="nachname" id="nachname" required>
                </div>
                <div class="mb-3">
                    <label for="rang" class="form-label">Rang</label>
                    <select name="rang" id="rang" class="form-control" required>
                        <?php
                        $db = new Database();
                        $pdo = $db->getPdo();
                        $statement = $pdo->prepare("SELECT * FROM Rang");
                        $statement->execute();
                        foreach ($statement->fetchAll() as $rang) {
                            echo '<option value="'.$rang['Rang'].'">' . $rang['Bezeichnung'] . '</option>';
                        }
                        ?>
                        <option value="6" selected>Wähle einen Rang</option>
                    </select>

                </div>
                <input type="submit" value="Speichern" class="btn btn-primary w-100 mb-3">
            </form>
        </div>
    </div>
</div>
</body>
</html>