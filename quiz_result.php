<?php
session_start();
include 'db.php';

// Redirect if no quiz data
if (!isset($_SESSION['student_answers']) || !isset($_SESSION['course_id'])) {
    header("Location: student_dashboard.php");
    exit();
}

$course_id = $_SESSION['course_id'];
$student_id = $_SESSION['student_id'];
$student_answers = $_SESSION['student_answers'];

// Fetch all quizzes for this course
$quiz_query = mysqli_query($conn, "SELECT q.*, t.topic_name FROM quizzes q
                                  JOIN topics t ON q.topic_id = t.topic_id
                                  WHERE t.course_id='$course_id' ORDER BY t.topic_id, q.quiz_id ASC");

$total_score = 0;
$total_questions = 0;
$topic_scores = [];

while ($quiz = mysqli_fetch_assoc($quiz_query)) {
    $total_questions++;
    $quiz_id = $quiz['quiz_id'];
    $topic = $quiz['topic_name'];

    if (!isset($topic_scores[$topic])) {
        $topic_scores[$topic] = ['correct' => 0, 'total' => 0];
    }
    $topic_scores[$topic]['total']++;

    if (isset($student_answers[$quiz_id]) && $student_answers[$quiz_id] == $quiz['correct_option']) {
        $topic_scores[$topic]['correct']++;
        $total_score++;
    }
}

// Clear session answers
unset($_SESSION['student_answers']);
unset($_SESSION['course_id']);

// Map topics to table columns
$topics_list = array_keys($topic_scores);
for ($i = 0; $i < 4; $i++) {
    ${"topic".($i+1)."_correct"} = $topic_scores[$topics_list[$i]]['correct'] ?? 0;
    ${"topic".($i+1)."_total"}   = $topic_scores[$topics_list[$i]]['total'] ?? 0;
}

// Insert quiz attempt
$stmt = $conn->prepare("INSERT INTO quiz_history
(student_id, course_id, total_score, total_questions, attempt_date,
 topic1_correct, topic1_total, topic2_correct, topic2_total, topic3_correct, topic3_total, topic4_correct, topic4_total)
 VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "iiiiiiiiiiii",
    $student_id, $course_id, $total_score, $total_questions,
    $topic1_correct, $topic1_total,
    $topic2_correct, $topic2_total,
    $topic3_correct, $topic3_total,
    $topic4_correct, $topic4_total
);
$stmt->execute();
$stmt->close();

foreach ($topic_scores as $topic => $data) {
    $topic_scores[$topic]['percent'] = ($data['correct'] / $data['total']) * 100;
}

$percentages = array_column($topic_scores, 'percent');
$max_percent = max($percentages);
$min_percent = min($percentages);

$best_topics = [];
$worst_topics = [];
foreach ($topic_scores as $topic => $data) {
    if ($data['percent'] == $max_percent) $best_topics[] = $topic;
    if ($data['percent'] == $min_percent) $worst_topics[] = $topic;
}

function topic_comment($percent) {
    if ($percent >= 70) return "Excellent!";
    elseif ($percent >= 50) return "Good, needs practice.";
    else return "Work harder!";
}
$overall_comment = "Great job on " . implode(', ', $best_topics) . "! Focus on improving " . implode(', ', $worst_topics) . ".";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Quiz Result</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin:0; padding:0;
    background: linear-gradient(135deg,#6fa8ff,#9fd7ff);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}
.container {
    background:#fff;
    border-radius:16px;
    padding:40px;
    max-width:800px;
    width:95%;
    box-shadow:0 12px 40px rgba(0,0,0,0.2);
    position:relative;
}
h2 { text-align:center; color:#083a5e; margin-bottom:30px; }
.score { font-size:20px; font-weight:700; text-align:center; margin-bottom:25px; color:#333; }

.topic {
    background:#f0f4ff;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    position:relative;
}
.topic strong { font-size:16px; color:#083a5e; margin-bottom:10px; display:block; }

.progress-bar {
    background:#e0e7ff;
    border-radius:10px;
    overflow:hidden;
    height:24px;
    margin-top:10px;
}
.progress {
    height:100%;
    line-height:24px;
    color:white;
    font-weight:600;
    text-align:right;
    padding-right:8px;
    border-radius:10px;
    width:0;
    transition: width 1.2s ease;
}
.comment { margin-top:8px; font-style:italic; color:#555; }

.overall {
    margin-top:30px;
    font-weight:bold;
    font-size:16px;
    text-align:center;
    color:#083a5e;
}

a.back {
    display:inline-block;
    margin-top:30px;
    padding:12px 25px;
    background:#083a5e;
    color:#fff;
    font-weight:700;
    text-decoration:none;
    border-radius:12px;
    text-align:center;
    transition:0.3s;
}
a.back:hover { background:#4d8dff; }

/* Color coding for progress bars */
.green { background:#27ae60; }
.yellow { background:#f1c40f; }
.red { background:#e74c3c; }
</style>
</head>
<body>

<div class="container">
    <h2>Quiz Completed!</h2>
    <p class="score">Overall Score: <?php echo $total_score; ?> / <?php echo $total_questions; ?></p>

    <?php foreach ($topic_scores as $topic => $data): 
        $percent = round($data['percent']);
        if ($percent >= 70) $color = 'green';
        elseif ($percent >= 50) $color = 'yellow';
        else $color = 'red';
    ?>
    <div class="topic">
        <strong><?php echo $topic; ?></strong>
        <div class="progress-bar">
            <div class="progress <?php echo $color; ?>" style="width: <?php echo $percent; ?>%">
                <?php echo $data['correct']; ?> / <?php echo $data['total']; ?>
            </div>
        </div>
        <div class="comment"><?php echo topic_comment($percent); ?></div>
    </div>
    <?php endforeach; ?>

    <div class="overall"><?php echo $overall_comment; ?></div>

    <a class="back" href="student_dashboard.php">Back to Dashboard</a>
</div>

<script>
    // Animate progress bars after page load
    window.addEventListener('DOMContentLoaded', () => {
        const bars = document.querySelectorAll('.progress');
        bars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => { bar.style.width = width; }, 100);
        });
    });
</script>

</body>
</html>
