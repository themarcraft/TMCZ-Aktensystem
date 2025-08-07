<?php

use de\themarcraft\ggh\Eintrag;
use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;
use de\themarcraft\ggh\Verletzung;

$patient = PatientenAkte::getPatientById($_GET['id']);

$behandlung = Eintrag::getEintragById($_GET['eintragId']);
include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Eintrag Bearbeiten", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Charité Patienten Akten - Eintrag Bearbeiten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a70d399742.js" crossorigin="anonymous"></script>
    <script>
        let preise = Array(10).fill().map(() => []);

        function calcPrice(bezId, anzahlId) {
            let verletzungen = <?= json_encode(Verletzung::getAllToArray()) ?>;
            let anzahl = document.getElementById(anzahlId)?.value || 0;
            let bez = document.getElementById(bezId)?.value || "";
            return (bez in verletzungen) ? verletzungen[bez] * parseInt(anzahl) : 0;
        }

        function updatePrice() {
            let total = 0;
            preise.forEach(region => {
                region.forEach(preis => {
                    total += preis || 0;
                });
            });
            document.getElementById("preis").value = total;
            return total;
        }</script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <div class="row">
                <div class="col"><h2><a href="/?s=akte&id=<?= $patient->getId().$suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Patientenakte</h2></div>
                <div class="col" style="text-align:right;">
                    <h2><a onclick="löschen()"><i class="text-danger fa-solid fa-trash"></i></a></h2>
                </div>
            </div>
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
            <form action="/api/editEintrag.php?id=<?= $_GET['id'] ?>&eintragId=<?= $_GET['eintragId'].$suffix ?>" method="post">
                <h3>Datum und Zeit</h3>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="datum" placeholder="Datum" value="<?= $behandlung->getDatum() ?>" required>
                    <input type="text" class="form-control" name="zeit" placeholder="Uhrzeit" value="<?= $behandlung->getUhrzeit() ?>" required>
                </div>
                <div>
                    <h3>Behandelndes Personal</h3>
                    <?php
                    //echo serialize(Mitarbeiter::getMitarbeiter())."<br>".serialize($behandlung->getAerzte());
                    foreach (Mitarbeiter::getMitarbeiter() as $behandler) {
                        if (in_array($behandler, $behandlung->getAerzte())){
                            echo '<div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="arzt'.$behandler->getDienstnummer().'" name="arzt'.$behandler->getDienstnummer().'" checked>
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
                <div>
                    <h3>Anmerkungen</h3>
                    <div class="mb-3">
                        <input class="form-control" type="text" placeholder="Anmerkungen" name="anmerkungen" value="<?= $behandlung->getAnmerkungen() ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <h3>Verletzungen</h3>
                        <img src="/images/körper/körperThorax.png" id="body" draggable="false" class="mb-3">
                    </div>
                    <div class="col">
                        <h3 id="bodyTitle">Thorax</h3>
                        <div id="verletzungsblock">
                            <?php
                            $i = 0;
                            foreach ($behandlung->getVerletzungen() as $verletzung) {
                                $ort = $verletzung->getOrt();
                                if($verletzung->getOrt() == -1){
                                    $ort = 1;
                                }
                                ?>
                                <div class="mb-3 input-group verletzungsfeld feld-<?= $ort ?>" style="display: flex;">
                                    <input type="number" min="1" max="100" value="<?= $verletzung->getAnzahl() ?>" style="max-width: 20%" class="form-control" name="verletzungAnzahl_<?= $verletzung->getOrt() ?>_<?= $i ?>" id="verletzungAnzahl_<?= $verletzung->getOrt() ?>_<?= $i ?>" onfocusout="preise[<?= $verletzung->getOrt() ?>][<?= $i ?>] = calcPrice('verletzung_<?= $verletzung->getOrt() ?>_<?= $i ?>', 'verletzungAnzahl_<?= $verletzung->getOrt() ?>_<?= $i ?>')">
                                    <input value="<?= $verletzung->getBezeichnung() ?>" type="text" list="verletzungenListe" class="form-control" name="verletzung_<?= $verletzung->getOrt() ?>_<?= $i ?>" id="verletzung_<?= $verletzung->getOrt() ?>_<?= $i ?>" onfocusout="preise[<?= $verletzung->getOrt() ?>][<?= $i ?>] = calcPrice('verletzung_<?= $verletzung->getOrt() ?>_<?= $i ?>', 'verletzungAnzahl_<?= $verletzung->getOrt() ?>_<?= $i ?>')">
                                    <script>preise[<?= $verletzung->getOrt() ?>][<?= $i ?>] = calcPrice('verletzung_<?= $verletzung->getOrt() ?>_<?= $i ?>', 'verletzungAnzahl_<?= $verletzung->getOrt() ?>_<?= $i ?>')</script>
                                </div>
                            <?php
                            $i++;
                            }?>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <button type="button" class="btn btn-secondary w-100" id="addverletzungen">Weitere</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-danger w-100" id="removeverletzungen">Letzte Löschen</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<h3>Verletzungen (Einzeln Aufzählen)</h3>
                <div>
                    <?php
                    $i = 0;
                    foreach ($behandlung->getVerletzungen() as $verletzung) {?>
                        <div class="mb-3 input-group" id="verletzungsblock">
                            <input type="number" min="0" max="100" style="max-width: 20%" class="form-control" id="verletzungAnzahl<?= $i ?>" name="verletzungAnzahl<?= $i ?>" value="<?= $verletzung->getAnzahl() ?>" placeholder="Anzahl" required value="1" onfocusout="preise[<?= $i ?>] = calcPrice('verletzung<?= $i ?>', 'verletzungAnzahl<?= $i ?>')">
                            <input type="text" id="verletzung<?= $i ?>" list="verletzungenListe" name="verletzung<?= $i ?>" class="form-control" placeholder="Verletzung" value="<?= $verletzung->getBezeichnung() ?>" onfocusout="preise[<?= $i ?>] = calcPrice('verletzung<?= $i ?>', 'verletzungAnzahl<?= $i ?>')" required>
                        </div>
                        <script>preise[<?= $i ?>] = calcPrice("verletzung<?= $i ?>", "verletzungAnzahl<?= $i ?>")</script>
                        <?php
                        $i++;}
                    ?>
                </div>-->
                <div>
                    <h3>Preis</h3>
                    <div class="mb-3 input-group">
                        <span class="btn btn-info" onclick="updatePrice()">Preise Berechnen</span>
                        <input class="form-control" placeholder="Preis" id="preis" name="preis" type="number" value="<?= $behandlung->getPreis() ?>" required>
                    </div>
                </div>
                <input type="submit" value="Speichern" class="btn btn-primary w-100 mb-5">
            </form>
        </div>
    </div>
</div>

<datalist id="verletzungenListe">
    <?php
    foreach (Verletzung::getAll() as $verletzung) {
        echo '<option>'.$verletzung->getBezeichnung().'</option>';
    }
    ?>
</datalist>
<script>
    function löschen(){
        if (window.confirm("Sicher das du diesen Eintrag löschen möchtest?")){
            location.href = '/api/deleteEintrag.php?id=<?= $_GET['id'] ?>&eintragId=<?= $_GET['eintragId'] ?>';
        }
    }
</script>

<script>

    let counter = Array(10).fill(0);
    let selected = 1;
    let title = document.getElementById('bodyTitle');
    let body = document.getElementById('body')
    let bodyParts = [
        "Cranium", "Thorax",
        "Brachium R", "Antebrachium R", "Brachium L", "Antebrachium L",
        "Zeugopodium R", "Stylopodium R", "Zeugopodium L", "Stylopodium L",
    ]

    body.src = "/images/körper/körperThorax.png";

    title.innerText = bodyParts[selected];
    updateVerletzungsblock();

    document.querySelector("#addverletzungen").addEventListener("click", addVerletzungsblock);
    document.querySelector("#removeverletzungen").addEventListener("click", deleteVerletzungsblock);

    document.getElementById("body").addEventListener("click", (event) => {
        const rect = body.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        selectBodyPart(x, y);
    });

    function selectBodyPart(x, y){
        if (y < 64){
            selected = 0;
            body.src = "/images/körper/körperKopf.png";
        } else if (y > 65 && y < 200 && x > 62 && x < 122){
            selected = 1;
            body.src = "/images/körper/körperThorax.png";
        } else if (y > 65 && y < 151 && x < 62){
            selected = 2;
            body.src = "/images/körper/körperOberarmR.png";
        } else if (y > 151 && y < 253 && x < 62){
            selected = 3;
            body.src = "/images/körper/körperUnterarmR.png";
        } else if (y > 65 && y < 151 && x > 127){
            selected = 4;
            body.src = "/images/körper/körperOberarmL.png";
        } else if (y > 151 && y < 253 && x > 127){
            selected = 5;
            body.src = "/images/körper/körperUnterarmL.png";
        } else if (y > 205 && y < 310 && x > 88){
            selected = 6;
            body.src = "/images/körper/körperOberschenkelL.png";
        } else if (y > 310 && x > 88){
            selected = 7;
            body.src = "/images/körper/körperUnterschenkelL.png";
        } else if (y > 205 && y < 310 && x <= 88){
            selected = 8;
            body.src = "/images/körper/körperOberschenkelR.png";
        } else if (y > 310 && x < 88){
            selected = 9;
            body.src = "/images/körper/körperUnterschenkelR.png";
        }

        title.innerText = bodyParts[selected];
        updateVerletzungsblock();
    }

    function addVerletzungsblock() {
        const container = document.getElementById("verletzungsblock");
        const idx = counter[selected];
        const div = document.createElement("div");
        div.className = `mb-3 input-group verletzungsfeld feld-${selected}`;
        div.innerHTML = `
        <input type="number" min="1" max="100" value="1" style="max-width: 20%" class="form-control" name="verletzungAnzahl_${selected}_${idx}" id="verletzungAnzahl_${selected}_${idx}" onfocusout="preise[${selected}][${idx}] = calcPrice('verletzung_${selected}_${idx}', 'verletzungAnzahl_${selected}_${idx}')">
        <input type="text" list="verletzungenListe" class="form-control" name="verletzung_${selected}_${idx}" id="verletzung_${selected}_${idx}" onfocusout="preise[${selected}][${idx}] = calcPrice('verletzung_${selected}_${idx}', 'verletzungAnzahl_${selected}_${idx}')">
    `;
        container.appendChild(div);
        counter[selected]++;
        updateVerletzungsblock();
    }

    function deleteVerletzungsblock() {
        if (counter[selected] <= 0) return;
        const container = document.getElementById("verletzungsblock");
        const blocks = container.querySelectorAll(`.feld-${selected}`);
        if (blocks.length) blocks[blocks.length - 1].remove();
        counter[selected]--;
        preise[selected].pop();
        updatePrice();
    }

    function updateVerletzungsblock() {
        const all = document.querySelectorAll(".verletzungsfeld");
        all.forEach(el => el.style.display = 'none');
        const current = document.querySelectorAll(`.feld-${selected}`);
        current.forEach(el => el.style.display = 'flex');
    }
</script>
</body>
</html>