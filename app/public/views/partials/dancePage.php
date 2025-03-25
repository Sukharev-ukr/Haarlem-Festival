<?php
// ✅ Start session if not started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Redirect if user not logged in
if (!isset($_SESSION['user'])) {
    header("Location: /user/login"); // send them to login page
    exit;
}

// ✅ Get user ID to use for cart/ticket actions
$userId = $_SESSION['user']['userID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dance Page</title>
    <link rel="stylesheet" href="../../assets/css/dancePage.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>

<div class="position-relative" style="height: 400px; overflow: hidden;">
    <!-- Video Background -->
    <video autoplay loop muted playsinline class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover;">
        <source src="../../assets/imageArtits/2022396-hd_1920_1080_30fps.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Text Over the Video -->
    <div class="position-absolute top-50 start-50 translate-middle text-center text-white">
        <h1 class="fw-bold">Welcome to the Haarlem Festival!</h1>
        <p>Experience the vibe of music and dance</p>
    </div>
</div>



<div class="container">
    <h2>Upcoming Event Around Haarlem</h2>
    <ul class="nav nav-tabs" id="danceTabs">
        <li class="nav-item">
            <a class="nav-link active" data-day="friday" href="#">Friday, Jul 2025</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-day="saturday" href="#">Saturday, Jul 2025</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-day="sunday" href="#">Sunday, Jul 2025</a>
        </li>
    </ul>

    <section class="container mt-4">
    <section class="row">
        <!-- Left Column: Dance Cards (3 per row) -->
        <section class="col-md-8">
           <section class="row g-4 justify-content-center" id="danceCards"> 
                <?php foreach (['friday' => $fridayDances, 'saturday' => $saturdayDances, 'sunday' => $sundayDances] as $day => $dances): ?>
                    <section class="day-group <?= $day ?>" style="<?= $day !== 'friday' ? 'display: none;' : '' ?>">
                        <section class="row row-cols-1 row-cols-md-3 g-4">
                            <?php foreach ($dances as $dance): ?>
                                <article class="col-sm-6 col-md-4 d-flex justify-content-center align-items-stretch">
                                   <figure class="card h-100 shadow-sm">
                                   <img class="card-img-top" src="/<?= $dance['artistImage'] ?>" alt="<?= $dance['artistName'] ?>">
                                     <figcaption class="card-body text-center">
                                       <p class="text-muted mb-1">
                                         <time datetime="<?= $dance['danceDate'] ?>">
                                            <i class="fa fa-calendar-alt me-1 text-warning"></i>  <!-- Calendar icon -->
                                            <?= date('l, d M Y', strtotime($dance['danceDate'])) ?>
                                         </time><br>
                                         <i class="fa fa-clock me-1 text-warning"></i>  <!-- Clock icon -->
                                         <?= $dance['startTime'] ?>
                                        </p>
                                       <h5 class="card-title text-primary fw-bold"><?= $dance['artistName'] ?></h5>
                                       <address class="card-text">
                                          <i class="fa fa-map-marker-alt me-1 text-warning"></i>  <!-- Location icon -->
                                          <?= $dance['location'] ?>
                                       </address>
                                       <a href="/detailArtistPage?danceID=<?= $dance['danceID'] ?>" class="btn btn-detail">See In Detail</a>
                                     </figcaption>
                                   </figure>
                               </article>
                            <?php endforeach; ?>
                        </section>
                    </section>
                <?php endforeach; ?>
            </section>
        </section>

        <!-- Right Column: "Little Bit Of Haarlem" -->
        <aside class="col-md-4">
            <article class="bg-light p-4 shadow-sm rounded">
                <h3 class="text-warning fw-bold mb-3">Little Bit Of Haarlem</h3>
                <p>Haarlem is a lovely historical city on the river Spaarne 20 km from Amsterdam. International tourism finally seems to have discovered the town's many charms, and an increasing number of visitors find their way here each year. A quick glance at the city centre makes it obvious why. Haarlem boasts a magnificent old centre with plenty of monumental buildings. As the city was home to several first class Dutch painters, including Frans Hals, there's a lot of art to go around. And if you're into shopping, a day in Haarlem is a day well spent too, as it was  best shopping city of the country several times. Other towns may lay claims to that title, but Haarlem's centre undisputably offers a colorful mix of large chain stores, specialty shops, boutiques and art galeries. A broad range of bars and restaurants makes the picture complete. In short, Haarlem is well worth a visit. For those who are wondering: yes, the famous New York City neighbourhood of Harlem is named after this once powerful Dutch city.</p>
                <a href="#" class="text-warning fw-bold">Read more about Haarlem</a>
            </article>
        </aside>
    </section>
</section>



<script>
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function () {
            const day = this.getAttribute('data-day');
            document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.day-group').forEach(group => group.style.display = 'none');
            document.querySelector('.' + day).style.display = 'block';
        });
    });

     // Save scroll position in localStorage when tab is clicked
     document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function () {
            const day = this.getAttribute('data-day');
            const scrollPosition = window.scrollY;  // Get current scroll position
            localStorage.setItem('scrollPosition', scrollPosition);  // Save to localStorage
            
            // Manage active tab and display corresponding cards
            document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('.day-group').forEach(group => group.style.display = 'none');
            document.querySelector('.' + day).style.display = 'block';
        });
    });

    // Restore scroll position when the page loads
    window.addEventListener('load', () => {
        const savedPosition = localStorage.getItem('scrollPosition');
        if (savedPosition) {
            window.scrollTo(0, parseInt(savedPosition));  // Restore scroll position
        }
    });
</script>

</body>
</html>

