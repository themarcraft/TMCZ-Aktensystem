<?php

use de\themarcraft\ggh\Mitarbeiter;

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Einstellungen", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));

?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
            <h2>Einstellungen</h2>
            <div class="container">
                <form action="/api/updatePasswd.php?submit=1" method="post">
                    <div class="mb-3">
                        <label class="form-label">Altes Passwort</label>
                        <input type="password" class="form-control" name="oldpasswd" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Neues Passwort</label>
                        <input type="password" class="form-control" name="newpasswd1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Neues Passwort wiederholen</label>
                        <input type="password" class="form-control" name="newpasswd2" required>
                    </div>
                    <input type="submit" value="Speichern" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>