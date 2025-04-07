<?php

require_once __DIR__ . '/../models/DanceModel.php';

class DanceController {
    private $danceModel;

    public function __construct() {
        $this->danceModel = new DanceModel();
    }

    public function getDancesByDate($date) {
        try {
            $details = $this->danceModel->getDanceByDate($date);
            if ($details) {
                return $details;
            } else {
                echo "No dance events found for: $date";
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
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

    public function  getArtistDetailsByDanceID($danceID) {
        try {
            $detail = $this->danceModel->getArtistDetailsByDanceID($danceID);

            if ($detail) {
                return $detail;
            } else {
                echo "No details found for artists at Lichfabriek on Friday";
            }
        }
        catch (PDOException $ex) {
           error_log("Database Error: " . $ex->getMessage());
           echo "An error occurred while fetching dance details. Please try again later.";
        }
    }

    //For the Ticket
    public function getEventDetails($danceID) {
        return $this->danceModel->getEventDetailsByDanceID($danceID);
    }
    
    public function getTicketDetails($danceID) {
        return $this->danceModel->getTicketDetailsByDanceID($danceID);
    }
    public function getAllDanceArtists() {
        // This method calls your model method getArtistNamePicture()
        return $this->danceModel->getArtistNamePicture();
    }
    
    


}