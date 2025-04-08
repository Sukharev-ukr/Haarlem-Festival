<?php 
require_once __DIR__ . '/../../config.php';
ensure_logged_in();
$userId = $_SESSION['user']['userID'];

require(__DIR__ . '/../partials/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Haarlem Festival</title>
  

  <!-- Defer ensures JS runs after the DOM is loaded -->
  <script src="/assets/js/homepage.js" defer></script>
</head>
<body>

  <!-- HERO / TIMER SECTION -->
  <section class="hero-section" style="background-color: #8B0000; color: #fff; text-align: center; padding: 100px 0;">
    <div class="hero-container" style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
      <h1 class="hero-title" style="font-size: 3rem; font-weight: bold; margin-bottom: 1rem;">
        THE FESTIVAL IS COMING!
      </h1>

      <!-- The container that your JS updates if the festival has started -->
      <div id="countdown" style="font-size: 2.5rem; margin-bottom: 0.5rem;">
        <span id="days">245</span> :
        <span id="hours">06</span> :
        <span id="minutes">38</span> :
        <span id="seconds">59</span>
      </div>
      <div id="timer-labels" style="font-size: 1.2rem; margin-bottom: 2rem;">
        Days &nbsp;|&nbsp; hours &nbsp;|&nbsp; minutes &nbsp;|&nbsp; seconds
      </div>

      <p class="hero-description" style="font-size: 1.2rem; max-width: 600px; margin: 0 auto 2rem; line-height: 1.5;">
        Experience the vibrant spirit of Haarlem in an unforgettable 4-day celebration 
        of music, culture, food, and history.
      </p>
      
    </div>
  </section>

</body>
</html>

    <!-- DISCOVER DINING SECTION -->
    <!-- DISCOVER DINING SECTION -->
<!-- DISCOVER DINING SECTION -->
<section class="discover-dining" style="background-color: #fff; color: #000; padding: 60px 0;">
  <div class="container">
    <div class="row">
      
      <!-- Left column (Text) -->
      <div class="col-md-6">
        <h2 style="color: #8B0000; font-size: 2rem; margin-bottom: 1rem;">
          Discover dining
        </h2>
        <h3 style="margin-bottom: 1rem;">"Indulge in Haarlem’s Culinary Delights"</h3>
        <p style="max-width: 800px; margin-bottom: 1rem;">
          Dive into a world of flavor at the Haarlem Festival, where food brings the city’s vibrant culture to life.
          From traditional Dutch delicacies to international cuisines, our dining experiences showcase the best Haarlem has to offer.
        </p>
        <p style="max-width: 800px; margin-bottom: 2rem;">
          Explore cozy cafes, bustling markets, and family-owned eateries, each with its own story to tell. 
          Designed for everyone—whether you’re a passionate foodie, a family looking for a great meal, 
          or someone with dietary preferences—our festival ensures an inclusive and unforgettable dining journey.
        </p>
        <p style="max-width: 800px; margin-bottom: 2rem;">
          Taste the spirit of Haarlem.
        </p>
        <a href="/restaurants" style="background-color: #8B0000; color: #fff; padding: 0.5rem 1rem; text-decoration: none;">
          Learn more
        </a>
      </div>
      
      <!-- Right column (3×3 image grid, no text under images) -->
      <div class="col-md-6">
        <?php
          // If you want EXACTLY 9 images, slice the array:
          $diningPics = array_slice($diningRestaurants ?? [], 0, 6);
        ?>
        <div class="row row-cols-3 g-3 mt-4">
          <?php if (!empty($diningPics)): ?>
            <?php foreach ($diningPics as $r): ?>
              <div class="col text-center">
                <div style="width: 200px; height: 200px; margin: 0 auto; overflow: hidden;">
                  <img 
                    src="<?= htmlspecialchars($r['restaurantPicture'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                    alt="Dining picture"
                    style="width: 100%; height: 100%; object-fit: cover; display: block;"
                  >
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="col-12">
              <p>No dining images available.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
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
  <h3>Map of the Restaurants</h3>
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m52!1m12!1m3!1d4871.282298731292!2d4.6300015009108035!3d52.37692658809596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m37!3e2!4m5!1s0x47c5ef6ad50d053b%3A0x9f83720b021b43f2!2zQ2Fmw6kgZGUgUm9lbWVyLCBCb3Rlcm1hcmt0LCDQpdCw0YDQu9C10Lw!3m2!1d52.3798769!2d4.6318725!4m5!1s0x47c5ef6bd9e573fb%3A0x8c3546c16902f0f2!2sRatatouille%20Food%20%26%20Wine%2C%20Spaarne%2C%20Haarlem!3m2!1d52.3786888!2d4.6375022!4m5!1s0x47c5ef6bde79afb1%3A0x1942bb2b1e079dcb!2zSG90ZWwgTUwsIEtsb2todWlzcGxlaW4sINCl0LDRgNC70LXQvA!3m2!1d52.3809622!2d4.6384677!4m5!1s0x47c5ef41296bd029%3A0xcd09d3d53371340a!2sRestaurant%20Fris%20-%20Haarlem%2C%20Twijnderslaan%207%2C%202012%20BG%20Haarlem!3m2!1d52.372249599999996!2d4.6341972!4m5!1s0x47c5ef5598e3c30f%3A0x8b30f647d6a5bb41!2sNew%20Vegas%2C%20Koningstraat%2C%20Haarlem!3m2!1d52.3811098!2d4.6349206!4m5!1s0x47c5ef6b85897acd%3A0x31d97d67297dc088!2zR3JhbmQgQ2Fmw6kgQnJpbmttYW5uLCBHcm90ZSBNYXJrdCwg0KXQsNGA0LvQtdC8!3m2!1d52.3816505!2d4.6361497!5e0!3m2!1sru!2snl!4v1744142204834!5m2!1sru!2snl"
    width="600"
    height="450"
    style="border:0;"
    allowfullscreen
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
  ></iframe>
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
        <a href="/dancePage" style="color: #fff; background-color: #8B0000; padding: 0.5rem 1rem; text-decoration: none;">
          Learn more
        </a>
      </div>

      <!-- Right Image Grid (3 columns always) -->
      <div class="col-12 col-md-8">
        <div class="row row-cols-3 g-3">
          <?php if (!empty($artists)): ?>
            <?php foreach ($artists as $artist): ?>
              <div class="col">
                <div class="text-center">
                  <img 
                    class="img-fluid" 
                    src="/<?= htmlspecialchars($artist['artistImage']) ?>" 
                    alt="<?= htmlspecialchars($artist['artistName']) ?>"
                  >
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
            <iframe
    src="https://www.google.com/maps/embed?pb=!1m46!1m12!1m3!1d9741.907770133437!2d4.6304700862868895!3d52.37990375239471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m31!3e2!4m5!1s0x47c5ef63abd6db51%3A0x1a67ea388cf3c163!2sLichtfabriek%2C%20Energieplein%2073%2C%202031%20TC%20Haarlem!3m2!1d52.3863512!2d4.6517531!4m5!1s0x47c5ef67998a2033%3A0x70e72125409378cb!2sSlachthuis%20Haarlem%2C%20Rockplein%206%2C%202033%20KK%20Haarlem!3m2!1d52.3734833!2d4.6506272!4m5!1s0x47c5effb7e82034d%3A0xd3bfae70dd4a57b6!2sPuncher%20Comedy%20Club%2C%20Grote%20Markt%2010%2C%202011%20RD%20Haarlem!3m2!1d52.3814731!2d4.6353846999999995!4m5!1s0x47c5ef6b7544b863%3A0x2c30c30bcd58e92f!2sCaf%C3%A9%20XO%2C%20Grote%20Markt%208%2C%202011%20RD%20Haarlem!3m2!1d52.381214199999995!2d4.6352551!4m5!1s0x47c5ef14ed768603%3A0x5ff6ab7a87061c90!2sJopen%2C%20Gedempte%20Voldersgracht%202%2C%202011%20WD%20Haarlem!3m2!1d52.3812145!2d4.6297315!5e0!3m2!1sru!2snl!4v1744142675633!5m2!1sru!2snl"
    width="600"
    height="450"
    style="border:0;"
    allowfullscreen
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
  ></iframe>
  

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


    

    <!-- DISCOVER THE SECRET SECTION -->
<!-- DISCOVER THE SECRET SECTION -->
<section style="background-color: #fff; color: #000; padding: 60px 0;">
  <div class="container" 
       style="max-width: 1200px; 
              margin: 0 auto; 
              display: flex; 
              align-items: center; 
              gap: 40px; 
              flex-wrap: wrap;">

    <!-- Left Column: Big image -->
    <div style="flex: 1 1 400px; text-align: center;">
      <!-- Update the path to the actual DB field or direct path 
           If your DB has, e.g., /assets/img/lorentz/phone.jpg, then use that here -->
      <img src="/assets/img/lorentz/phone.jpg" 
           alt="Professor Teyler App" 
           style="max-width: 300px; 
                  width: 100%; 
                  height: auto;">
    </div>

    <!-- Right Column: Text and buttons -->
    <div style="flex: 1 1 400px;">
      <h2 style="color: #8B0000; margin-bottom: 1rem; font-size: 2rem;">
        Discover the secret 
        <br>
        of professor Teyler
      </h2>
      <p style="margin-bottom: 1.5rem; font-size: 1rem; line-height: 1.5;">
        An exciting app that brings a world of creativity and entertainment to kids.
        Dive into interactive games, explore creative workshops, and embark on thrilling challenges. 
        The Festival app is designed to ignite the imagination and keep kids engaged for hours.
      </p>

      <p style="font-weight: bold; margin-bottom: 0.5rem; font-size: 1.2rem;">
        The Lorentz Formula
      </p>
      <p style="font-style: italic; margin-bottom: 2rem;">A Theatrical Tour of the Lorentz Lab</p>

      <!-- App Store icons (optional) -->
      <div style="margin-bottom: 1.5rem;">
        <!-- <img src="/assets/img/appstore.png" alt="App Store" style="width: 120px; margin-right: 1rem;">
        <img src="/assets/img/googleplay.png" alt="Google Play" style="width: 120px;"> -->
      </div>

      <a href="#" style="background-color: #8B0000; 
                         color: #fff; 
                         padding: 0.5rem 1rem; 
                         text-decoration: none; 
                         border-radius: 4px;">
        Check the date
      </a>
    </div>

  </div>
</section>


</main>




<?php require(__DIR__ . '/../partials/footer.php'); ?>