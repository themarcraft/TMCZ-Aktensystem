<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;
use de\themarcraft\utils\Database;


include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Mitarbeiter Bearbeiten", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));

$mitarbeiter = Mitarbeiter::getMitarbeiterById($_GET['id']);
?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2><a href="/?s=mitarbeiterverwaltung<?= $suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Mitarbeiter Bearbeiten</h2>
            <form method="post" action="/api/editMitarbeiter.php?submit=1&id=<?= $_GET['id'].$suffix ?>">
                <div class="mb-3">
                    <label for="dienstnummer" class="form-label">Dienstnummer</label>
                    <input type="number" class="form-control" name="dienstnummer" id="dienstnummer" value="<?= $mitarbeiter->getDienstnummer() ?>" required>
                </div>
                <div class="mb-3">
                    <label for="vorname" class="form-label">Vorname</label>
                    <input type="text" class="form-control" name="vorname" id="vorname" value="<?= $mitarbeiter->getVorname() ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nachname" class="form-label">Nachname</label>
                    <input type="text" class="form-control" name="nachname" id="nachname" value="<?= $mitarbeiter->getNachname() ?>" required>
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
                            $selected = ($mitarbeiter->getRang() == $rang['Bezeichnung']) ? " selected" : "";
                            echo '<option value="'.$rang['Rang'].'"'.$selected.'>' . $rang['Bezeichnung'] . '</option>';
                        }
                        ?>
                    </select>

                </div>
                <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group" role="group">
                        <input type="submit" value="Speichern" class="btn btn-primary">
                    </div>
                    <div class="btn-group" role="group">
                        <a onclick="location.href = '/api/deleteMitarbeiter.php?id=<?= $_GET['id'] ?>'" class="btn btn-danger">Löschen</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>