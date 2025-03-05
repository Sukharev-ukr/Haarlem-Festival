<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Detail - The Haarlem Festival</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .banner {
            position: relative;
            background-image: url('banner.jpg'); /* Replace with actual banner path */
            background-size: cover;
            background-position: center;
            height: 300px;
            color: white;
        }
        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .banner h2 {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
        }
        .performance-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .artist-info {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .badge {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <!-- Header Section with Navigation Bar -->
    <header class="bg-danger text-white text-center py-2">
        <h1 class="display-4">The Haarlem Music Festival</h1>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="#">History</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Dining</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Dance!</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Magic @ Taylers</a></li>
                <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Banner Section -->
    <div class="banner">
        <div class="banner-overlay"></div>
        <h2>SEE NICKY ROMERO IN HAARLEM</h2>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-4 performance-card">
                <h5>Haarlem</h5>
                <p>Netherlands</p>
                <ul class="list-unstyled">
                    <li>📅 Friday, 25 Jul 2025</li>
                    <li>🕒 20:00 - 2:00</li>
                    <li>📍 <a href="#">Energielaan 73, 2031 TC Haarlem</a></li>
                    <li>🪑 1340/1500</li>
                </ul>
                <h4>Ticket Price: €75</h4>
                <a href="#" class="btn btn-warning w-100">Get Concert Ticket</a>
            </div>
            <div class="col-md-8 artist-info">
                <div class="row">
                    <div class="col-md-4">
                        <img src="artist_image.jpg" class="img-fluid rounded" alt="Artist Name">
                    </div>
                    <div class="col-md-8">
                        <h3 class="text-warning">Nicky Romero</h3>
                        <span class="badge bg-primary">Progressive House</span>
                        <span class="badge bg-secondary">Electrohouse</span>
                        <p class="mt-2">Nicky Romero, born January 6, 1989, is a renowned Dutch DJ...</p>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#" class="btn btn-outline-success">Spotify</a></li>
                            <li class="list-inline-item"><a href="#" class="btn btn-outline-danger">YouTube</a></li>
                        </ul>
                        <h5>Country of Origin:</h5>
                        <p>Netherlands</p>
                        <h5>Career:</h5>
                        <ul>
                            <li>Nicky Romero Presents: Protocol ADE 2015</li>
                            <li>Nicky Romero Presents: Miami 2014</li>
                            <li>Nicky Romero Presents: Protocol Miami 2017</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-primary text-white text-center py-3 mt-5">
        <p>&copy; 2025 The Haarlem Festival. All Rights Reserved.</p>
    </footer>
</body>
</html>
