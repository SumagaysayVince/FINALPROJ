<?php
session_start();
include 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if student ID is provided
if (!isset($_GET['id'])) {
    echo "Student not specified.";
    exit();
}

$student_id = $_GET['id'];

// Fetch student data
$student_q = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$student_id'");
$student = mysqli_fetch_assoc($student_q);

if (!$student) {
    echo "Student not found.";
    exit();
}

// Fetch courses for dropdown
$courses = mysqli_query($conn, "SELECT * FROM courses");

// Handle update
if (isset($_POST['update'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username  = mysqli_real_escape_string($conn, $_POST['username']);
    $course    = mysqli_real_escape_string($conn, $_POST['course']);
    $password  = $_POST['password'];

    if (!empty($password)) {
        $password = mysqli_real_escape_string($conn, $password);
        $sql = "UPDATE students SET full_name='$full_name', username='$username', password='$password', course='$course' WHERE student_id='$student_id'";
    } else {
        $sql = "UPDATE students SET full_name='$full_name', username='$username', course='$course' WHERE student_id='$student_id'";
    }

    if (mysqli_query($conn, $sql)) {
        $success = "Student information updated successfully.";
        $student_q = mysqli_query($conn, "SELECT * FROM students WHERE student_id='$student_id'");
        $student = mysqli_fetch_assoc($student_q);
    } else {
        $error = "Error updating student: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Student Info</title>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Inter', sans-serif;
        height: 100vh;
        background: url('admin.jpg') no-repeat center center/cover;
        display: flex;
        justify-content: center;
        align-items: center;
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

    .form-container {
        position: relative;
        z-index: 1;
        width: 420px;
        padding: 40px 35px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 18px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.25);
        text-align: center;
        backdrop-filter: blur(6px);
    }

    .edit-icon {
        width: 75px;
        height: 75px;
        background: #6fa8ff;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 38px;
        margin: 0 auto 20px auto;
        box-shadow: 0 4px 14px rgba(111,168,255,0.5);
    }

    h2 {
        margin-bottom: 20px;
        font-weight: 700;
        color: #083a5e;
    }

    input, select {
        width: 100%;
        padding: 14px;
        margin: 12px 0;
        border-radius: 10px;
        border: 1px solid #ccc;
        outline: none;
        font-size: 15px;
        transition: 0.3s ease;
    }

    input:focus, select:focus {
        border-color: #6fa8ff;
        box-shadow: 0 0 10px rgba(111,168,255,0.6);
    }

    button {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #6fa8ff, #4d8dff);
        color: white;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s ease;
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(111,168,255,0.45);
    }

    .success, .error {
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .success { background: #e6f9ed; color: #0f9d58; }
    .error { background: #fdecea; color: #d93025; }

    .back {
        display: block;
        margin-top: 15px;
        text-decoration: none;
        color: #6fa8ff;
        font-weight: 600;
    }

    .back:hover {
        color: #083a5e;
    }

    @media(max-width: 480px) {
        .form-container { width: 90%; padding: 30px 20px; }
    }
</style>

</head>
<body>

<div class="form-container">

    <div class="edit-icon">🖉</div>

    <h2>Edit Student Info</h2>

    <?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
        <input type="text" name="full_name" value="<?php echo $student['full_name']; ?>" required>
        <input type="text" name="username" value="<?php echo $student['username']; ?>" required>
        <input type="password" name="password" placeholder="New Password (leave blank)">
        
        <select name="course" required>
            <option value="">Select Course</option>
            <?php while($c = mysqli_fetch_assoc($courses)) { ?>
                <option value="<?php echo $c['course_name']; ?>" <?php if ($c['course_name'] == $student['course']) echo "selected"; ?>>
                    <?php echo $c['course_name']; ?>
                </option>
            <?php } ?>
        </select>

        <button type="submit" name="update">Update Student</button>
    </form>

    <a class="back" href="admin_dashboard.php">← Back to Dashboard</a>

</div>

</body>
</html>
