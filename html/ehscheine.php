<?php

use de\themarcraft\ggh\EH_Schein;
use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\utils\Utils;

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Erste Hilfe Scheine", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));

?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2>Erste Hilfe Schein ausstellen</h2>
            <div class="container">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Datum</td>
                            <td>URL</td>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="table-primary" colspan="3" onclick="location.href = '/?s=addEH'">Hinzufügen</td>
                    </tr>
                    <?php
                    foreach (EH_Schein::getEH_Scheine() as $schein) {
                        echo "<tr>\n";
                        echo "<td>" . $schein->getName() . "</td>\n";
                        echo "<td>" . $schein->getDatum() . "</td>\n";
                        echo "<td style='text-align: right'><a target='_blank' href='/?erstehilfeschein=" . $schein->getUrl() . "'><i class='fa-solid fa-arrow-up-right-from-square'></i></a>&nbsp;&nbsp;<a href='/api/delEH.php?id=" . $schein->getId() . "'><i class='fa-solid fa-trash'></i></a></td>\n";
                        echo "</tr>\n";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>