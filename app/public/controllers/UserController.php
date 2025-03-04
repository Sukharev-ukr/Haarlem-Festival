<?php
// app_public/controllers/UserController.php

require_once __DIR__ . '/../models/UserModel.php';

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
    public function registerGet()
    {
        
        // Set empty messages for first load
        $errorMessage = '';
        $successMessage = '';
        require_once __DIR__ . '/../views/user/register.php';
        
    }

    // Process the registration form (POST)
    public function registerPost()
    {
        echo "DEBUG: In UserController->registerPost()<br>";
        
        // Retrieve and trim form fields
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirmPassword = trim($_POST['confirm_password'] ?? '');

        $errorMessage = '';
        $successMessage = '';

        // Basic validation
        if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
            $errorMessage = 'All fields are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'Invalid email format.';
        } elseif ($password !== $confirmPassword) {
            $errorMessage = 'Passwords do not match.';
        }

        // If there is an error, show the form again with the error message
        if ($errorMessage) {
            require_once __DIR__ . '/../views/user/register.php';
            echo "DEBUG: Exiting registerPost() with error<br>";
            return;
        }

        try {
            $userModel = new UserModel();
            // Assume createUser returns the new user's ID or throws an exception on error
            $userId = $userModel->createUser($username, $password, $email);
            // Registration successful—redirect to login page
            header('Location: /login');
            exit;
        } catch (Exception $e) {
            $errorMessage = 'Error: ' . $e->getMessage();
            require_once __DIR__ . '/../views/user/register.php';
            echo "DEBUG: Exiting registerPost() with exception<br>";
        }
    }

    // Registration wrapper method – chooses GET or POST based on the request method
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->registerPost();
        } else {
            $this->registerGet();
        }
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
        $errorMessage = '';
        $successMessage = '';

        if (empty($email)) {
            $errorMessage = 'Please enter your email.';
            require_once __DIR__ . '/../views/user/forgot_password.php';
            echo "DEBUG: Exiting forgotPasswordPost() with error: email empty<br>";
            return;
        }

        try {
            $userModel = new UserModel();
            $user = $userModel->findByEmail($email);
            if (!$user) {
                $errorMessage = 'No account found with that email.';
                require_once __DIR__ . '/../views/user/forgot_password.php';
                echo "DEBUG: Exiting forgotPasswordPost() with error: no user found<br>";
                return;
            }

            // Generate a reset token and expiration (e.g., 1 hour from now)
            $token = bin2hex(random_bytes(16));
            $expires = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');
            // Assume createPasswordReset stores the token and expiration for the user
            $userModel->createPasswordReset($email, $token, $expires);

            // In production, you would email the link. For testing, we display it.
            $resetLink = "http://localhost/reset_password?token=" . urlencode($token);
            $successMessage = "Password reset link: " . $resetLink;

            require_once __DIR__ . '/../views/user/forgot_password.php';
            echo "DEBUG: Exiting forgotPasswordPost() successfully<br>";
        } catch (Exception $e) {
            $errorMessage = 'Error: ' . $e->getMessage();
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
        $token = $_GET['token'] ?? '';

        $userModel = new UserModel();
        $user = $userModel->findByToken($token);

        if (!$user) {
            echo "<p>Invalid or expired token.</p>";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['password'] ?? '';
            $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
            $userModel->updatePassword($user['id'], $hashed);
            $userModel->clearResetToken($user['id']);

            echo "<p>Password updated. You can <a href='/user/login'>login now</a>.</p>";
            return;
        }

        // Show reset password form (GET)
        require_once __DIR__ . '/../views/user/reset_password.php';
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
