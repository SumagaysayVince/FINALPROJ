<?php
session_start();
include 'db.php'; // Use your existing db.php

$success = '';
$error = '';

if (isset($_POST['register'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);

    // Check if username exists
    $check = mysqli_query($conn, "SELECT * FROM students WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username already taken.";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO students (full_name, username, password, course) VALUES ('$full_name','$username','$password','$course')");
        if ($insert) {
            $success = "Successfully registered! You can now <a href='student_login.php'>login</a>.";
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}

// Fetch courses for dropdown
$courses = mysqli_query($conn, "SELECT * FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Register</title>
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

    .register-box {
        position: relative;
        z-index: 1;
        background: rgba(255,255,255,0.95);
        padding: 40px 35px;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        width: 380px;
        text-align: center;
    }

    .register-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px auto;
        border-radius: 50%;
        background: #84fab0;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 36px;
        color: #083a5e;
    }

    h2 {
        margin-bottom: 25px;
        font-weight: 700;
        color: #083a5e;
    }

    input, select {
        width: 100%;
        padding: 14px 12px;
        margin: 12px 0;
        border-radius: 10px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    input:focus, select:focus {
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
        box-shadow: 0 6px 20px rgba(132, 250, 176, 0.4);
    }

    .error {
        color: #d93025;
        margin-bottom: 12px;
        background: rgba(255,0,0,0.05);
        padding: 8px;
        border-radius: 8px;
        font-size: 14px;
    }

    .success {
        color: #0f9d58;
        margin-bottom: 12px;
        background: rgba(15,157,88,0.05);
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
        .register-box { width: 90%; padding: 30px 25px; }
        input, select, button { font-size: 14px; padding: 12px; }
    }
</style>
</head>
<body>

<div class="register-box">
    <div class="register-icon">📝</div>
    <h2>Student Registration</h2>
    <?php if($error) echo "<div class='error'>$error</div>"; ?>
    <?php if($success) echo "<div class='success'>$success</div>"; ?>
    
    <form method="POST">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="course" required>
            <option value="">Select Course</option>
            <?php while($c = mysqli_fetch_assoc($courses)) { ?>
                <option value="<?php echo $c['course_name']; ?>"><?php echo $c['course_name']; ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="register">Register</button>
    </form>
    <p><a href="student_login.php">Already have an account? Login</a> | <a href="index.html">Back to Home</a></p>
</div>

</body>
</html>
