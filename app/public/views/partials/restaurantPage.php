<div class="dining-banner-container">
    <!-- Transparent overlay on the banner -->
    <div class="dining-banner-text">
        <p>“Global Flavours, Local Vibes: The Foodie Paradise of Haarlem Festival!”</p>
    </div>
        <!-- Banner images -->
        <div class="dining-banner-images">
            <img src="/assets/img/dining/banner1.jpg" alt="Dining Experience 1">
            <img src="/assets/img/dining/banner2.jpg" alt="Dining Experience 2">
            <img src="/assets/img/dining/banner3.jpg" alt="Dining Experience 3">
        </div>
        <!-- Next button on banner -->
        <button class="dining-prev" onclick="diningMoveSlide(-1)">&#10094;</button>
        <button class="dining-next" onclick="diningMoveSlide(1)">&#10095;</button>
        <!-- Dots on bottom of banner -->
        <div class="dining-dots">
        <span class="dining-dot" onclick="diningCurrentSlide(1)"></span>
        <span class="dining-dot" onclick="diningCurrentSlide(2)"></span>
        <span class="dining-dot" onclick="diningCurrentSlide(3)"></span>
    </div>
    </div>
    <div class="dining-info-section">
    <h2>About the Haarlem festival:</h2>
    <p>
        Dive into a world of flavors and culinary delights that will leave your taste buds craving more! 
        The Haarlem Festival is your ultimate destination for food lovers, offering an incredible variety of cuisines, 
        unique experiences, and unforgettable flavors.
    </p>

    <div class="dining-info-columns">
        <div class="dining-info-left">
            <p>🌍 <strong>Global Flavours</strong></p>
            <p>From Dutch classics like stroopwafels to international cuisines, explore a variety of delicious dishes.</p>

            <p>🍽️ <strong>Live Cooking Shows</strong></p>
            <p>Watch top chefs create magic and learn their secrets.</p>

            <p>🍰 <strong>Sweet Treats</strong></p>
            <p>Indulge in desserts like creamy gelato, pastries, and the exclusive Haarlem Honey Cake.</p>
        </div>

        <div class="dining-info-right">
            <p>🍷 <strong>Craft Drinks</strong></p>
            <p>Enjoy local beers, wines, cocktails, and refreshing mocktails.</p>

            <p>🌱 <strong>Sustainable Eats</strong></p>
            <p>Try eco-friendly, plant-based dishes at the Green Eats Pavilion.</p>

            <p>🎪 <strong>Unique Dining</strong></p>
            <p>Experience outdoor feasts, pop-up restaurants, and vibrant food stalls.</p>
        </div>
    </div>
</div>

<div class="dining-title-container">
    <h1 class="dining-title">Discover your next favourite dining experience!</h1>
</div>
<div class="restaurant-grid">
    <?php foreach ($restaurants as $restaurant): ?>
        <?php
        // Generate the restaurant image filename
        $restaurantSlug = strtolower(str_replace(' ', '_', $restaurant['restaurantName'] ?? 'unknown'));
        $imgPathJpg = "/assets/img/dining/{$restaurantSlug}.jpg";
        $imgPathJpeg = "/assets/img/dining/{$restaurantSlug}.jpeg";

        // Check which image file exists
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imgPathJpg)) {
            $imgPath = $imgPathJpg;
        } elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . $imgPathJpeg)) {
            $imgPath = $imgPathJpeg;
        } else {
            $imgPath = "/assets/img/dining/default.jpg"; // Fallback image if none exist
        }
        ?>

        <div class="restaurant-card">
            <img src="<?= $imgPath ?>" alt="<?= htmlspecialchars($restaurant['restaurantName'] ?? 'Unknown') ?>">
            <div class="restaurant-info">
                <h2><?= htmlspecialchars($restaurant["restaurantName"] ?? 'Unknown') ?></h2>
                <p class="address">Address: <?= htmlspecialchars($restaurant["address"] ?? 'Not available') ?></p>
                <p class="phone">Phonenumber: <?= htmlspecialchars($restaurant["phone"] ?? 'Not available') ?></p>
                <p class="cuisine">Cuisine: <?= htmlspecialchars($restaurant["cuisine"] ?? 'Not specified') ?></p>
                <button class="buttondashboard" onclick="location.href='/restaurant?restaurantID=<?= (int)($restaurant['restaurantID'] ?? 0) ?>'">
                    View Details
                </button>
            </div>  
        </div>
    <?php endforeach; ?>
</div>

<!-- Interactive Map -->
<div id="map"></div>

<!-- Store JSON Data for JavaScript -->
<script type="application/json" id="restaurant-data"><?= json_encode($restaurants) ?></script>

<!-- FAQ Section -->
<div class="faq-container">
    <div class="faq-header">
        <h2>FAQs</h2>
        <p>Find answers to your questions about our historical tours and participation requirements.</p>
        <button class="faq-button">Contact us</button>
    </div>
    <div class="faq-items">
        <div class="faq-item">
            <h3>What types of cuisines are available during the Haarlem Festival?</h3>
            <p>The festival offers a diverse range of cuisines, including Dutch classics, French delicacies, global fusion dishes, and options for vegetarian, vegan, and gluten-free diets.</p>
        </div>
        <div class="faq-item">
            <h3>How do I book a table at a restaurant during the festival?</h3>
            <p>You can book a table directly through the restaurant page. Select your preferred restaurant, date, and time, and indicate any special requests, such as dietary restrictions or allergies.</p>
        </div>
        <div class="faq-item">
            <h3>Are the restaurants family-friendly?</h3>
            <p>Yes, many of the participating restaurants offer family-friendly environments and special menus for children.</p>
        </div>
        <div class="faq-item">
            <h3>Are there options for people with dietary restrictions or allergies?</h3>
            <p>Yes, participating restaurants cater to a variety of dietary needs. Please mention your restrictions when booking a table to ensure your requirements are accommodated.</p>
        </div>
        <div class="faq-item">
            <h3>What payment methods are accepted at the restaurants?</h3>
            <p>Most restaurants accept a variety of payment methods, including cash, debit cards, and major credit cards. Check the specific restaurant's details for more information.</p>
        </div>
    </div>
</div>

<!-- Navigation to Other Events -->
<div class="event-navigation">
    <h2>Looking for more?</h2>
    <div class="event-links">
        <a href="/" class="event-button">
            <span>History</span>
            <div class="event-arrow">➜</div>
        </a>

        <a href="/dancePage" class="event-button">
            <span>Dance!</span>
            <div class="event-arrow">➜</div>
        </a>

        <a href="/" class="event-button">
            <span>Magic @ Teylers</span>
            <div class="event-arrow">➜</div>
        </a>
    </div>
</div>


<?php require "views/partials/footer.php"; ?>

<script>
        let diningSlideIndex = 0;
        const diningSlides = document.querySelectorAll(".dining-banner-images img");
        const diningDots = document.querySelectorAll(".dining-dot");

        function diningShowSlide(index) {
            if (index >= diningSlides.length) diningSlideIndex = 0;
            if (index < 0) diningSlideIndex = diningSlides.length - 1;

            document.querySelector(".dining-banner-images").style.transform = `translateX(${-diningSlideIndex * 100}%)`;

            diningDots.forEach(dot => dot.classList.remove("active"));
            diningDots[diningSlideIndex].classList.add("active");
        }

        function diningMoveSlide(step) {
            diningSlideIndex += step;
            diningShowSlide(diningSlideIndex);
        }

        function diningCurrentSlide(index) {
            diningSlideIndex = index - 1;
            diningShowSlide(diningSlideIndex);
        }

        function diningAutoSlide() {
            diningMoveSlide(1);
        }

        diningShowSlide(diningSlideIndex);
        setInterval(diningAutoSlide, 5000); // Auto-slide every 5 seconds
    </script>
    <!-- Leaflet.js for Maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="/assets/js/restaurant.js"></script>
    
