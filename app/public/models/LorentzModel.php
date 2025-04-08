<?php
require_once __DIR__ . '/BaseModel.php';

class LorentzModel extends BaseModel {
    public function getLorentzData() {
        $sql = "SELECT lorentzID, picturePath, gameDescription FROM Lorentz LIMIT 1";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // fetch single row
    }
}
