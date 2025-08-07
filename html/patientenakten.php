<?php

use de\themarcraft\ggh\Mitarbeiter;
use de\themarcraft\ggh\PatientenAkte;

include($_SERVER['DOCUMENT_ROOT']."/html/_inc.php");
echo str_replace('%s', "Patientenakten", file_get_contents($_SERVER['DOCUMENT_ROOT']."/html/_header.html"));
?>
<body>
<div class="container mt-5">
    <div class="row">
        <?php include("templates/sidebar.php") ?>
        <div class="col">
			<div class="row">
				<div class="col"><h2>Patientenakten</h2></div>
				<div class="col" style="text-align:right;">
					<form method="get" action="/<?= $suffix ?>" class="input-group">
						<input type="search" placeholder="Suche..." name="search" class="form-control" value="<?= $_GET['search'] ?? "" ?>">
						<input type="hidden" value="patientenakten" name="s">
						<button value="" class="fa-solid fa-magnifying-glass btn btn-primary"></button>
					</form>
				</div>
			</div>	
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Vorname</th>
                    <th scope="col">Nachname</th>
                    <th scope="col">Geburtstag</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td onclick="location.href = '/?s=addPatient<?= $suffix ?>'" colspan="2" class="table-primary">Patient Hinzufügen</td>
                    <td onclick="location.href = '/?s=sync<?= $suffix ?>'" class="table-primary" style="text-align: right"><i class="fa-solid fa-arrows-rotate"></i></td>
                </tr>
                <?php
                $patienten = PatientenAkte::getAllPatients();
                foreach ($patienten as $patient){
					if(!isset($_GET["search"])){
						if($patient->getId() == 2){
							echo '<tr class="table-info" onclick="location.href = `/?s=akte&id='.$patient->getId().$suffix.'`"><td>'.str_replace("--", "", $patient->getVorname()).'</td><td>'.str_replace("--", "", $patient->getNachname()).'</td><td>'.$patient->getGeburtstag().'</td></tr>';
						}elseif(str_contains($patient->getAnmerkung(), "Koma")){
                            echo '<tr class="table-danger" onclick="location.href = `/?s=akte&id='.$patient->getId().$suffix.'`"><td>'.$patient->getVorname().'</td><td>'.$patient->getNachname().'</td><td>'.$patient->getGeburtstag().'</td></tr>';
                        }elseif(str_contains($patient->getAnmerkung(), "Tot")){
                            echo '<tr class="table-dark" onclick="location.href = `/?s=akte&id='.$patient->getId().$suffix.'`"><td>'.$patient->getVorname().'</td><td>'.$patient->getNachname().'</td><td>'.$patient->getGeburtstag().'</td></tr>';
                        }else{
							echo '<tr onclick="location.href = `/?s=akte&id='.$patient->getId().$suffix.'`"><td>'.$patient->getVorname().'</td><td>'.$patient->getNachname().'</td><td>'.$patient->getGeburtstag().'</td></tr>';
						}
					}else{
						if(str_contains(strtolower($patient->getVorname()), strtolower($_GET["search"])) || str_contains(strtolower($patient->getNachname()), strtolower($_GET["search"]))){
                    		echo '<tr onclick="location.href = `/?s=akte&id='.$patient->getId().$suffix.'`"><td>'.$patient->getVorname().'</td><td>'.$patient->getNachname().'</td><td>'.$patient->getGeburtstag().'</td></tr>';
						}
					}
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>