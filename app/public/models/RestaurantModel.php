<?php
require_once(__DIR__ . "/BaseModel.php");
class RestaurantModel extends BaseModel {
    // Grab all restaurants
    public function getRestaurants() {
        $sql = "SELECT restaurantID, restaurantName, address, phone, cuisine, description, stars, pricePerAdult, pricePerChild, latitude, longitude, distance_from_patronaat FROM Restaurant";
        return $this->query($sql)->fetchAll();
    }

    // Grab all slots for a restaurant
    public function getSlots($restaurantID) {
        $sql = "SELECT * FROM RestaurantSlot WHERE restaurantID = ?";
        return $this->query($sql, [$restaurantID])->fetchAll();
    }

    // Reserve a table
    public function reserveTable($userID, $restaurantID, $slotID, $adults, $children) {
        $sql = "INSERT INTO Reservation (userID, restaurantID, slotID, amountAdults, amountChildren, status, reservationDate, price)
                VALUES (?, ?, ?, ?, ?, 'Pending', NOW(), 69.69)";
        return $this->query($sql, [$userID, $restaurantID, $slotID, $adults, $children]);
    }
    // get restaurant ID
    public function getRestaurantByID($restaurantID) {
        $sql = "SELECT * FROM Restaurant WHERE restaurantID = ?";
        return $this->query($sql, [$restaurantID])->fetch();
    }    
}
?>
