<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.2, user-scalable=no">
<style>
    ::-webkit-scrollbar {
        display: none;
    }

    *{
        cursor: default;
        user-select: none;
        -webkit-user-select: none; /* Safari */
    }

    li{
        cursor: pointer;
    }

    i{
        cursor: pointer;
    }

    input[type=text]{
        cursor: text;
    }

    input[type=checkbox]{
        cursor: pointer;
    }

    label{
        cursor: pointer;
    }
</style>
<?php
$suffix = "";
if (isset($_GET['fivem'])){
    $suffix = "&fivem=".$_GET['fivem'];
}
?>
<div class="col-md-3 col mb-3">
    <ul class="list-group">
        <li class="list-group-item"><img src="/images/logo.png" class="w-100" draggable="false"></li>
        <li onclick="location.href = '/?s=home<?= $suffix ?>'" class="list-group-item list-group-item-action">Home</li>
        <li onclick="location.href = '/?s=patientenakten<?= $suffix ?>'" class="list-group-item list-group-item-action">Patientenakten</li>
        <?php

        use de\themarcraft\ggh\Mitarbeiter;

        if (Mitarbeiter::getMitarbeiterById($_SESSION['SSID'] ?? base64_decode(base64_decode($_GET['fivem'])))->getRangId() <= 2) {
            echo '<li onclick="location.href = \'/?s=mitarbeiterverwaltung'.$suffix.'\'" class="list-group-item list-group-item-action">Mitarbeiterverwaltung</li>';
            echo '<li onclick="location.href = \'/?s=verletzungen'.$suffix.'\'" class="list-group-item list-group-item-action">Verletzungsverwaltung</li>';
        }
        if (Mitarbeiter::getMitarbeiterById($_SESSION['SSID'] ?? base64_decode(base64_decode($_GET['fivem'])))->getRangId() <= 1) {
            echo '<li onclick="location.href = \'/?s=ehscheine'.$suffix.'\'" class="list-group-item list-group-item-action">Erste Hilfe Scheine</li>';
        }
        ?>
        <li onclick="location.href = '/?s=settings<?= $suffix ?>'" class="list-group-item list-group-item-action">Einstellungen</li>
        <li onclick="location.href = '/?s=logout<?php if (isset($_GET['fivem'])){echo "&fivem"; } ?>'" class="list-group-item list-group-item-action">Abmelden</li>
    </ul>
</div>