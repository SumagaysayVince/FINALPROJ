<?php
session_start();
include 'db.php'; // Include your existing database connection

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if student_id is provided via GET
if (!isset($_GET['student_id'])) {
    echo "Student not specified.";
    exit();
}

$student_id = intval($_GET['student_id']);

// Get student details
$student_q = mysqli_query($conn, "SELECT full_name FROM students WHERE student_id='$student_id'");
if (mysqli_num_rows($student_q) == 0) {
    echo "Student not found.";
    exit();
}
$student = mysqli_fetch_assoc($student_q);

// Fetch quiz history
$query = "SELECT qh.*, c.course_name 
          FROM quiz_history qh
          JOIN courses c ON qh.course_id = c.course_id
          WHERE qh.student_id='$student_id'
          ORDER BY qh.attempt_date DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($student['full_name']); ?> - Quiz History</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');

:root{
    --accent:#6fa8ff;
    --accent-dark:#4d8dff;
    --muted:#7b8fae;
    --success:#27ae60;
    --card-bg: rgba(255,255,255,0.95);
}

*{box-sizing:border-box;margin:0;padding:0}
body{
    font-family:"Inter",system-ui,Arial,sans-serif;
    min-height:100vh;
    background: url('it2.jpg') no-repeat center center fixed;
    background-size: cover;
    position: relative;
    color:#223;
}
body::before{
    content:'';
    position:fixed;
    inset:0;
    background: rgba(0,0,0,0.45);
    z-index:0;
}

/* HEADER */
header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 24px;
    z-index: 5;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.brand .logo {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.05);
}

.brand .logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

.brand h1 {
    font-size: 20px;
    color: #fff;
    font-weight: 700;
    margin: 0;
    letter-spacing: 0.5px;
}

.header-actions a {
    padding: 8px 16px;
    background: linear-gradient(135deg, var(--accent), var(--accent-dark));
    color: #fff;
    font-weight: 700;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.2s ease;
}
.header-actions a:hover {
    transform: translateY(-2px);
    opacity: 0.9;
}

/* Main container */
.page {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 110px auto 40px;
    padding: 24px;
    background: var(--card-bg);
    border-radius: 14px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.25);
}

h2 {
    font-size: 22px;
    color: #083a5e;
    margin-bottom: 20px;
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 760px;
}

th, td {
    padding: 12px 14px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    text-align: center;
    font-size: 14px;
}

th {
    background: linear-gradient(90deg,var(--accent), #9fd7ff);
    color: #083a5e;
    font-weight: 700;
    position: sticky;
    top: 0;
}

tbody tr{ background: #fff; }
tbody tr:nth-child(even){ background: #f7fbff; }
tbody tr:hover{ background: #f0f8ff; }

a.back {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: linear-gradient(135deg,var(--accent),var(--accent-dark));
    color: #fff;
    border-radius: 10px;
    font-weight: 700;
    text-decoration: none;
}
a.back:hover { opacity:0.95; transform:translateY(-2px); }

@media (max-width:900px){
    table{ font-size:13px; min-width:600px; }
}
@media (max-width:600px){
    .brand h1{ font-size:16px; }
}
</style>
</head>
<body>

<header>
    <div class="brand">
        <span class="logo"><img src="logo.png" alt="Logo"></span>
        <h1>ISUFST BrainWave</h1>
    </div>

    <div class="header-actions">
        <span style="color:#fff; font-weight:600;">Quiz History: <?php echo htmlspecialchars($student['full_name']); ?></span>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</header>

<main class="page">
    <h2>Quiz History - <?php echo htmlspecialchars($student['full_name']); ?></h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>Score</th>
                    <th>Total Questions</th>
                    <th>Attempt Date</th>
                    <th>Topic 1</th>
                    <th>Topic 2</th>
                    <th>Topic 3</th>
                    <th>Topic 4</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                        <td><?php echo $row['total_score']; ?></td>
                        <td><?php echo $row['total_questions']; ?></td>
                        <td><?php echo date('F j, Y, g:i A', strtotime($row['attempt_date'])); ?></td>
                        <td><?php echo $row['topic1_correct'].'/'.$row['topic1_total']; ?></td>
                        <td><?php echo $row['topic2_correct'].'/'.$row['topic2_total']; ?></td>
                        <td><?php echo $row['topic3_correct'].'/'.$row['topic3_total']; ?></td>
                        <td><?php echo $row['topic4_correct'].'/'.$row['topic4_total']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No quiz history found for this student.</p>
    <?php endif; ?>

    <a class="back" href="admin_dashboard.php">Back to Dashboard</a>
</main>

</body>
</html>
