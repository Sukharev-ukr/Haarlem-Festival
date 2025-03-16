<?php require(__DIR__ . '/../partials/header.php'); ?>

<main>

    <!-- =========================
         HERO / TIMER SECTION
    ========================== -->
    <section class="hero-section" style="background-color: #8B0000; color: #fff; padding: 100px 0; text-align: center;">
        <div class="container">
            <h1 style="font-size: 3rem; margin-bottom: 1rem;">THE FESTIVAL IS COMING!</h1>

            <!-- Countdown Timer (placeholder) -->
            <div class="countdown-timer" style="font-size: 2rem; margin-bottom: 1rem;">
                <span class="days" style="font-weight: bold;">245</span> : 
                <span class="hours" style="font-weight: bold;">06</span> : 
                <span class="minutes" style="font-weight: bold;">38</span> : 
                <span class="seconds" style="font-weight: bold;">59</span>
            </div>
            <div class="timer-labels" style="font-size: 1rem; margin-bottom: 2rem;">
                Days &nbsp;&nbsp; | &nbsp;&nbsp; hours &nbsp;&nbsp; | &nbsp;&nbsp; minutes &nbsp;&nbsp; | &nbsp;&nbsp; seconds
            </div>

            <p style="max-width: 600px; margin: 0 auto 2rem auto;">
                Experience the vibrant spirit of Haarlem in an unforgettable 4-day celebration 
                of music, culture, food, and history.
            </p>
            <a href="#" class="btn-primary" style="padding: 0.75rem 1.5rem; background-color: #fff; color: #8B0000; text-decoration: none; font-weight: bold;">
                Join waiting list
            </a>
        </div>
    </section>

    <!-- =========================
         DISCOVER HISTORY SECTION
    ========================== -->
    <section class="discover-history" style="padding: 60px 0; background-color: #fff; color: #8B0000;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem;">
                Discover history 
                <br><span style="font-size: 1.2rem; font-weight: normal;">on a Unique Walking Tour</span>
            </h2>

            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                <!-- Left text block -->
                <div style="flex: 1 1 400px;">
                    <p>
                        Join us for <em>"A Stroll Through History"</em> and explore Haarlem’s landmarks like 
                        the Church of St. Bavo, Amsterdamse Poort, and Grote Markt.
                    </p>
                    <p>
                        Choose from English, Dutch, or Chinese sessions. Family tickets available for €60, 
                        covering up to 4 participants. Tours run Thu–Sun, starting at the iconic Grote Markt.
                    </p>
                    <p>
                        Enjoy a personalized digital souvenir to remember your journey. 
                        Immerse yourself in Haarlem’s rich history and culture!
                    </p>
                    <a href="#" style="color: #fff; background-color: #8B0000; padding: 0.5rem 1rem; text-decoration: none;">
                        Learn more
                    </a>
                </div>

                <!-- Right info cards -->
                <div style="flex: 1 1 300px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div class="info-card" style="border: 1px solid #ccc; padding: 1rem;">
                        <h4>Duration</h4>
                        <p>2.5 hours</p>
                    </div>
                    <div class="info-card" style="border: 1px solid #ccc; padding: 1rem;">
                        <h4>Available days</h4>
                        <p>Thu, Fri, Sat, Sun</p>
                    </div>
                    <div class="info-card" style="border: 1px solid #ccc; padding: 1rem;">
                        <h4>Meeting point</h4>
                        <p>Grote Markt</p>
                    </div>
                    <div class="info-card" style="border: 1px solid #ccc; padding: 1rem;">
                        <h4>Age</h4>
                        <p>12+</p>
                    </div>
                    <div class="info-card" style="border: 1px solid #ccc; padding: 1rem;">
                        <h4>Price p.p</h4>
                        <p>€15</p>
                    </div>
                    <div class="info-card" style="border: 1px solid #ccc; padding: 1rem;">
                        <h4>Family ticket</h4>
                        <p>€60</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================
         MAP OF THE TOUR SECTION
    ========================== -->
    <section class="map-of-the-tour" style="background-color: #8B0000; color: #fff; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; align-items: start;">
                
                <!-- Visiting places -->
                <div>
                    <h3>Visiting places</h3>
                    <ol style="padding-left: 1.5rem;">
                        <li>Church of St. Bavo</li>
                        <li>Grote Markt</li>
                        <li>De Hallen</li>
                        <li>Proveniershof</li>
                        <li>Jopenkerk (Break location)</li>
                        <li>Waalse Kerk Haarlem</li>
                        <li>Molen de Adriaan</li>
                        <li>Amsterdamse Poort</li>
                        <li>Hof van Bakenes</li>
                    </ol>
                </div>

                <!-- Map of the tour -->
                <div style="text-align: center;">
                    <h3>Map of the tour</h3>
                    <img src="/public/assets/images/map-tour.jpg" alt="Map of the Tour" style="max-width: 100%; margin-bottom: 1rem;">
                    <a href="#" style="background-color: #fff; color: #8B0000; padding: 0.5rem 1rem; text-decoration: none;">
                        Book the tour
                    </a>
                </div>

                <!-- Schedule -->
                <div>
                    <h3>Schedule</h3>
                    <ul style="list-style: none; padding-left: 0;">
                        <li><strong>24 July (Thursday)</strong><br>10:00 (EN, NL), 16:00 (EN, NL)</li>
                        <li><strong>25 July (Friday)</strong><br>10:00 (EN, NL), 16:00 (EN, NL)</li>
                        <li><strong>26 July (Saturday)</strong><br>10:00 (EN, NL), 16:00 (EN, NL)</li>
                        <li><strong>27 July (Sunday)</strong><br>10:00 (EN, NL), 16:00 (EN, NL)</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================
         DISCOVER DINING SECTION
    ========================== -->
    <section class="discover-dining" style="background-color: #fff; color: #000; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
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

            <!-- Example image grid for dining -->
            <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 2rem;">
                <img src="/public/assets/images/dining1.jpg" alt="Dish 1" style="width: 200px;">
                <img src="/public/assets/images/dining2.jpg" alt="Dish 2" style="width: 200px;">
                <img src="/public/assets/images/dining3.jpg" alt="Dish 3" style="width: 200px;">
                <img src="/public/assets/images/dining4.jpg" alt="Dish 4" style="width: 200px;">
                <img src="/public/assets/images/dining5.jpg" alt="Dish 5" style="width: 200px;">
                <img src="/public/assets/images/dining6.jpg" alt="Dish 6" style="width: 200px;">
                <!-- Add as many images as needed -->
            </div>
        </div>
    </section>

    <!-- =========================
         MAP OF THE RESTAURANTS
    ========================== -->
    <section class="map-of-restaurants" style="background-color: #002F5E; color: #fff; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                
                <!-- Visiting places (restaurants) -->
                <div>
                    <h3>Visiting places</h3>
                    <ul style="padding-left: 1.2rem;">
                        <li>The patronaat</li>
                        <li>Café de Roemer</li>
                        <li>Ratatouille</li>
                        <li>Restaurant ML</li>
                        <li>Restaurant Fris</li>
                        <li>Grand Café Brinkman</li>
                        <li>New Vegas</li>
                        <li>Uthorn Frenchy Bistro Toujours</li>
                    </ul>
                </div>

                <!-- Map of the restaurants -->
                <div style="text-align: center;">
                    <h3>Map of the restaurants</h3>
                    <img src="/public/assets/images/map-restaurants.jpg" alt="Map of the Restaurants" style="max-width: 100%; margin-bottom: 1rem;">
                </div>

                <!-- Fun fact & Contact -->
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

    <!-- =========================
         DISCOVER DANCE SECTION
    ========================== -->
    <section class="discover-dance" style="background-color: #fff; color: #8B0000; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem;">
                Discover dance
                <br><span style="font-size: 1.2rem; font-weight: normal;">on a Unique Walking Tour</span>
            </h2>

            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                <!-- Similar structure as "Discover History" text + button + images of DJs/dancers -->
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

                <!-- Images of DJs/dancers -->
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
         MAP OF THE DANCE SECTION
    ========================== -->
    <section class="map-of-dance" style="background-color: #8B0000; color: #fff; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; align-items: start;">
                
                <!-- Visiting places (dance venues) -->
                <div>
                    <h3>Visiting places</h3>
                    <ol style="padding-left: 1.5rem;">
                        <li>Slachthuis</li>
                        <li>Caprera Openluchttheater</li>
                        <li>Jopenkerk</li>
                        <li>Lichtfabriek</li>
                        <li>Puncher comedy club</li>
                        <li>XO the Club</li>
                    </ol>
                </div>

                <!-- Map of the Dance -->
                <div style="text-align: center;">
                    <h3>Map of the Dance</h3>
                    <img src="/public/assets/images/map-dance.jpg" alt="Map of the Dance" style="max-width: 100%; margin-bottom: 1rem;">
                    <a href="#" style="background-color: #fff; color: #8B0000; padding: 0.5rem 1rem; text-decoration: none;">
                        Book the Ticket
                    </a>
                </div>

                <!-- Schedule -->
                <div>
                    <h3>Schedule</h3>
                    <ul style="list-style: none; padding-left: 0;">
                        <li><strong>25 July (Friday)</strong><br>20:00 – Lichtfabriek, 22:00 – Slachthuis</li>
                        <li><strong>26 July (Saturday)</strong><br>20:00 – Jopenkerk, 22:00 – Puncher comedy club</li>
                        <li><strong>27 July (Sunday)</strong><br>20:00 – Caprera Openluchttheater, 22:00 – XO the Club</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <!-- =========================
         DISCOVER THE SECRET
    ========================== -->
    <section class="discover-secret" style="background-color: #fff; color: #000; padding: 60px 0;">
        <div class="container" style="max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: 40px; flex-wrap: wrap;">
            <div style="flex: 1 1 400px; text-align: center;">
                <img src="/public/assets/images/professor-teyler-app.png" alt="Professor Teyler App" style="max-width: 200px;">
            </div>
            <div style="flex: 1 1 400px;">
                <h2 style="color: #8B0000; margin-bottom: 1rem;">
                    Discover the secret <br>
                    of professor Teyler
                </h2>
                <p>
                    An exciting app that brings a world of creativity and entertainment to kids. 
                    Dive into interactive games, explore creative workshops, and embark on thrilling challenges. 
                    The Festival app is designed to ignite the imagination and keep kids engaged for hours.
                </p>
                <p>
                    <strong>The Lorentz Formula</strong><br>
                    A Theatrical Tour of the Lorentz Lab
                </p>
                <a href="#" style="background-color: #8B0000; color: #fff; padding: 0.5rem 1rem; text-decoration: none;">
                    Check the date
                </a>
            </div>
        </div>
    </section>

</main>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
