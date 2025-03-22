<?php
// app/models/UserModel.php

require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel
{
    // Existing methods like findByEmail(), createUser(), etc.

    public function createUser($userName, $mobilePhone, $email, $hashedPassword, $role = 'User')
    {
        $stmt = $this->db->prepare("
            INSERT INTO User (userName, mobilePhone, Email, password, role)
            VALUES (:userName, :mobilePhone, :email, :password, :role)
        ");
        $stmt->execute([
            'userName'    => $userName,
            'mobilePhone' => $mobilePhone,
            'email'       => $email,
            'password'    => $hashedPassword,
            'role'        => $role
        ]);
        // Return the new user's primary key (assuming auto-increment userNumber)
        return $this->db->lastInsertId();
    }

    public function storeVerifyToken($userId, $verify_token)
    {
        $stmt = $this->db->prepare("
            UPDATE User
            SET verify_token = :token, is_verified = 0
            WHERE userNumber = :id
        ");
        $stmt->execute([
            'token' => $verify_token,
            'id'    => $userId
        ]);
    }

    public function findByVerifyToken($token)
    {
        $stmt = $this->db->prepare("SELECT * FROM User WHERE verify_token = :token LIMIT 1");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function markUserVerified($userId)
    {
        $stmt = $this->db->prepare("
            UPDATE User
            SET is_verified = 1, verify_token = NULL
            WHERE userNumber = :id
        ");
        $stmt->execute(['id' => $userId]);
    }
    

    public function setResetToken($userId, $token, $expires)
{
    $stmt = $this->db->prepare("
        UPDATE User
        SET reset_token = :token,
            reset_expires = :expires
        WHERE userID = :id
    ");
    $stmt->execute([
        'token'   => $token,
        'expires' => $expires,
        'id'      => $userId
    ]);
}


public function findByToken($token)
{
    $stmt = $this->db->prepare("
        SELECT * FROM User
        WHERE reset_token = :token
          AND reset_expires > NOW()
        LIMIT 1
    ");
    $stmt->execute(['token' => $token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updatePassword($userId, $hashedPassword)
{
    $stmt = $this->db->prepare("
        UPDATE User
        SET password = :password
        WHERE userID = :id
    ");
    $stmt->execute([
        'password' => $hashedPassword,
        'id'       => $userId
    ]);
}


public function clearResetToken($userId)
{
    $stmt = $this->db->prepare("
        UPDATE User
        SET reset_token = NULL, reset_expires = NULL
        WHERE userID = :id
    ");
    $stmt->execute(['id' => $userId]);
}
    protected $db;

    public function __construct() {
        parent:: __construct();
       }

       public function findByEmail($email)
       {
           $stmt = $this->db->prepare("SELECT * FROM User WHERE Email = ?");
           $stmt->execute([$email]);
           return $stmt->fetch();
       }
}
