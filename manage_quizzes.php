<?php
session_start();
include 'config.php';

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch quizzes
$quizzes = mysqli_query($conn, "
    SELECT q.quiz_id, q.question, t.topic_name 
    FROM quizzes q
    JOIN topics t ON q.topic_id = t.topic_id
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Manage Quizzes</title>
    <style>
        body { font-family: Arial; background: #f4f6fa; padding: 20px; }
        .container { max-width: 1000px; margin:auto; }
        h2 { text-align:center; margin-bottom: 20px; }
        table {
            width: 100%; border-collapse: collapse; margin-bottom: 20px;
            background: #fff; border-radius: 12px; overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        th, td { padding: 10px; text-align:left; border-bottom:1px solid #ddd; }
        th { background: #6fa8ff; color: white; }
        a.btn {
            display:inline-block; margin:2px; padding:6px 12px; background:#6fa8ff; color:white; text-decoration:none; border-radius:8px;
        }
        a.btn:hover { background:#4d8dff; }
        .add-btn { margin-bottom: 15px; display:inline-block; background:#4ecdc4; }
        .add-btn:hover { background:#38b9a9; }
    </style>
</head>
<body>

<div class="container">
    <h2>Manage Quizzes</h2>

    <a class="btn add-btn" href="add_quiz.php">Add New Quiz</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Topic</th>
            <th>Question</th>
            <th>Actions</th>
        </tr>

        <?php while($q = mysqli_fetch_assoc($quizzes)) { ?>
            <tr>
                <td><?php echo $q['quiz_id']; ?></td>
                <td><?php echo $q['topic_name']; ?></td>
                <td><?php echo $q['question']; ?></td>
                <td>
                    <a class="btn" href="edit_quiz.php?id=<?php echo $q['quiz_id']; ?>">Edit</a>
                    <a class="btn" href="delete_quiz.php?id=<?php echo $q['quiz_id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <a class="btn" href="admin_dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
