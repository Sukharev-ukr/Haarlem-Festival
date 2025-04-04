<?php
   require_once(__DIR__ . "/BaseModel.php");

   class DanceModel extends BaseModel {
       
       public function __construct() {
        parent:: __construct();
       }
       


       //Get all Dance At Friday
       public function getDanceAtFriday() {
        $sql = "SELECT 
        D.danceID,
        D.location,
        D.danceDate,
        DAYNAME(D.danceDate) AS day,
        D.startTime,
        A.name AS artistName,
        A.picture AS artistImage
            FROM Dance D
            INNER JOIN DanceArtist DA ON D.danceID = DA.danceID
            INNER JOIN Artist A ON DA.artistID = A.artistID
            WHERE DAYNAME(D.danceDate) = 'Friday'";
        $stmt = self::$pdo->prepare($sql); // use self::$pdo because BaseModel set it up
        $stmt->execute();
        return $stmt->fetchAll();
    }
        
      //Get all Dance At Saturday
      public function getDanceAtSaturday() {
        $sql = "SELECT 
        D.danceID,
        D.location,
        D.danceDate,
        DAYNAME(D.danceDate) AS day,
        D.startTime,
        A.name AS artistName,
        A.picture AS artistImage
            FROM Dance D
            INNER JOIN DanceArtist DA ON D.danceID = DA.danceID
            INNER JOIN Artist A ON DA.artistID = A.artistID
            WHERE DAYNAME(D.danceDate) = 'Saturday'";

        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();

      }

      //Get all Day AT Sunday
      public function getDanceAtSunday() {
        $sql = "SELECT 
        D.danceID,
        D.location,
        D.danceDate,
        DAYNAME(D.danceDate) AS day,
        D.startTime,
        A.name AS artistName,
        A.picture AS artistImage
            FROM Dance D
            INNER JOIN DanceArtist DA ON D.danceID = DA.danceID
            INNER JOIN Artist A ON DA.artistID = A.artistID
            WHERE DAYNAME(D.danceDate) = 'Sunday'";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
      }

      //Get Dance and Artist by DanceID (Using For dancePage)
     public function getDanceAndArtistByDanceID($danceID) {
         $sql = "SELECT 
                D.danceID,
                D.location,
                D.danceDate,
                DAYNAME(D.danceDate) AS day,
                D.startTime,
                A.name AS artistName,
                A.style,
                A.description,
                A.origin,
                GROUP_CONCAT(AL.title SEPARATOR ', ') AS albumTitles
            FROM Dance D
            INNER JOIN DanceArtist DA ON D.danceID = DA.danceID
            INNER JOIN Artist A ON DA.artistID = A.artistID
            LEFT JOIN Albums AL ON A.artistID = AL.artistID
            WHERE D.danceID = ?
            GROUP BY D.danceID, A.artistID";

            $stmt = self::$pdo->prepare($sql);
            $stmt -> execute([$danceID]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
     } 

     //Using for detailArtistPage
     public function getArtistDetailsByDanceID($danceID) {
        $sql = "
        SELECT 
            D.danceID,
            A.name AS artistName,
            A.style AS artistStyle,
            A.description AS artistDescription,
            A.origin AS artistOrigin,
            A.picture AS artistPicture,
            GROUP_CONCAT(AL.title SEPARATOR ', ') AS artistAlbums,
            D.location,
            D.startTime,
            D.endTime,
            D.danceCapacity AS totalSeats,  -- Fix: Changed totalSeats to danceCapacity
            TIMEDIFF(D.endTime, D.startTime) AS duration,
            D.danceDate,
            D.day,
            TT.price AS ticketPrice
        FROM Dance D
        INNER JOIN DanceArtist DA ON D.danceID = DA.danceID
        INNER JOIN Artist A ON DA.artistID = A.artistID
        LEFT JOIN Albums AL ON A.artistID = AL.artistID
        LEFT JOIN TicketType TT ON D.danceID = TT.danceID AND TT.type = 'Regular'
        WHERE D.danceID = ?
        GROUP BY A.artistID, D.danceID;
        ";
    
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$danceID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Using for ticketSelection
    public function getEventDetailsByDanceID($danceID) {
        $sql = "
        SELECT 
            D.danceID,
            D.location,
            D.danceDate,
            D.startTime,
            D.endTime,
            GROUP_CONCAT(A.name SEPARATOR ' / ') AS artists,
            D.day
        FROM Dance D
        INNER JOIN DanceArtist DA ON D.danceID = DA.danceID
        INNER JOIN Artist A ON DA.artistID = A.artistID
        WHERE D.danceID = ?
        GROUP BY D.danceID
        ";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$danceID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    //Using for ticketSelection
    public function getTicketDetailsByDanceID($danceID) {
        $sql = "
        SELECT 
        TT.ticketTypeId,
        TT.type AS ticketType,
        TT.price AS ticketPrice
        FROM TicketType TT
        WHERE TT.danceID = ?
           ";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$danceID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArtistNamePicture() {
        $sql = "SELECT name AS artistName, picture AS artistImage FROM Artist";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Debug: output the results
        
        // die();  // Remove or comment this out after debugging
    
        return $results;
    }
    
    

}
