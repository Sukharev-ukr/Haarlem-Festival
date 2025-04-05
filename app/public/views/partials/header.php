<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Site</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/assets/css/style.css">

    <?php
    // Define a mapping between routes and CSS files
    $cssMap = [
        "restaurants" => "restaurantPage.css",
        "restaurant" => "restaurantDetail.css",
        "dance" => "dancePage.css",
        "history" => "historyPage.css",
        "magic" => "magicPage.css",
        "payment" => "payment.css",
    ];

    // Get the current route (everything after the first `/`)
    $currentRoute = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '.php');

    echo "<!-- currentRoute = $currentRoute -->";
    // Find the right CSS file based on route mapping
    foreach ($cssMap as $route => $cssFile) {
        if (strpos($currentRoute, $route) !== false) {
            echo '<link rel="stylesheet" href="/assets/css/' . $cssFile . '?v=' . time() . '">';
            break;
        }
    }
    ?>

    <!-- JavaScript -->
    <script src="/assets/js/main.js"></script>
        <!-- jQuery and jQuery UI (for Datepicker) -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>

  <?php require(__DIR__ . "/header_nav.php");
