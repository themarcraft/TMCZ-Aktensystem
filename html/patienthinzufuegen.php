<?php

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Patient Hinzufügen", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<body>
<div class="container mt-5">
  <div class="row">
    <?php include("templates/sidebar.php") ?>
    <div class="col">
      <h2><a href="/?s=patientenakten"><i class="fa-solid fa-arrow-left"></i></a> Patient Hinzufügen</h2>
      <form method="post" action="/api/addPatient.php?submit=1">
        <div class="mb-3">
          <label for="vorname" class="form-label">Vorname</label>
          <input type="text" class="form-control" name="vorname" id="vorname" required>
        </div>
        <div class="mb-3">
          <label for="nachname" class="form-label">Nachname</label>
          <input type="text" class="form-control" name="nachname" id="nachname" required>
        </div>
        <div class="mb-3">
          <label for="geb" class="form-label">Geburtstag</label>
          <input type="date" class="form-control" name="geb" id="geb" required>
        </div>
        <div class="mb-3">
          <label for="tel" class="form-label">Telefonnummer</label>
          <input type="tel" class="form-control" name="tel" id="tel" required>
        </div>
        <div class="mb-3">
          <label for="job" class="form-label">Job</label>
          <input type="text" class="form-control" name="job" id="job" list="jobs">
          <datalist id="jobs">
            <option>Charité</option>
            <option>Autohaus</option>
            <option>Polizei</option>
            <option>Feuerwehr</option>
            <option>Pizza</option>
            <option>Braun GmbH</option>
            <option>Farmer</option>
            <option>Mechaniker</option>
            <option>Arbeitslos</option>
          </datalist>
        </div>
        <div class="mb-3">
          <label for="anmerkung" class="form-label">Anmerkung</label>
          <input type="text" class="form-control" name="anmerkung" id="anmerkung">
        </div>
        <input type="submit" value="Speichern" class="btn btn-primary w-100 mb-3">
      </form>
    </div>
  </div>
</div>
</body>
</html>