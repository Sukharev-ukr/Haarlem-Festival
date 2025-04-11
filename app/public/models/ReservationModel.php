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
    
    public function calculateReservationCosts($restaurantID, $adults, $children) {
        $stmt = self::$pdo->prepare("SELECT pricePerAdult, pricePerChild FROM Restaurant WHERE restaurantID = ?");
        $stmt->execute([$restaurantID]);
        $pricing = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $reservationFeePerPerson = 10;
        $mealCost = ($adults * $pricing['pricePerAdult']) + ($children * $pricing['pricePerChild']);
        $reservationFee = ($adults + $children) * $reservationFeePerPerson;
        $totalCost = $mealCost + $reservationFee;
    
        return [
            'mealCost' => $mealCost,
            'reservationFee' => $reservationFee,
            'totalCost' => $totalCost
        ];
    }    
}
?>
