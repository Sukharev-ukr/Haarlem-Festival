<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Forgot Password</h1>
    <form method="post" action="/user/forgot">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    <button type="submit">Send Reset Link</button>
</form>
</body>
</html>
