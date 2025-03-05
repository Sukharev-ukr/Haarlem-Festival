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

      //Get Dance and Artist by DanceID
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

}
