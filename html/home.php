<?php

use de\themarcraft\ggh\Mitarbeiter;

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Home", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<body>
    <div class="container mt-5">
        <div class="row">
            <?php include("templates/sidebar.php") ?>
            <div class="col">
                <h2>Hallo <?= $mitarbeiter->getRangId() <=4 ? "Dr. med. " : "" ?><?= $mitarbeiter->getVorname() ?> <?= $mitarbeiter->getNachname() ?></h2>
                <table class="table">
                    <tr>
                        <td>Dein Rang</td>
                        <td style="width: 50%"><?= $mitarbeiter->getRang() ?></td>
                    </tr>
                    <tr>
                        <td>Behandelte Verletzungen</td>
                        <td><?= $mitarbeiter->getBehandelteVerletzungen() ?></td>
                    </tr>
                    <tr>
                        <td>Behandelte Patienten</td>
                        <td><?= $mitarbeiter->getBehandeltePatienten() ?></td>
                    </tr>
                    <!--<tr>
                        <td><b>Geplante Updates</b></td>
						<td>
							<ul>
								<li>Erweiterte Mitarbeiter Verwaltung</li>
								<li>Rechte System</li>
								<li><s>Körperbereich auswählbar beim Verletzungen hinzufügen</s></li>
                                <li><s>Eigene Verletzungen dem Autocompleter hinzufügen</s></li>
								<li><s>Automatisches Preis berechnen</s></li>
								<li><s>MRT Scans in den Akten</s></li>
								<li><s>Erweiterte Behandlungsansicht</s></li>
							</ul>
						</td>
                    </tr>-->
                    <!--<tr>
                        <td>PHP Klassen Diagramm</td>
                        <td><img src="/images/Klassen%20Diagramm.png" width="100%"></td>
                    </tr>
                    <tr>
                        <td>SQL Klassen Diagramm</td>
                        <td><img src="/images/SQL%20Klassendiagramm.png" width="100%"></td>
                    </tr>-->
                </table>
            </div>
        </div>
    </div>
</body>
</html>