<?php

use de\themarcraft\ggh\EH_Schein;

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['erstehilfeschein'])){
    $eh = EH_Schein::getEH_ScheinByUrl($_GET['erstehilfeschein']);
    $id = $eh->getId();
    if ($id < 10){
        $id = '000'.$id;
    }elseif ($id < 100){
        $id = '00'.$id;
    }elseif ($id < 1000){
        $id = '0'.$id;
    }
    $html = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/html/EH_Schein.htm');
    $html = str_replace('%<span class=SpellE>name</span>%', $eh->getName(), $html);
    $html = str_replace('%<span class=SpellE>id</span>%', $id, $html);
    $html = str_replace('%<span class=SpellE>datum</span>%', $eh->getDatum(), $html);
    echo $html;
    echo '<script>print()</script>';
}