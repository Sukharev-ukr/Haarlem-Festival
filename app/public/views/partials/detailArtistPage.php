<?php
require_once(__DIR__ . "/../../controllers/DanceController.php");

$danceID = $_GET['danceID'] ?? null;
$danceController = new DanceController();
$artistDetails = $danceController->getArtistDetailsByDanceID($danceID);

if (!$artistDetails) {
    echo "<h3>No details found for the selected artist.</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haarlem Festival - Artist Details</title>
    <link rel="stylesheet" href="../../assets/css/danceDetail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

<!-- Banner Section -->
<section class="banner-container">
    <img src="../../assets/imageArtits/event.jpeg" alt="Banner Background">
    <div class="banner-text">
    <h1>
    <span class="white">SEE</span> 
    <?php 
    // Extract artist names and join with ' and '
    $artistNames = array_map(function($artist) {
        return strtoupper($artist['artistName']);
    }, $artistDetails);

    echo '<span class="orange">' . implode(' AND ', $artistNames) . '</span>';
    ?>
    <span class="white">IN HAARLEM</span>
</h1>
    </div>
</section>


<section class="container mt-5">
    <h2 class="text-center mb-4 text-warning">Artists Performing at Haarlem</h2>

    <!-- Grid Layout for Ticket and Artist Details -->
    <section class="row gx-5">
        <!-- Ticket Info Section (Left Side) -->
        <aside class="col-md-4">
            <section class="ticket-info shadow rounded p-3 mb-4 bg-light">
                <h4><i class="fa fa-map-marker-alt text-danger me-2"></i>Haarlem</h4>
                <p><strong><i class="fa fa-calendar-alt text-warning me-2"></i>Date:</strong> <?= date('l, d M Y', strtotime($artistDetails[0]['danceDate'])) ?></p>
                <p><strong><i class="fa fa-clock text-warning me-2"></i>Time:</strong> <?= $artistDetails[0]['startTime'] ?> - <?= $artistDetails[0]['endTime'] ?></p>
                <p><strong><i class="fa fa-map-marker text-danger me-2"></i>Location:</strong> <?= $artistDetails[0]['location'] ?></p>
                <p><strong><i class="fa fa-ticket-alt text-warning me-2"></i>Tickets Left: </strong><?= $artistDetails[0]['totalSeats'] ?></p>
                <h5 class="text-success">Ticket Price: €<?= $artistDetails[0]['ticketPrice'] ?></h5>
                <?php if (isset($artistDetails[0]['danceID'])): ?>
    <a href="/ticketSelection?danceID=<?php echo $artistDetails[0]['danceID']; ?>" class="btn btn-warning text-white mt-2">Get Concert Ticket</a>
<?php else: ?>
    <p>Dance ID not found.</p>
<?php endif; ?>
            </section>
        </aside>

        <!-- Artists Info Section (Right Side) -->
        <section class="col-md-8">
            <?php foreach ($artistDetails as $artist): ?>
                <article class="artist-card shadow rounded p-4 mb-4 bg-white">
                    <section class="row align-items-center">
                        <figure class="col-md-5 text-center">
                            <img src="/<?= $artist['artistPicture'] ?>" alt="<?= $artist['artistName'] ?>" class="img-fluid rounded mb-3 artist-image border">
                        </figure>
                        <section class="col-md-7">
                            <h3 class="text-warning"><?= $artist['artistName'] ?></h3>
                            <p><strong><i class="fa fa-music text-danger me-2"></i>Style:</strong> <?= $artist['artistStyle'] ?></p>
                            <p><strong><i class="fa fa-flag text-warning me-2"></i>Country of Origin:</strong> <?= $artist['artistOrigin'] ?> <img src="../../assets/imageArtits/Netherlan flag.jpeg" alt="Netherlands" class="flag-icon"></p>
                            <p><strong><i class="fa fa-info-circle text-warning me-2"></i>Description:</strong> <?= $artist['artistDescription'] ?></p>
                            <h5 class="text-darkblue">Albums:</h5>
                            <ul>
                                <?php if ($artist['artistAlbums']): ?>
                                    <?php foreach (explode(', ', $artist['artistAlbums']) as $album): ?>
                                        <li><?= $album ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li>No albums available.</li>
                                <?php endif; ?>
                            </ul>
                            <h5 class="text-darkblue">Follow:</h5>
                            <div class="social-icons">
                                <a href="#" class="btn btn-outline-danger me-2">
                                    <i class="fab fa-youtube"></i> YouTube
                                </a>
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fab fa-spotify"></i> Spotify
                                </a>
                            </div>
                        </section>
                    </section>
                </article>
            <?php endforeach; ?>
        </section>
    </section>
</section>

</body>
</html>
