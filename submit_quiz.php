<?php
include 'db.php';
session_start();

if (!isset($_POST['answer'])) {
    die("No answers submitted.");
}

$score = 0;
$total = 0;
$answers = $_POST['answer'];

foreach ($answers as $quiz_id => $selected) {
    $result = mysqli_query($conn, "SELECT correct_option FROM quizzes WHERE quiz_id = $quiz_id");
    $row = mysqli_fetch_assoc($result);

    if ($row['correct_option'] == $selected) {
        $score++;
    }
    $total++;
}

$percent = ($score / $total) * 100;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Result</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6fa;
            text-align: center;
            padding: 50px;
        }
        .result-box {
            background: white;
            display: inline-block;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        a {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #6fa8ff;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="result-box">
    <h2>Quiz Result</h2>
    <p>Your Score: <b><?php echo "$score / $total"; ?></b></p>
    <p>Percentage: <b><?php echo round($percent, 2); ?>%</b></p>

    <a href="student_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
