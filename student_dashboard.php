<?php
session_start();
include 'db.php'; // database connection

// Redirect if not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// Get the logged-in student's course
$student_course = $_SESSION['student_course'];

// Fetch the course info based on the student's course
$course_query = mysqli_query($conn, "SELECT * FROM courses WHERE course_name='$student_course'");
$course = mysqli_fetch_assoc($course_query);

$course_id = 0;
if ($course) {
    $course_id = $course['course_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

:root{
    --primary:#6fa8ff;
    --primary-dark:#4d8dff;
    --bg-overlay: rgba(0,0,0,0.45);
    --card-bg: rgba(255,255,255,0.95);
}

*{box-sizing:border-box;margin:0;padding:0;font-family:"Inter",system-ui,Arial,sans-serif;}

body {
    min-height: 100vh;
    background: url('it.jpg') no-repeat center center fixed;
    background-size: cover;
    position: relative;
    color: #333;
}

/* overlay */
body::before {
    content:'';
    position: fixed;
    inset:0;
    background: var(--bg-overlay);
    z-index: 0;
}

/* container */
.container {
    position: relative;
    z-index: 1;
    max-width: 800px;
    margin: 100px auto 40px;
    padding: 30px;
    background: var(--card-bg);
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.25);
    text-align: center;
}

/* Welcome text */
.welcome {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 30px;
    color: #083a5e;
}

/* Cards */
.course-card, .history-card {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: #fff;
    padding: 25px 30px;
    border-radius: 14px;
    margin-bottom: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.course-card:hover, .history-card:hover{
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.25);
}

/* Card headings */
.course-card h3, .history-card h3{
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 12px;
}

/* Card paragraph */
.course-card p, .history-card p{
    font-size: 15px;
    margin-bottom: 20px;
    color: #f0f8ff;
}

/* Buttons */
.btn {
    background: #fff;
    color: var(--primary-dark);
    padding: 12px 28px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    transition: 0.2s ease;
}

.btn:hover{
    background: var(--primary-dark);
    color: #fff;
}

/* Logout link */
.logout {
    text-align: right;
    margin-bottom: 20px;
}
.logout a{
    color: #ff4b5c;
    font-weight: 700;
    text-decoration: none;
    transition: 0.2s ease;
}
.logout a:hover { text-decoration: underline; }

/* Responsive */
@media (max-width:768px){
    .container { padding: 20px; margin: 80px 16px; }
    .course-card h3, .history-card h3{ font-size: 20px; }
    .btn{ padding: 10px 22px; font-size: 14px; }
}
</style>
</head>
<body>

<div class="container">
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>

    <div class="welcome">
        Welcome <?php echo $_SESSION['student_name']; ?>! You are enrolled in <strong><?php echo $_SESSION['student_course']; ?></strong>.
    </div>

    <div class="course-card">
        <h3><?php echo $_SESSION['student_course']; ?> Quiz</h3>
        <p>This quiz contains questions from <strong>all topics</strong> in your course.</p>
        <a class="btn" href="take_quiz.php?course_id=<?php echo $course_id; ?>">Take Quiz Now</a>
    </div>

    <div class="history-card">
        <h3>Quiz History</h3>
        <p>View your previous quiz attempts and scores per topic.</p>
        <a class="btn" href="quiz_history_student.php">View Quiz History</a>
    </div>
</div>

</body>
</html>
