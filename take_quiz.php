<?php
session_start();
include 'db.php'; // Database connection

// Redirect if student not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// Get course_id from URL
if (!isset($_GET['course_id'])) {
    echo "Course not specified.";
    exit();
}

$course_id = $_GET['course_id'];

// Fetch all quizzes for this course
$quiz_query = mysqli_query($conn, "SELECT q.*, t.topic_name FROM quizzes q 
                                  JOIN topics t ON q.topic_id = t.topic_id
                                  WHERE t.course_id='$course_id' ORDER BY q.quiz_id ASC");

$quizzes = [];
while ($row = mysqli_fetch_assoc($quiz_query)) {
    $quizzes[] = $row;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $answers = $_POST['answer'] ?? [];

    // Save answers and course_id in session for result processing
    $_SESSION['student_answers'] = $answers;
    $_SESSION['course_id'] = $course_id;

    // Redirect to result page
    header("Location: quiz_result.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Quiz</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        /* Background image */
        background: url('it.jpg') no-repeat center center fixed;
        background-size: cover;
        position: relative;
        min-height: 100vh;
    }

    /* Overlay for contrast */
    body::before {
        content: '';
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 0;
    }

    .container {
        position: relative;
        z-index: 1;
        max-width: 900px;
        margin: 60px auto;
        background: rgba(255, 255, 255, 0.95); /* semi-transparent for readability */
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        text-align: center;
    }

    h2 { margin-bottom: 20px; }
    .question {
        margin-bottom: 20px;
        padding: 15px;
        background: #eef3ff;
        border-radius: 8px;
        text-align: left;
    }
    .option { margin: 8px 0; }
    input[type="radio"] { margin-right: 10px; }

    button, .back-btn {
        background: #6fa8ff;
        color: white;
        border: none;
        padding: 12px 25px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        margin-top: 15px;
        text-decoration: none;
        display: inline-block;
    }
    button:hover, .back-btn:hover { background: #4d8dff; }

    .hidden { display: none; }
    </style>
</head>
<body>

<div class="container">

    <!-- Start screen -->
    <div id="start-screen">
        <h2>Welcome <?php echo $_SESSION['student_name']; ?>!</h2>
        <p>You are about to take the <strong><?php echo $_SESSION['student_course']; ?></strong> quiz.</p>
        <button id="start-btn">Start Quiz</button>
        <a class="back-btn" href="student_dashboard.php">Back to Dashboard</a>
    </div>

    <!-- Quiz form -->
    <form id="quiz-form" method="POST" class="hidden">
        <?php foreach ($quizzes as $index => $quiz): ?>
            <div class="question">
                <strong>Q<?php echo $index + 1; ?> (<?php echo $quiz['topic_name']; ?>):</strong> <?php echo $quiz['question']; ?>

                <?php
                $options = [
                    'A' => trim($quiz['option_a']) !== '' ? $quiz['option_a'] : "Option A not set",
                    'B' => trim($quiz['option_b']) !== '' ? $quiz['option_b'] : "Option B not set",
                    'C' => trim($quiz['option_c']) !== '' ? $quiz['option_c'] : "Option C not set",
                    'D' => trim($quiz['option_d']) !== '' ? $quiz['option_d'] : "Option D not set",
                ];
                ?>

                <?php foreach ($options as $key => $text): ?>
                    <div class="option">
                        <label>
                            <input type="radio" name="answer[<?php echo $quiz['quiz_id']; ?>]" value="<?php echo $key; ?>" required>
                            <?php echo $text; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" name="submit">Submit Quiz</button>
        <a class="back-btn" href="student_dashboard.php">Back to Dashboard</a>
    </form>

</div>

<script>
    const startBtn = document.getElementById('start-btn');
    const startScreen = document.getElementById('start-screen');
    const quizForm = document.getElementById('quiz-form');

    startBtn.addEventListener('click', () => {
        startScreen.classList.add('hidden');
        quizForm.classList.remove('hidden');
        window.scrollTo(0, 0);
    });
</script>

</body>
</html>
