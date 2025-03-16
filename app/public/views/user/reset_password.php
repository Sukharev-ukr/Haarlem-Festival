<?php
// Typically, you'll pass $error or $success from your controller if needed.
$error = $error ?? '';
$success = $success ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f8f8f8;
            font-family: Arial, sans-serif;
        }

        .reset-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 20px 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        .reset-container h1 {
            text-align: center;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            background: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .error {
            background: #ffe5e5;
            color: #d00;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #d00;
            border-radius: 4px;
        }

        .success {
            background: #e5ffe5;
            color: #090;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #090;
            border-radius: 4px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            text-decoration: none;
            color: #007BFF;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="reset-container">
    <h1>Reset Password</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" name="password" id="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
        </div>
        <button type="submit">Reset Password</button>
    </form>

    <a class="back-link" href="/user/login">Back to Login</a>
</div>

</body>
</html>
