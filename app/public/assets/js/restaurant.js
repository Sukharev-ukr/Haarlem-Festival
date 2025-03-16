document.addEventListener("DOMContentLoaded", function () {
    let map = L.map("map").setView([52.387269, 4.637224], 14); // Center on Patronaat Haarlem

    // Add OpenStreetMap tiles
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Get restaurant data from hidden JSON
    let dataElement = document.getElementById("restaurant-data");
    let restaurants = JSON.parse(dataElement.textContent);

    // Add markers for each restaurant
    restaurants.forEach(restaurant => {
        if (!restaurant.latitude || !restaurant.longitude) return;

        let marker = L.marker([restaurant.latitude, restaurant.longitude]).addTo(map)
            .bindPopup(`<strong>${restaurant.restaurantName}</strong><br>
                        Address: ${restaurant.address}<br>
                        Distance from Patronaat: ${restaurant.distance_from_patronaat}m`);
    });
});
