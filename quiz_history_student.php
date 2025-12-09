<?php
session_start();
include 'db.php'; // Database connection

// Redirect if student not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch quiz history with course name
$query = "SELECT qh.*, c.course_name 
          FROM quiz_history qh
          JOIN courses c ON qh.course_id = c.course_id
          WHERE qh.student_id = '$student_id'
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
    <title>Quiz History</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: url('it2.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
            color: #222;
        }

        /* Overlay for readability */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1100px;
            margin: 80px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #083a5e;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background: linear-gradient(90deg, #6fa8ff, #9fd7ff);
            color: #fff;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        tbody tr {
            background: #f9faff;
            transition: background 0.3s;
        }

        tbody tr:nth-child(even) {
            background: #eef4ff;
        }

        tbody tr:hover {
            background: #dce6ff;
        }

        td {
            font-size: 14px;
            color: #333;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background: #6fa8ff;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .back:hover {
            background: #4d8dff;
        }

        @media (max-width: 900px) {
            .container { margin: 60px 15px; padding: 20px; }
            th, td { padding: 10px 8px; font-size: 13px; }
        }

        @media (max-width: 600px) {
            h2 { font-size: 20px; }
            .back { padding: 10px 20px; font-size: 14px; }
            table { font-size: 12px; }
        }
    </style>
</head>
<body>

<div class="container">
    <h2><?php echo $_SESSION['student_name']; ?>'s Quiz History</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Course</th>
                    <th>Total Score</th>
                    <th>Total Questions</th>
                    <th>Topic 1</th>
                    <th>Topic 2</th>
                    <th>Topic 3</th>
                    <th>Topic 4</th>
                    <th>Attempt Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['course_name']; ?></td>
                        <td><?php echo $row['total_score']; ?></td>
                        <td><?php echo $row['total_questions']; ?></td>
                        <td><?php echo $row['topic1_correct'] . ' / ' . $row['topic1_total']; ?></td>
                        <td><?php echo $row['topic2_correct'] . ' / ' . $row['topic2_total']; ?></td>
                        <td><?php echo $row['topic3_correct'] . ' / ' . $row['topic3_total']; ?></td>
                        <td><?php echo $row['topic4_correct'] . ' / ' . $row['topic4_total']; ?></td>
                        <td><?php echo date('F j, Y, g:i A', strtotime($row['attempt_date'])); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center; margin-top: 20px; color:#555;">No quiz history found.</p>
    <?php endif; ?>

    <a class="back" href="student_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
