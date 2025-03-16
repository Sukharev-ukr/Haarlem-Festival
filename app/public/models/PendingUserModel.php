<?php
// app/models/PendingUserModel.php

require_once __DIR__ . '/BaseModel.php';

class PendingUserModel extends BaseModel
{
    public function createPendingUser($userName, $mobilePhone, $email, $hashedPassword, $role, $verifyToken)
    {
        $stmt = $this->db->prepare("
            INSERT INTO pending_users (userName, mobilePhone, email, password, role, verify_token)
            VALUES (:userName, :mobilePhone, :email, :password, :role, :verify_token)
        ");
        $stmt->execute([
            'userName'     => $userName,
            'mobilePhone'  => $mobilePhone,
            'email'        => $email,
            'password'     => $hashedPassword,
            'role'         => $role,
            'verify_token' => $verifyToken
        ]);
        return $this->db->lastInsertId();
    }
    
    public function findByVerifyToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM pending_users WHERE verify_token = :token LIMIT 1");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function deletePendingUser($pendingId)
    {
        $stmt = $this->db->prepare("DELETE FROM pending_users WHERE pending_id = :id");
        $stmt->execute(['id' => $pendingId]);
    }
}
