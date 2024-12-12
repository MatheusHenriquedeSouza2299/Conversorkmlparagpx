<?php
require_once 'vendor/autoload.php';

use phpGPX\phpGPX;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kmlFile = $_FILES['kmlFile']['tmp_name'];
    $gpxFile = 'output.gpx';

    if (file_exists($kmlFile)) {
        $kmlContent = file_get_contents($kmlFile);

        // Convert KML to GPX using phpGPX library
        $gpx = new phpGPX();
        $gpx->load($kmlContent);
        $gpx->save($gpxFile);

        // Download the GPX file
        header('Content-Type: application/gpx+xml');
        header('Content-Disposition: attachment; filename="converted.gpx"');
        readfile($gpxFile);

        // Delete the temporary GPX file
        unlink($gpxFile);
    } else {
        echo 'Erro: O arquivo KML não foi encontrado.';
    }
}
?>
