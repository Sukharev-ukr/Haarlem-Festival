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

require(__DIR__ . '/../partials/header.php'); ?>

<main>
    <!-- =========================
         HERO / TIMER SECTION
    ========================== -->
    <section class="hero-section">
        <div class="hero-container">
            <h1 class="hero-title">THE FESTIVAL IS COMING!</h1>
            <!-- Real Countdown Timer -->
            <div id="countdown-container">
                <span id="days">245</span> :
                <span id="hours">06</span> :
                <span id="minutes">38</span> :
                <span id="seconds">59</span>
            </div>
            <div id="timer-labels">
                Days &nbsp;&nbsp;|&nbsp;&nbsp; hours &nbsp;&nbsp;|&nbsp;&nbsp; minutes &nbsp;&nbsp;|&nbsp;&nbsp; seconds
            </div>
            <p class="hero-description">
                Experience the vibrant spirit of Haarlem in an unforgettable 4-day celebration 
                of music, culture, food, and history.
            </p>
            <a href="#" class="btn-primary">Join waiting list</a>
        </div>
    </section>

    <!-- =========================
         DISCOVER DINING SECTION
         (Unchanged for now)
    ========================== -->
    <section style="background-color: #fff; color: #000; padding: 60px 0;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <h2 style="color: #8B0000; font-size: 2rem; margin-bottom: 1rem;">
                Discover dining
            </h2>
            <h3 style="margin-bottom: 1rem;">"Indulge in Haarlem’s Culinary Delights"</h3>
            <p style="max-width: 800px; margin-bottom: 1rem;">
                Dive into a world of flavor at the Haarlem Festival, where food brings the city’s vibrant culture to life. 
                From traditional Dutch delicacies to international cuisines, our dining experiences showcase the best Haarlem has to offer.
            </p>
            <p style="max-width: 800px; margin-bottom: 1rem;">
                Explore cozy cafes, bustling markets, and family-owned eateries, each with its own story to tell. 
                Designed for everyone—whether you’re a passionate foodie, a family looking for a great meal, 
                or someone with dietary preferences—our festival ensures an inclusive and unforgettable dining journey.
            </p>
            <p style="max-width: 800px; margin-bottom: 2rem;">
                Taste the spirit of Haarlem.
            </p>
            <a href="#" style="background-color: #8B0000; color: #fff; padding: 0.5rem 1rem; text-decoration: none;">
                Learn more
            </a>
            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 2rem;">
                <img src="/assets/images/dining1.jpg" alt="Dish 1" style="width: 200px;">
                <img src="/assets/images/dining2.jpg" alt="Dish 2" style="width: 200px;">
                <img src="/assets/images/dining3.jpg" alt="Dish 3" style="width: 200px;">
                <img src="/assets/images/dining4.jpg" alt="Dish 4" style="width: 200px;">
                <img src="/assets/images/dining5.jpg" alt="Dish 5" style="width: 200px;">
                <img src="/assets/images/dining6.jpg" alt="Dish 6" style="width: 200px;">
            </div>
        </div>
    </section>

    <!-- =========================
         MAP OF THE RESTAURANTS SECTION
         (Unchanged for now)
    ========================== -->
    <section class="map-of-restaurants" style="background-color: #002F5E; color: #fff; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <!-- Visiting places (restaurants) -->
                <div>
                    <h3>Visiting places</h3>
                    <ul style="padding-left: 1.2rem; list-style: none;">
                        <?php if (!empty($restaurants)): ?>
                            <?php foreach ($restaurants as $r): ?>
                                <li style="margin-bottom: 10px;">
                                    <strong><?= htmlspecialchars($r['restaurantName']) ?></strong><br>
                                    <?= htmlspecialchars($r['address']) ?><br>
                                    <?php if (!empty($r['cuisine'])): ?>
                                        <em><?= htmlspecialchars($r['cuisine']) ?></em><br>
                                    <?php endif; ?>
                                    <?php if (!empty($r['phone'])): ?>
                                        Phone: <?= htmlspecialchars($r['phone']) ?>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No restaurants found.</li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- Middle column: static map image -->
                <div style="text-align: center;">
                    <h3>Map of the restaurants</h3>
                    <img src="/assets/images/map-restaurants.jpg" alt="Map of the Restaurants" style="max-width: 100%; margin-bottom: 1rem;">
                </div>
                <!-- Right column: Fun fact & Contact -->
                <div>
                    <h3>Fun fact</h3>
                    <p style="margin-bottom: 2rem;">
                        Did you know?<br>
                        <strong>Home of Dutch Beer Culture</strong><br>
                        Haarlem has a long history of brewing beer, dating back to the Middle Ages. 
                        From hoppy IPAs to smooth lagers, there’s no shortage of options—out of a converted church!
                    </p>
                    <h3>Contact</h3>
                    <p>Email: <a href="mailto:info@haarfestival.com" style="color: #fff;">info@haarfestival.com</a></p>
                    <p>Phone: +31 6 666 6666</p>
                    <p>Hours: Monday to Friday, 10:00 AM – 6:00 PM</p>
                </div>
            </div>
        </div>
    </section>
<<!-- DISCOVER DANCE SECTION -->
<section class="discover-dance" style="background-color: #fff; color: #8B0000; padding: 60px 0;">
  <div class="container">
    <h2 style="font-size: 2rem; margin-bottom: 1rem;">
      Discover dance
      <br><span style="font-size: 1.2rem; font-weight: normal;">on a Unique Walking Tour</span>
    </h2>

    <div class="row g-4">
      <!-- Left Text Column -->
      <div class="col-12 col-md-4">
        <p>
          Join us for an exhilarating dance experience at some of Haarlem’s most iconic venues. 
          From modern clubs to open-air theaters, feel the energy of live performances and vibrant music.
        </p>
        <p>
          Whether you’re into EDM, hip-hop, or traditional folk dance, our lineup offers a 
          diverse range of styles for everyone. Family tickets available for €60, covering up 
          to 4 participants.
        </p>
        <a href="#" style="color: #fff; background-color: #8B0000; padding: 0.5rem 1rem; text-decoration: none;">
          Learn more
        </a>
      </div>

      <!-- Right Image Grid -->
      <div class="col-12 col-md-8">
        <!-- 
          Bootstrap row with auto-responsive columns:
          row-cols-2 => 2 columns on XS,
          row-cols-sm-3 => 3 columns on SM,
          row-cols-md-4 => 4 columns on MD+ screens 
        -->
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
        <?php if (!empty($artists)): ?>
  <?php foreach ($artists as $artist): ?>
    <div class="col">
      <div class="text-center">
        <img class="img-fluid" 
             src="/<?= htmlspecialchars($artist['artistImage']) ?>" 
             alt="<?= htmlspecialchars($artist['artistName']) ?>">
        <h5 class="mt-2" style="font-size: 1rem;">
          <?= htmlspecialchars($artist['artistName']) ?>
        </h5>
      </div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="col-12">
    <p>No artist images available.</p>
  </div>
<?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>


    <!-- =========================
         MAP OF THE DANCE SECTION
         Dynamic: Uses data from DanceController methods
    ========================== -->
    <section class="map-of-dance" style="background-color: #8B0000; color: #fff; padding: 60px 0;">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; align-items: start;">

            <!-- LEFT COLUMN: Unique Visiting Places -->
            <div>
                <h3>Visiting places</h3>
                <ol style="padding-left: 1.5rem; list-style: none;">
                    <?php
                    // Merge all days
                    $allDance = array_merge($danceFriday, $danceSaturday, $danceSunday);

                    // Extract just the 'location' values
                    $allLocations = array_map(function($dance) {
                        return $dance['location'];
                    }, $allDance);

                    // Unique them
                    $uniqueLocations = array_unique($allLocations);

                    // Display unique places
                    if (!empty($uniqueLocations)):
                        foreach ($uniqueLocations as $loc):
                            echo "<li style='margin-bottom: 10px;'>" . htmlspecialchars($loc) . "</li>";
                        endforeach;
                    else:
                        echo "<li>No dance events found.</li>";
                    endif;
                    ?>
                </ol>
            </div>

            <!-- MIDDLE COLUMN: Static Map Image + Button -->
            <div style="text-align: center;">
                <h3>Map of the Dance</h3>
                <img src="/assets/images/map-dance.jpg" alt="Map of the Dance" style="max-width: 100%; margin-bottom: 1rem;">
                <a href="#" style="background-color: #fff; color: #8B0000; padding: 0.5rem 1rem; text-decoration: none;">
                    Book the Ticket
                </a>
            </div>

            <!-- RIGHT COLUMN: Schedule (Friday, Saturday, Sunday) -->
            <div>
                <h3>Schedule</h3>
                <ul style="list-style: none; padding-left: 0;">
                    <!-- Friday -->
                    <li>
                        <strong>25 July (Friday)</strong><br>
                        <?php 
                        if (!empty($danceFriday)):
                            foreach ($danceFriday as $f):
                                echo htmlspecialchars($f['startTime']) . " – " . htmlspecialchars($f['location']) . "<br>";
                            endforeach;
                        else:
                            echo "No Friday dance events.";
                        endif;
                        ?>
                    </li>

                    <!-- Saturday -->
                    <li style="margin-top: 1rem;">
                        <strong>26 July (Saturday)</strong><br>
                        <?php 
                        if (!empty($danceSaturday)):
                            foreach ($danceSaturday as $s):
                                echo htmlspecialchars($s['startTime']) . " – " . htmlspecialchars($s['location']) . "<br>";
                            endforeach;
                        else:
                            echo "No Saturday dance events.";
                        endif;
                        ?>
                    </li>

                    <!-- Sunday -->
                    <li style="margin-top: 1rem;">
                        <strong>27 July (Sunday)</strong><br>
                        <?php 
                        if (!empty($danceSunday)):
                            foreach ($danceSunday as $u):
                                echo htmlspecialchars($u['startTime']) . " – " . htmlspecialchars($u['location']) . "<br>";
                            endforeach;
                        else:
                            echo "No Sunday dance events.";
                        endif;
                        ?>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>


    

    <!-- =========================
         MAP OF THE DANCE SECTION (Additional)
         (if any more sections needed, add here)
    ========================== -->

    <!-- =========================
         DISCOVER THE SECRET SECTION
         (Unchanged)
    ========================== -->
    <section style="background-color: #fff; color: #000; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 40px; flex-wrap: wrap;">
            <div style="flex: 1 1 400px; text-align: center;">
                <img src="/assets/images/professor-teyler-app.png" alt="Professor Teyler App" style="max-width: 200px;">
            </div>
            <div style="flex: 1 1 400px;">
                <h2 style="color: #8B0000; margin-bottom: 1rem;">Discover the secret <br>of professor Teyler</h2>
                <p>
                    An exciting app that brings a world of creativity and entertainment to kids. 
                    Dive into interactive games, explore creative workshops, and embark on thrilling challenges. 
                    The Festival app is designed to ignite the imagination and keep kids engaged for hours.
                </p>
                <p>
                    <strong>The Lorentz Formula</strong><br>
                    A Theatrical Tour of the Lorentz Lab
                </p>
                <a href="#" style="background-color: #8B0000; color: #fff; padding: 0.5rem 1rem; text-decoration: none;">Check the date</a>
            </div>
        </div>
    </section>

</main>


<!-- Real-time countdown script -->
<script>
  // Adjust the festival date/time below:
  const festivalDate = new Date("July 24, 2025 10:00:00").getTime();

  // Update every second
  const timer = setInterval(function() {
    const now = new Date().getTime();
    const distance = festivalDate - now;

    if (distance < 0) {
      clearInterval(timer);
      document.getElementById("countdown-container").textContent = "The festival has started!";
      document.getElementById("timer-labels").textContent = "";
      return;
    }

    // Calculate days, hours, minutes, seconds
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Update the page
    document.getElementById("days").textContent = days;
    document.getElementById("hours").textContent = hours;
    document.getElementById("minutes").textContent = minutes;
    document.getElementById("seconds").textContent = seconds;
  }, 1000);
</script>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
