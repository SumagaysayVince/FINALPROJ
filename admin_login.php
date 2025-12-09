<?php
session_start();
include 'db.php'; // Use your existing db.php

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    if (mysqli_num_rows($query) > 0) {
        $admin = mysqli_fetch_assoc($query);
        $_SESSION['admin_id'] = $admin['admin_id'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    * { margin:0; padding:0; box-sizing:border-box; }

    body {
        font-family: 'Inter', Arial, sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url('admin.jpg') no-repeat center center/cover;
        position: relative;
    }

    /* Overlay */
    body::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.55);
        z-index: 0;
    }

    .login-box {
        position: relative;
        z-index: 1;
        background: rgba(255,255,255,0.95);
        padding: 40px 35px;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        width: 380px;
        text-align: center;
    }

    .admin-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px auto;
        border-radius: 50%;
        background: #6fa8ff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 36px;
        color: white;
    }

    h2 {
        margin-bottom: 25px;
        font-weight: 700;
        color: #083a5e;
    }

    input {
        width: 100%;
        padding: 14px 12px;
        margin: 12px 0;
        border-radius: 10px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    input:focus {
        border-color: #6fa8ff;
        box-shadow: 0 0 8px rgba(111, 168, 255, 0.5);
    }

    button {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #6fa8ff, #84fab0);
        color: #083a5e;
        font-weight: 700;
        cursor: pointer;
        font-size: 16px;
        margin-top: 12px;
        transition: all 0.3s ease;
    }

    button:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 6px 20px rgba(143,211,244,0.4);
    }

    .error {
        color: #d93025;
        margin-bottom: 12px;
        background: rgba(255,0,0,0.05);
        padding: 8px;
        border-radius: 8px;
        font-size: 14px;
    }

    a {
        text-decoration: none;
        color: #6fa8ff;
        font-weight: 500;
        display: inline-block;
        margin-top: 14px;
        transition: 0.3s;
    }

    a:hover { color: #083a5e; }

    @media (max-width: 420px) {
        .login-box { width: 90%; padding: 30px 25px; }
        input, button { font-size: 14px; padding: 12px; }
    }
</style>
</head>
<body>

<div class="login-box">
    <div class="admin-icon">👤</div>
    <h2>Admin Login</h2>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p><a href="index.html">Back to Home</a></p>
</div>

</body>
</html>
