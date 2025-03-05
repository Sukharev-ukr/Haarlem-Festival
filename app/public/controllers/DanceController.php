<?php

require_once(__DIR__ .("/../models/DanceModel.php"));

class DanceController {
    private $danceModel;

    public function __construct() {
        $this->danceModel = new DanceModel();
    }

    public function getDanceAtFriday() {
        try {
            $details = $this->danceModel->getDanceAtFriday();
              if ($details) {
                  return $details;
             } else {
                    echo "No details found for dance at Friday";
             }
            } catch (PDOException $e) {
                // Log the error if needed and show a user-friendly message
                error_log("Database Error: " . $e->getMessage());
                echo "An error occurred while fetching dance details. Please try again later.";
            }
        
    }


    public function getDanceAtSaturday() {
        try {
         $details = $this->danceModel->getDanceAtSaturday();
         if ($details) {
            return $details;    
         }else {
            echo "No details found for dance at Friday";
         }
        }
        catch (PDOException $ex) {
             // Log the error if needed and show a user-friendly message
             error_log("Database Error: " . $ex->getMessage());
             echo "An error occurred while fetching dance details. Please try again later.";
        }
    }

    public function getDanceAtSunday() {
        try {
           $detail = $this-> danceModel -> getDanceAtSunday();
           if ($detail) {
            return $detail;
           } else {
            echo "No details found for dance at Sunday";
           }
        }
        catch (PDOException $ex) {
            // Log the error if needed and show a user-friendly message
            error_log("Database Error: " . $ex->getMessage());
            echo "An error occurred while fetching dance details. Please try again later.";
        }
    }

    public function getDanceAndArtistByArtistID($danceID) {
        try {
            $detail = $this->danceModel-> getDanceAndArtistByDanceID($danceID);
            if ($detail) {
                return $detail;
            }
            else {
                echo "No details found for dance and artist by artist ID: $danceID";
            }
        }
        catch (PDOException $ex) {
            error_log("Database Error: " . $ex->getMessage());
            echo "An error occurred while fetching dance details. Please try again later.";
        }
    }

}