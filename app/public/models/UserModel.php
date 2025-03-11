<?php
// app/public/models/UserModel.php

require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel
{
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM User WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function createUser($userName, $mobilePhone, $email, $hashedPassword, $role = 'User')
{
    $stmt = $this->db->prepare("
        INSERT INTO User (userName, mobilePhone, Email, password, role)
        VALUES (:userName, :mobilePhone, :Email, :password, :role)
    ");
    $stmt->execute([
        'userName'    => $userName,
        'mobilePhone' => $mobilePhone,
        'Email'       => $email,
        'password'    => $hashedPassword,
        'role'        => $role
    ]);
}


public function setResetToken($userId, $token, $expires)
{
    $stmt = $this->db->prepare("
        UPDATE `User`
        SET reset_token = :token,
            reset_expires = :expires
        WHERE userNumber = :id
    ");
    $stmt->execute([
        'token' => $token,
        'expires' => $expires,
        'id' => $userId
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
        return $stmt->fetch();
    }

    public function updatePassword($userId, $hashedPassword)
    {
        $stmt = $this->db->prepare("UPDATE User SET password = :password WHERE id = :id");
        $stmt->execute([
            'password' => $hashedPassword,
            'id' => $userId
        ]);
    }

    public function clearResetToken($userId)
    {
        $stmt = $this->db->prepare("
            UPDATE User
            SET reset_token = NULL, reset_expires = NULL
            WHERE id = :id
        ");
        $stmt->execute(['id' => $userId]);
    }
}
