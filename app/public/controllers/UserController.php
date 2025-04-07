<?php
// app/controllers/UserController.php

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../lib/mailer.php'; 

class UserController
{
    // Registration: GET/POST
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registerPost();
        } else {
            $this->registerGet();
        }
    }

    public function registerGet()
    {
        $error = '';
        $success = '';
        require_once __DIR__ . '/../views/user/register.php';
    }

    public function registerPost()
{
    $userName    = trim($_POST['userName'] ?? '');
    $mobilePhone = trim($_POST['mobilePhone'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $password    = trim($_POST['password'] ?? '');
    $error = '';
    $success = '';

    if (empty($userName) || empty($mobilePhone) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
        require_once __DIR__ . '/../views/user/register.php';
        return;
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    try {
        // Insert into pending_users instead of the main User table
        require_once __DIR__ . '/../models/PendingUserModel.php';
        $pendingModel = new PendingUserModel();
        $verifyToken = bin2hex(random_bytes(16));
        $pendingId = $pendingModel->createPendingUser($userName, $mobilePhone, $email, $hashedPassword, 'User', $verifyToken);

        if (sendEmailRegister($userName, $email, $verifyToken)) {
            $success = 'Registration successful! Please check your email to verify your account.';
        } else {
            $error = $_SESSION['email_error'] ?? 'Failed to send verification email.';
        }
    } catch (Exception $e) {
        $error = 'Error: ' . $e->getMessage();
    }
    require_once __DIR__ . '/../views/user/register.php';
}


    // Email Verification
    public function verifyEmail()
{
    $token = $_GET['token'] ?? '';
    if (empty($token)) {
        echo "No token provided.";
        return;
    }
    
    // Use PendingUserModel to fetch pending registration
    require_once __DIR__ . '/../models/PendingUserModel.php';
    $pendingModel = new PendingUserModel();
    $pendingUser = $pendingModel->findByVerifyToken($token);
    
    if (!$pendingUser) {
        echo "Invalid token or user not found.";
        return;
    }
    
    // Create the user in the main User table using details from pending_users
    $userModel = new UserModel();
    $userId = $userModel->createUser(
        $pendingUser['userName'],
        $pendingUser['mobilePhone'],
        $pendingUser['email'],
        $pendingUser['password'], // already hashed
        $pendingUser['role']
    );
    
    // Optionally, perform any additional actions (e.g., log the user in, send a welcome email, etc.)
    
    // Delete the pending record
    $pendingModel->deletePendingUser($pendingUser['pending_id']);
    
    echo "Your email has been verified and your account has been created. Please <a href='/user/login'>login</a>.";
}


    // Forgot Password: GET/POST
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->forgotPasswordPost();
        } else {
            $this->forgotPasswordGet();
        }
    }

    public function forgotPasswordGet()
    {
        $error = '';
        $success = '';
        require_once __DIR__ . '/../views/user/forgot_password.php';
    }

    public function forgotPasswordPost()
    {
        $email = trim($_POST['email'] ?? '');
        $error = '';
        $success = '';

        if (empty($email)) {
            $error = 'Please enter your email.';
            require_once __DIR__ . '/../views/user/forgot_password.php';
            return;
        }

        try {
            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);
            if (!$user) {
                $error = 'No account found with that email.';
                require_once __DIR__ . '/../views/user/forgot_password.php';
                return;
            }
            // Generate reset token and expiration (1 hour from now)
            $resetToken = bin2hex(random_bytes(16));
            $expires = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');
            $userModel->setResetToken($user['userID'], $resetToken, $expires);

            if (sendEmailReset($email, $resetToken)) {
                $success = 'Password reset instructions have been emailed to you.';
            } else {
                $error = $_SESSION['email_error'] ?? 'Failed to send reset email.';
            }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
        }
        require_once __DIR__ . '/../views/user/forgot_password.php';
    }

    // Reset Password: GET/POST
    public function resetPassword()
{
    $token = $_GET['token'] ?? '';
    if (empty($token)) {
        echo "No token provided.";
        return;
    }
    
    $userModel = new UserModel();
    $user = $userModel->findByToken($token);
    if (!$user) {
        echo "Invalid or expired token.";
        return;
    }
    
    // Initialize messages for the view
    $error = '';
    $success = '';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newPassword = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');
        
        if (empty($newPassword) || empty($confirmPassword)) {
            $error = "Please fill in both password fields.";
            require_once __DIR__ . '/../views/user/reset_password.php';
            return;
        }
        
        if ($newPassword !== $confirmPassword) {
            $error = "Passwords do not match.";
            require_once __DIR__ . '/../views/user/reset_password.php';
            return;
        }
        
        // Hash the new password and update the database
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $userModel->updatePassword($user['userID'], $hashed);
        $userModel->clearResetToken($user['userID']);
        
        $success = "Password updated successfully. You can now <a href='/user/login'>login</a>.";
        require_once __DIR__ . '/../views/user/reset_password.php';
    } else {
        require_once __DIR__ . '/../views/user/reset_password.php';
    }
}

    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $this->loginPost();
    } else {
        $this->loginGet();
    }
}

private function loginGet()
{
    $error = '';
    // Load the login view (create this file as needed)
    require_once __DIR__ . '/../views/user/login.php';
}

public function loginPost()
{
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $error = '';

    if (empty($email) || empty($password)) {
        $error = "Please fill in both email and password.";
        require_once __DIR__ . '/../views/user/login.php';
        return;
    }

    $userModel = new UserModel();
    $user = $userModel->findByEmail($email);
    if ($user && password_verify($password, $user['password'])) {
        // Login successful: store user in session
        $_SESSION['user'] = $user;
        // Check the user role: if Admin, redirect to admin dashboard
        if (isset($user['role']) && $user['role'] === 'Admin') {
            header("Location: /adminDashBoard");
            exit;
        } else {
            header("Location: /");  // Redirect regular user to home page
            exit;
        }
    } else {
        $error = "Invalid credentials.";
        require_once __DIR__ . '/../views/user/login.php';
        return;
    }
}

public function editProfile() {
    // Start session if not already started
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Ensure user is logged in
    if (!isset($_SESSION['user'])) {
        header("Location: /user/login");
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userName = trim($_POST['userName'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Basic validation could go here
        if (empty($userName) || empty($email)) {
            $error = "Name and e-mail cannot be empty.";
        } else {
            // Update user data in DB, assume you have a method updateUser($userID, $userName, $email, $password)
            $userID = $_SESSION['user']['userID'];
            $userModel = new UserModel();
            
            // If password is provided, update it; otherwise update only name and email.
            if (!empty($password)) {
                $hashed = password_hash($password, PASSWORD_BCRYPT);
                $userModel->updateUser($userID, $userName, $email, $hashed);
            } else {
                $userModel->updateUser($userID, $userName, $email);
            }
            
            // Optionally update the session with new details
            $_SESSION['user']['userName'] = $userName;
            $_SESSION['user']['Email'] = $email;
            
            $success = "Profile updated successfully.";
        }
    }

    // Load the edit profile view
    require __DIR__ . '/../views/user/editProfile.php';
}
public function updateUser($userID, $userName, $email, $password = null) {
    if ($password !== null && $password !== '') {
        $sql = "UPDATE User 
                SET userName = :userName, Email = :email, password = :password 
                WHERE userID = :userID";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([
            'userName' => $userName,
            'email'    => $email,
            'password' => $password, // make sure this is already hashed
            'userID'   => $userID
        ]);
    } else {
        $sql = "UPDATE User 
                SET userName = :userName, Email = :email 
                WHERE userID = :userID";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([
            'userName' => $userName,
            'email'    => $email,
            'userID'   => $userID
        ]);
    }
}







}
