<?php
session_start();
include 'config.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['student_id'])) {
    die("Invalid student ID.");
}

$student_id = $_GET['student_id'];

// Fetch student info
$student_query = mysqli_query($conn, "SELECT * FROM students WHERE student_id = $student_id");
$student = mysqli_fetch_assoc($student_query);

// Fetch student quiz results (assuming a table 'quiz_results' exists)
// If you don't have a results table yet, we can use session/localStorage storage or create a 'results' table.
$results = mysqli_query($conn, "
    SELECT q.quiz_id, q.topic_id, t.topic_name, q.question, q.correct_option
    FROM quizzes q
    JOIN topics t ON q.topic_id = t.topic_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Report</title>
    <style>
        body { font-family: Arial; background: #f4f6fa; padding: 20px; }
        .container { max-width: 900px; margin: auto; }
        h2, h3 { text-align: center; margin-bottom: 15px; }
        table {
            width: 100%; border-collapse: collapse; margin-bottom: 20px;
            background: #fff; border-radius: 12px; overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #6fa8ff; color: white; }
        a.btn { display: inline-block; margin-top: 10px; padding: 6px 12px; background: #6fa8ff; color:white; text-decoration:none; border-radius: 8px; }
        a.btn:hover { background: #4d8dff; }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Report</h2>
    <h3><?php echo $student['full_name'] . " (" . $student['username'] . ")"; ?></h3>

    <table>
        <tr>
            <th>Topic</th>
            <th>Question</th>
            <th>Correct Option</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($results)) { ?>
            <tr>
                <td><?php echo $row['topic_name']; ?></td>
                <td><?php echo $row['question']; ?></td>
                <td><?php echo $row['correct_option']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <a class="btn" href="admin_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
