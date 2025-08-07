<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\Verletzung;

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Verletzungen", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));

?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2>Verletzungen</h2>
            <table class="table">
                <tr>
                    <th>Bezeichnung</th>
                    <th>Preis</th>
                    <th></th>
                </tr>
                <tr class="table-primary" style="cursor:pointer;" onclick="location.href = '/?s=addVerletzung<?= $suffix ?>'">
                    <td colspan="3">Verletzung Hinzufügen</td>
                </tr>
                <?php
                foreach (Verletzung::getAll() as $verletzung) {?>
                    <tr>
                        <td><?= $verletzung->getBezeichnung() ?></td>
                        <td><?= $verletzung->getPreis() ?>€</td>
                        <td style="text-align: right"><i class="fa-solid fa-pen-to-square" onclick="location.href = '/?s=editVerletzung&id=<?= $verletzung->getId().$suffix ?>'"></i>&nbsp;&nbsp;<i onclick="if (window.confirm('Sicher das du diese Verletzung löschen möchtest?')){location.href = '/api/deleteVerletzung.php?id=<?= $verletzung->getId() ?>';}" class="fa-solid fa-trash"></i></td>
                    </tr>
                <?php }
                ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>