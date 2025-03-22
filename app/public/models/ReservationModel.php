<?php
require_once(__DIR__ . "/BaseModel.php");

class ReservationModel extends BaseModel {
    public function fetchSessionsByRestaurant($restaurantID) {
        $sql = "SELECT rs.slotID, rs.startTime, rs.endTime, rs.capacity 
                FROM RestaurantSlot rs
                WHERE rs.restaurantID = ? 
                ORDER BY rs.startTime";
    
        return $this->query($sql, [$restaurantID])->fetchAll();
    }    

    public function getRestaurantByID($restaurantID) {
        $sql = "restaurantID, restaurantName, address, phone, cuisine, description, stars, pricePerAdult, pricePerChild, latitude, 
        longitude, distance_from_patronaat FROM Restaurant WHERE restaurantID = ?";
        return $this->query($sql, [$restaurantID])->fetch();
    }
    
    private function getOrCreateOrder($userID) {
        // logic to query order table by userID and status 'open'
        // if not found, insert one
        // return orderID
    }
    
    private function createReservation($data, $orderID, $userID) {
        // INSERT INTO reservations ...
    }
    
}
?>
