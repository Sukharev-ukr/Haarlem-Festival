<?php
require_once(__DIR__ . "/../controllers/DanceController.php");

Route::add('/detailArtistPage', function () {
    $danceID = isset($_GET['danceID']) ? (int)$_GET['danceID'] : null;

    if ($danceID) {
        $danceController = new DanceController();
        $artistDetails = $danceController->getArtistDetailsByDanceID($danceID);

        if (!$artistDetails) {
            echo "<h3>No details found for the selected artist.</h3>";
            exit;  // Stop rendering if no data
        }
    } else {
        echo "<h3>Invalid or missing dance ID.</h3>";
        exit;  // Stop if no valid danceID
    }

    require(__DIR__ . "/../views/pages/detailArtistPage.php");
});