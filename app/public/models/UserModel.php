<?php
// app_public/models/UserModel.php

require_once __DIR__ . '/BaseModel.php';

class UserModel extends BaseModel
{
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function create($email, $hashedPassword)
    {
        $stmt = $this->db->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
        $stmt->execute([
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }

    public function setResetToken($userId, $token, $expires)
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET reset_token = :token, reset_expires = :expires
            WHERE id = :id
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
            SELECT * FROM users
            WHERE reset_token = :token
              AND reset_expires > NOW()
            LIMIT 1
        ");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch();
    }

    public function updatePassword($userId, $hashedPassword)
    {
        $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([
            'password' => $hashedPassword,
            'id' => $userId
        ]);
    }

    public function clearResetToken($userId)
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET reset_token = NULL, reset_expires = NULL
            WHERE id = :id
        ");
        $stmt->execute(['id' => $userId]);
    }
}
