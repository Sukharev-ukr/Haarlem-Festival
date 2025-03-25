
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

<!-- Link to external CSS for the homepage -->
<link rel="stylesheet" href="/assets/css/homepage.css">

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
                <img src="/public/assets/images/dining1.jpg" alt="Dish 1" style="width: 200px;">
                <img src="/public/assets/images/dining2.jpg" alt="Dish 2" style="width: 200px;">
                <img src="/public/assets/images/dining3.jpg" alt="Dish 3" style="width: 200px;">
                <img src="/public/assets/images/dining4.jpg" alt="Dish 4" style="width: 200px;">
                <img src="/public/assets/images/dining5.jpg" alt="Dish 5" style="width: 200px;">
                <img src="/public/assets/images/dining6.jpg" alt="Dish 6" style="width: 200px;">
            </div>
        </div>
    </section>

    <!-- =========================
         MAP OF THE RESTAURANTS SECTION
    ========================== -->
    <!-- Map of the Restaurants Section -->
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

                <!-- Middle column: your static map or image -->
                <div style="text-align: center;">
                    <h3>Map of the restaurants</h3>
                    <img src="/public/assets/images/map-restaurants.jpg" alt="Map of the Restaurants" style="max-width: 100%; margin-bottom: 1rem;">
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
    <!-- DISCOVER DANCE SECTION -->
<section class="discover-dance" style="padding: 60px 0; background-color: #fff; color: #8B0000;">
  <div class="container" style="max-width: 1200px; margin: 0 auto;">
    
    <!-- Heading -->
    <h2 style="font-size: 2rem; margin-bottom: 1rem;">
      Discover dance
      <br><span style="font-size: 1.2rem; font-weight: normal;">on a Unique Walking Tour</span>
    </h2>

    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
      
      <!-- Left text block -->
      <div style="flex: 1 1 400px;">
        <p>
          Join us for an exhilarating dance experience at some of Haarlem’s most iconic venues. 
          From modern clubs to open-air theaters, feel the energy of live performances and vibrant music.
        </p>
        <p>
          Whether you’re into EDM, hip-hop, or traditional folk dance, our lineup offers a 
          diverse range of styles for everyone. Family tickets available for €60, covering up 
          to 4 participants.
        </p>
        <p>
          Get ready to move, groove, and create unforgettable memories in the heart of Haarlem!
        </p>
        <a href="#" style="color: #fff; background-color: #8B0000; padding: 0.5rem 1rem; text-decoration: none;">
          Learn more
        </a>
      </div>
      
      <!-- Right image grid (8 images) -->
      <div style="flex: 1 1 400px; display: flex; flex-wrap: wrap; gap: 10px;">
        <img src="/public/assets/images/dance1.jpg" alt="Dancer 1" style="width: 48%;">
        <img src="/public/assets/images/dance2.jpg" alt="Dancer 2" style="width: 48%;">
        <img src="/public/assets/images/dance3.jpg" alt="Dancer 3" style="width: 48%;">
        <img src="/public/assets/images/dance4.jpg" alt="Dancer 4" style="width: 48%;">
        <img src="/public/assets/images/dance5.jpg" alt="Dancer 5" style="width: 48%;">
        <img src="/public/assets/images/dance6.jpg" alt="Dancer 6" style="width: 48%;">
        <img src="/public/assets/images/dance7.jpg" alt="Dancer 7" style="width: 48%;">
        <img src="/public/assets/images/dance8.jpg" alt="Dancer 8" style="width: 48%;">
      </div>

    </div>
  </div>
</section>


     <!-- =========================
         MAP OF THE DANCE SECTION (Dynamic Data)
    ========================== -->
    <section class="map-of-dance" style="background-color: #8B0000; color: #fff; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; align-items: start;">
                
            <div>
    <h3>Visiting places</h3>
    <?php
    // Merge all days
    $allDance = array_merge($danceFriday, $danceSaturday, $danceSunday);

    // Extract only the locations
    $allLocations = array_map(function($item) {
        return $item['location'];
    }, $allDance);

    // Unique them
    $uniqueLocations = array_unique($allLocations);
    ?>

    <ol style="padding-left: 1.5rem;">
        <?php if (!empty($uniqueLocations)): ?>
            <?php foreach ($uniqueLocations as $loc): ?>
                <li style="margin-bottom: 10px;">
                    <?= htmlspecialchars($loc) ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No dance found.</li>
        <?php endif; ?>
    </ol>
</div>

                <!-- Middle Column: Static Map Image for Dance -->
                <div style="text-align: center;">
                    <h3>Map of the Dance</h3>
                    <img src="/assets/images/map-dance.jpg" alt="Map of the Dance" style="max-width: 100%; margin-bottom: 1rem;">
                    <a href="#" style="background-color: #fff; color: #8B0000; padding: 0.5rem 1rem; text-decoration: none;">Book the Ticket</a>
                </div>

                <!-- Right Column: Schedule for Dance -->
                <div>
                    <h3>Schedule</h3>
                    <ul style="list-style: none; padding-left: 0;">
                        <li>
                            <strong>25 July (Friday)</strong><br>
                            <?php if (!empty($danceFriday)): ?>
                                <?php foreach ($danceFriday as $f): ?>
                                    <?= htmlspecialchars($f['startTime']) ?> – <?= htmlspecialchars($f['location']) ?><br>
                                <?php endforeach; ?>
                            <?php else: ?>
                                No Friday events.
                            <?php endif; ?>
                        </li>
                        <li>
                            <strong>26 July (Saturday)</strong><br>
                            <?php if (!empty($danceSaturday)): ?>
                                <?php foreach ($danceSaturday as $s): ?>
                                    <?= htmlspecialchars($s['startTime']) ?> – <?= htmlspecialchars($s['location']) ?><br>
                                <?php endforeach; ?>
                            <?php else: ?>
                                No Saturday events.
                            <?php endif; ?>
                        </li>
                        <li>
                            <strong>27 July (Sunday)</strong><br>
                            <?php if (!empty($danceSunday)): ?>
                                <?php foreach ($danceSunday as $u): ?>
                                    <?= htmlspecialchars($u['startTime']) ?> – <?= htmlspecialchars($u['location']) ?><br>
                                <?php endforeach; ?>
                            <?php else: ?>
                                No Sunday events.
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    

    <!-- "Discover the secret" section (simplified) -->
<section style="background-color: #fff; color: #000; padding: 60px 0;">
  <div style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 40px; flex-wrap: wrap;">
    <!-- Left: phone/app image -->
    <div style="flex: 1 1 400px; text-align: center;">
      <img src="/public/assets/images/professor-teyler-app.png" 
           alt="Professor Teyler App" 
           style="max-width: 250px;">
    </div>
    <!-- Right: text & button -->
    <div style="flex: 1 1 400px;">
      <h2 style="color: #000; margin-bottom: 1rem;">
        Discover <span style="color: #FF8C00;">the secret</span>
        <br>of professor Teyler
      </h2>
      <p>
        An exciting app that brings a world of creativity and entertainment to kids...
      </p>
      <h3 style="color: #FF8C00; margin-top: 2rem;">The Lorentz Formula</h3>
      <p style="font-style: italic; margin-bottom: 1rem;">A Theatrical Tour of the Lorentz Lab</p>

      <!-- The button that triggers the modal -->
      <button id="openPopupBtn" 
        style="background-color: #8B0000; color: #fff; padding: 0.5rem 1rem; border: none; cursor: pointer;">
  Check the date
</button>

<!-- The overlay (hidden by default) -->
<div id="popupOverlay"
     style="display: none; /* Hidden initially */
            position: fixed; 
            top: 0; left: 0; 
            width: 100%; height: 100%; 
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999; 
            justify-content: center; 
            align-items: center;">
  
  <!-- The popup box -->
  <div id="popupBox"
       style="width: 576px; 
              height: 579px; 
              flex-shrink: 0; 
              background-color: #000; 
              color: #fff; 
              display: flex; 
              flex-direction: column; 
              justify-content: center; 
              align-items: center; 
              position: relative; /* So we can position the close button if needed */
              padding: 1rem;">
    
    <h2 style="margin-bottom: 1rem;">Days: Friday, Saturday and Sunday</h2>
    <h3 style="margin-bottom: 1rem;">Time: 12:30, 14:00 and 15:00</h3>
    <p style="margin-bottom: 2rem;">Only kids who are older than 10 years old are allowed</p>

    <!-- Close button -->
    <button id="closePopupBtn" 
            style="background-color: #FF8C00; 
                   color: #000; 
                   padding: 0.5rem 1rem; 
                   border: none; 
                   cursor: pointer;">
      Close
    </button>
  </div>
</div>
    </div>
  </div>
</section>

<!-- The Modal (hidden by default) -->
<div id="dateModal" 
     style="display: none; /* hidden initially */
            position: fixed; /* stay in place */
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.7); /* semi-transparent black overlay */
            justify-content: center; align-items: center;
            z-index: 9999;">
  
  <!-- Modal Content -->
  <div style="background-color: #000; color: #fff; padding: 30px; text-align: center; max-width: 400px; margin: auto;">
    <h3 style="margin-bottom: 1rem;">Days: Friday, Saturday and Sunday</h3>
    <h4 style="margin-bottom: 1rem;">Time: 12:30, 14:00 and 15:00</h4>
    <p style="margin-bottom: 1rem;">Only kids who are older than 10 years old are allowed</p>
    <!-- Close button -->
    <button id="closeModalBtn" 
            style="background-color: #FF8C00; color: #000; padding: 0.5rem 1rem; border: none; cursor: pointer;">
      Close
    </button>
  </div>
</div>





</main>

<!-- Link to external JS for homepage functionality -->
<script src="/assets/js/homepage.js"></script>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
