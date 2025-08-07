<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;
use de\themarcraft\ggh\Verletzung;

$patient = PatientenAkte::getPatientById($_GET['id']);
include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Eintrag Hinzufügen", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2><a href="/?s=akte&id=<?= $patient->getId().$suffix ?>"><i class="fa-solid fa-arrow-left"></i></a> Patientenakten</h2>
            <table class="table">
                <tbody>
                <tr><td>Vorname</td><td><?= $patient->getVorname() ?></td></tr>
                <tr><td>Nachname</td><td><?= $patient->getNachname() ?></td></tr>
                <tr><td>Telefonnummer</td><td><?= $patient->getTelefonnummer() ?></td></tr>
                <tr><td>Job</td><td><?= $patient->getJob() ?></td></tr>
                <tr><td>Geburtstag</td><td><?= $patient->getGeburtstag() ?></td></tr>
                <tr><td>Anmerkung</td><td><?= $patient->getAnmerkung() ?></td></tr>
                </tbody>
            </table>

            <form action="/api/addEintrag.php?id=<?= $_GET['id'].$suffix ?>" method="post">
                <h3>Datum und Zeit</h3>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="datum" placeholder="Datum" value="<?= date("d.m.Y") ?>" required>
                    <input type="text" class="form-control" name="zeit" placeholder="Uhrzeit" value="<?= date("H:i") ?>" required>
                </div>

                <h3>Behandelndes Personal</h3>
                <?php foreach (Mitarbeiter::getMitarbeiter() as $behandler): ?>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="arzt<?= $behandler->getDienstnummer() ?>" name="arzt<?= $behandler->getDienstnummer() ?>" <?= $behandler->getDienstnummer() === $mitarbeiter->getDienstnummer() ? 'checked' : '' ?> >
                        <label class="form-check-label" for="arzt<?= $behandler->getDienstnummer() ?>">
                            <?= $behandler->getVorname() . ' ' . $behandler->getNachname() ?>
                        </label>
                    </div>
                <?php endforeach; ?>

                <h3>Anmerkungen</h3>
                <input class="form-control mb-3" placeholder="Anmerkungen" name="anmerkungen">

                <div class="row">
                    <div class="col">
                        <h3>Verletzungen</h3>
                        <img src="/images/körper/körperThorax.png" id="body" draggable="false" class="mb-3">
                    </div>
                    <div class="col">
                        <h3 id="bodyTitle">Thorax</h3>
                        <div id="verletzungsblock"></div>

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

                <h3>Preis</h3>
                <div class="input-group mb-3">
                    <button type="button" class="btn btn-info" onclick="updatePrice()">Preise Berechnen</button>
                    <input class="form-control" placeholder="Preis" id="preis" name="preis" type="number" required>
                </div>

                <input type="submit" value="Speichern" class="btn btn-primary w-100 mb-5">
            </form>
        </div>
    </div>
</div>

<datalist id="verletzungenListe">
    <?php foreach (Verletzung::getAll() as $verletzung): ?>
        <option><?= $verletzung->getBezeichnung() ?></option>
    <?php endforeach; ?>
</datalist>

<script>
    let counter = Array(10).fill(0);
    let selected = 1;
    let title = document.getElementById('bodyTitle');
    let body = document.getElementById('body')
    let preise = Array(10).fill().map(() => []);
    let bodyParts = [
        "Cranium", "Thorax",
        "Brachium R", "Antebrachium R", "Brachium L", "Antebrachium L",
        "Zeugopodium R", "Stylopodium R", "Zeugopodium L", "Stylopodium L",
    ];

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
    }
</script>
</body>
</html>
