<?php
    include './osztalyka.php';

    $utvonal = new Utvonal($_SERVER['REQUEST_URI']);
    $utvonal->utvonalVizsgalat();
?>