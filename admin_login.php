<?php
session_start();

// Hardcoded credentials
$correct_username = "admin";
$correct_password = "admin123";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $correct_username && $password === $correct_password) {
        $_SESSION['admin'] = "admin";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid credentials!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            max-width: 350px;
            width: 100%;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body>

<div class="login-container">
    <h3>Admin Login</h3>
    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" required>
            <i class="fas fa-user"></i>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" required>
            <i class="fas fa-lock"></i>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
</div>

</body>
</html>
