<?php
// app_public/controllers/UserController.php

require_once __DIR__ . '/../models/UserModel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class UserController
{
    // Display login form (GET)
    public function login()
{
    
    require_once __DIR__ . '/../views/user/login.php';
    
}

    // Process login form submission (POST)
    public function loginPost()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $captchaResponse = $_POST['g-recaptcha-response'] ?? '';

        // 1. Verify CAPTCHA
        if (!$this->verifyCaptcha($captchaResponse)) {
            $error = "CAPTCHA verification failed. Please try again.";
            require_once __DIR__ . '/../views/user/login.php';
            return;
        }

        // 2. Check user in DB
        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Login success: set session and redirect
            $_SESSION['user_id'] = $user['id'];
            header('Location: /');
            exit;
        } else {
            $error = "Invalid credentials.";
            require_once __DIR__ . '/../views/user/login.php';
        }
    }

    // Handle user registration (GET for form, POST for submission)
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
    // Show the register form
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
    $role        = trim($_POST['role'] ?? 'User');

    if (empty($userName) || empty($mobilePhone) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
        require_once __DIR__ . '/../views/user/register.php';
        return;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert into DB
    try {
        $userModel = new UserModel();
        $userModel->createUser($userName, $mobilePhone, $email, $hashedPassword, $role);
        $success = 'Registration successful!';
    } catch (Exception $e) {
        $error = 'Error: ' . $e->getMessage();
    }

    require_once __DIR__ . '/../views/user/register.php';
}


    // ------------------------------
    // FORGOT PASSWORD METHODS
    // ------------------------------

    // Display the forgot password form (GET)
    public function forgotPasswordGet()
    {
        
        $errorMessage = '';
        $successMessage = '';
        require_once __DIR__ . '/../views/user/forgot_password.php';
        
    }

    // Process the forgot password form (POST)
    public function forgotPasswordPost()
    {
        echo "DEBUG: In UserController->forgotPasswordPost()<br>";
    
        $email = trim($_POST['email'] ?? '');
        $error = '';
        $success = '';
    
        if (empty($email)) {
            $error = 'Please enter your email.';
            require_once __DIR__ . '/../views/user/forgot_password.php';
            echo "DEBUG: Exiting forgotPasswordPost() with error: email empty<br>";
            return;
        }
    
        try {
            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);
            if (!$user) {
                $error = 'No account found with that email.';
                require_once __DIR__ . '/../views/user/forgot_password.php';
                echo "DEBUG: Exiting forgotPasswordPost() with error: no user found<br>";
                return;
            }
    
            // Generate a reset token and expiration (1 hour from now)
            $token = bin2hex(random_bytes(16));
            $expires = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');
    
            // Call setResetToken() by userNumber (primary key)
            // Make sure 'userNumber' matches the column name returned by findByEmail
            $userModel->setResetToken($user['userNumber'], $token, $expires);
    
            // Prepare the email details
            $to = $email;
            $subject = 'Password Reset Request';
            $resetLink = "http://localhost/user/reset?token=" . urlencode($token);

            $message = "Hello,\n\nWe received a request to reset your password.\n" .
                       "Please click the link below to reset your password:\n\n" .
                       $resetLink . "\n\nIf you did not request this, please ignore this email.";
            $headers = "From: no-reply@yourdomain.com\r\n" .
                       "Reply-To: no-reply@yourdomain.com\r\n" .
                       "X-Mailer: PHP/" . phpversion();
    
            // Send the email using PHP's mail() function
            if (mail($to, $subject, $message, $headers)) {
                $success = 'Password reset instructions have been emailed to you.';
            } else {
                $error = 'Failed to send email. Please try again later.';
            }
    
            require_once __DIR__ . '/../views/user/forgot_password.php';
            echo "DEBUG: Exiting forgotPasswordPost() successfully<br>";
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            require_once __DIR__ . '/../views/user/forgot_password.php';
            echo "DEBUG: Exiting forgotPasswordPost() with exception<br>";
        }
    }
    



    // Forgot password wrapper method – chooses GET or POST based on the request method
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->forgotPasswordPost();
        } else {
            $this->forgotPasswordGet();
        }
    }
    // Handle password reset (GET to show form, POST to update password)
    public function resetPassword()
{
    echo "DEBUG: Entering resetPassword()<br>";

    $token = $_GET['token'] ?? '';
    echo "DEBUG: token = " . htmlspecialchars($token) . "<br>";

    if (empty($token)) {
        echo "DEBUG: No token provided.<br>";
        return;
    }

    $userModel = new UserModel();
    $user = $userModel->findByToken($token);
    if (!$user) {
        echo "DEBUG: Token invalid or expired.<br>";
        return;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "DEBUG: Received POST for password update.<br>";
        $newPassword = trim($_POST['password'] ?? '');
        if (empty($newPassword)) {
            echo "DEBUG: No new password provided.<br>";
            return;
        }
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $userModel->updatePassword($user['userNumber'], $hashed);
        $userModel->clearResetToken($user['userNumber']);
        echo "DEBUG: Password updated successfully.<br>";
        return;
    } else {
        echo "DEBUG: Displaying reset password form.<br>";
        require_once __DIR__ . '/../views/user/reset_password.php';
    }

    echo "DEBUG: Exiting resetPassword()<br>";
}


    // Verify reCAPTCHA response using Google API
    private function verifyCaptcha($captchaResponse)
    {
        if (empty($captchaResponse)) {
            return false;
        }

        $secret = $_ENV["RECAPTCHA_SECRET_KEY"] ?? '';
        $response = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captchaResponse}"
        );
        $json = json_decode($response, true);
        return isset($json['success']) && $json['success'] === true;
    }


}
