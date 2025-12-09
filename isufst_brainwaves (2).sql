-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2025 at 11:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `isufst_brainwaves`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', '123');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`) VALUES
(3, 'BSED'),
(2, 'BSHM'),
(1, 'BSIT');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` char(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `topic_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `created_at`, `updated_at`) VALUES
(1, 1, 'Which language is primarily used for web development?', 'Python', 'HTML', 'Java', 'C++', 'B', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(2, 1, 'Which of these is a compiled language?', 'JavaScript', 'Python', 'C++', 'HTML', 'C', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(3, 1, 'Which language is commonly used for mobile apps?', 'Swift', 'HTML', 'CSS', 'PHP', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(4, 1, 'Which language is mainly used for statistical analysis?', 'R', 'C#', 'HTML', 'Java', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(5, 1, 'Which is a scripting language?', 'C++', 'Python', 'Java', 'Fortran', 'B', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(6, 2, 'Which tag is used for links in HTML?', 'div', 'a', 'link', 'span', 'B', '2025-12-07 04:41:31', '2025-12-07 06:47:28'),
(7, 2, 'CSS stands for?', 'Cascading Style Sheets', 'Computer Style Sheets', 'Creative Style Scripts', 'Colorful Style Sheets', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(8, 2, 'Which attribute is used to link an external CSS file?', 'href', 'src', 'link', 'rel', 'D', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(9, 2, 'Which property changes text color in CSS?', 'color', 'font-size', 'text-decoration', 'background-color', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(10, 2, 'Which JavaScript method is used to display a message?', 'console.print', 'alert', 'write', 'show', 'B', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(11, 3, 'Which SQL statement is used to retrieve data?', 'SELECT', 'INSERT', 'UPDATE', 'DELETE', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(12, 3, 'Which of the following is a NoSQL database?', 'MySQL', 'PostgreSQL', 'MongoDB', 'Oracle', 'C', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(13, 3, 'What does SQL stand for?', 'Structured Query Language', 'Simple Query Language', 'Sequential Query Logic', 'Structured Question List', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(14, 3, 'Which command adds a new record to a table?', 'INSERT', 'UPDATE', 'SELECT', 'DELETE', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(15, 3, 'Which command is used to remove a table?', 'DROP', 'DELETE', 'REMOVE', 'ERASE', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(16, 4, 'What does IP stand for?', 'Internet Protocol', 'Internal Program', 'Internet Package', 'Internal Protocol', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(17, 4, 'Which device forwards data packets between networks?', 'Switch', 'Router', 'Hub', 'Modem', 'B', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(18, 4, 'Which topology connects all devices in a circle?', 'Star', 'Bus', 'Ring', 'Mesh', 'C', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(19, 4, 'Which protocol is used to transfer web pages?', 'HTTP', 'FTP', 'SMTP', 'IMAP', 'A', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(20, 4, 'What is the default port for HTTP?', '21', '80', '443', '25', 'B', '2025-12-07 04:41:31', '2025-12-07 04:41:31'),
(21, 5, 'What is the primary role of a concierge?', 'Cleaning rooms', 'Booking reservations', 'Cooking meals', 'Managing accounts', 'B', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(22, 5, 'Which type of hotel service focuses on personalized guest experience?', 'Budget', 'Luxury', 'Self-service', 'Hostel', 'B', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(23, 5, 'Which department handles guest complaints?', 'Front Office', 'Housekeeping', 'Kitchen', 'Marketing', 'A', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(24, 5, 'Which is an example of luxury service?', 'Buffet', 'Butler service', 'Self-check-in', 'Hostel room', 'B', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(25, 5, 'What does PMS stand for in hotels?', 'Property Management System', 'Private Management Service', 'Professional Management System', 'Property Marketing System', 'A', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(26, 6, 'Which of these is a key aspect of tourism marketing?', 'Target audience', 'Cooking', 'Laundry service', 'Room cleaning', 'A', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(27, 6, 'Which platform is most used for online tourism promotions?', 'Facebook', 'LinkedIn', 'WhatsApp', 'Spotify', 'A', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(28, 6, 'What is the main goal of tourism marketing?', 'Promote destinations', 'Serve food', 'Clean rooms', 'Book flights', 'A', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(29, 6, 'Which is an effective tourism advertisement?', 'Colorful flyers', 'Word-of-mouth', 'Social media campaigns', 'All of the above', 'D', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(30, 6, 'Which factor influences tourist choices?', 'Price', 'Culture', 'Accessibility', 'All of the above', 'D', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(31, 7, 'What is mise en place?', 'Preparing ingredients before cooking', 'Serving drinks', 'Cleaning tables', 'Ordering supplies', 'A', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(32, 7, 'Which course is typically served first in a fine dining meal?', 'Dessert', 'Appetizer', 'Main Course', 'Salad', 'B', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(33, 7, 'Which utensil is used for soup?', 'Fork', 'Knife', 'Spoon', 'Chopsticks', 'C', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(34, 7, 'What is the standard wine serving temperature?', '10°C', '20°C', '16-18°C', '30°C', 'C', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(35, 7, 'Which beverage pairs well with red meat?', 'White wine', 'Red wine', 'Tea', 'Coffee', 'B', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(36, 8, 'Which is a key step in event planning?', 'Random selection', 'Budgeting', 'Ignoring guests', 'Skipping venue', 'B', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(37, 8, 'What is the main goal of an event coordinator?', 'Decorate tables', 'Ensure smooth event execution', 'Prepare food', 'Take photos', 'B', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(38, 8, 'Which is part of event logistics?', 'Catering', 'Venue setup', 'Transportation', 'All of the above', 'D', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(39, 8, 'Which document lists all event tasks?', 'Checklist', 'Invoice', 'Menu', 'Schedule', 'A', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(40, 8, 'What is the first step in planning an event?', 'Evaluate success', 'Choose venue', 'Define objectives', 'Hire staff', 'C', '2025-12-07 04:42:28', '2025-12-07 04:42:28'),
(41, 9, 'Who is known as the father of educational psychology?', 'Piaget', 'Skinner', 'Vygotsky', 'Thorndike', 'D', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(42, 9, 'Which term refers to a student’s ability to regulate their own learning?', 'Motivation', 'Self-efficacy', 'Self-regulation', 'Attention', 'C', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(43, 9, 'Which theory emphasizes stages of cognitive development?', 'Behaviorism', 'Cognitivism', 'Piaget’s theory', 'Constructivism', 'C', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(44, 9, 'What is intrinsic motivation?', 'Reward-based', 'Internal drive', 'Punishment-based', 'External pressure', 'B', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(45, 9, 'Which method measures intelligence?', 'IQ test', 'Survey', 'Interview', 'Observation', 'A', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(46, 10, 'Backward design focuses on?', 'Planning activities first', 'Starting with assessments', 'Choosing textbooks first', 'Following a textbook', 'B', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(47, 10, 'Which is a type of curriculum?', 'Formal', 'Informal', 'Hidden', 'All of the above', 'D', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(48, 10, 'Spiral curriculum emphasizes?', 'Repetition with increasing complexity', 'Skipping topics', 'Learning by memorization', 'Only practical skills', 'A', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(49, 10, 'Integrated curriculum combines?', 'Subjects', 'Teachers', 'Students', 'Parents', 'A', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(50, 10, 'Curriculum mapping is used for?', 'Scheduling classes', 'Tracking learning outcomes', 'Grading students', 'None of these', 'B', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(51, 11, 'Which teaching method is student-centered?', 'Lecture', 'Discussion', 'Project-based learning', 'All of the above', 'C', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(52, 11, 'What does STEM stand for?', 'Science, Technology, Engineering, Math', 'Science, Teaching, English, Math', 'Students, Teaching, Education, Methods', 'None of these', 'A', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(53, 11, 'Which is a cooperative learning method?', 'Pair work', 'Lecture', 'Reading silently', 'Exam', 'A', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(54, 11, 'Flipped classroom involves?', 'Teacher lectures only', 'Students watch lessons at home', 'No homework', 'Only exams', 'B', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(55, 11, 'Active learning focuses on?', 'Listening', 'Memorization', 'Student participation', 'Skipping lessons', 'C', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(56, 12, 'Which is an effective classroom management strategy?', 'Ignoring misbehavior', 'Positive reinforcement', 'Punishing all mistakes', 'Allowing chaos', 'B', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(57, 12, 'Which seating arrangement promotes group work?', 'Rows', 'Circle', 'Theater style', 'Random', 'B', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(58, 12, 'Which method encourages student engagement?', 'Silent reading', 'Group discussions', 'Lectures only', 'None of these', 'B', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(59, 12, 'Which rule promotes discipline?', 'Consistent enforcement', 'Ignoring rules', 'Changing rules daily', 'Punishing all equally', 'A', '2025-12-07 04:48:40', '2025-12-07 04:48:40'),
(60, 12, 'Which is a proactive classroom management approach?', 'Setting expectations in advance', 'Reacting after misbehavior', 'Ignoring minor issues', 'Punishing only', 'A', '2025-12-07 04:48:40', '2025-12-07 04:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_history`
--

CREATE TABLE `quiz_history` (
  `history_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `total_score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `attempt_date` datetime DEFAULT current_timestamp(),
  `topic1_correct` int(11) DEFAULT 0,
  `topic1_total` int(11) DEFAULT 0,
  `topic2_correct` int(11) DEFAULT 0,
  `topic2_total` int(11) DEFAULT 0,
  `topic3_correct` int(11) DEFAULT 0,
  `topic3_total` int(11) DEFAULT 0,
  `topic4_correct` int(11) DEFAULT 0,
  `topic4_total` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_history`
--

INSERT INTO `quiz_history` (`history_id`, `student_id`, `course_id`, `total_score`, `total_questions`, `attempt_date`, `topic1_correct`, `topic1_total`, `topic2_correct`, `topic2_total`, `topic3_correct`, `topic3_total`, `topic4_correct`, `topic4_total`) VALUES
(2, 1, 1, 10, 20, '2025-12-07 15:16:24', 2, 5, 2, 5, 4, 5, 2, 5),
(3, 2, 2, 17, 20, '2025-12-07 15:23:34', 3, 5, 5, 5, 4, 5, 5, 5),
(5, 3, 3, 8, 20, '2025-12-07 15:48:56', 1, 5, 3, 5, 2, 5, 2, 5),
(6, 1, 1, 8, 20, '2025-12-09 12:11:56', 2, 5, 1, 5, 2, 5, 3, 5),
(7, 1, 1, 8, 20, '2025-12-09 13:08:39', 1, 5, 2, 5, 3, 5, 2, 5),
(8, 1, 1, 8, 20, '2025-12-09 13:08:39', 1, 5, 2, 5, 3, 5, 2, 5),
(9, 1, 1, 2, 20, '2025-12-09 18:24:04', 0, 5, 0, 5, 1, 5, 1, 5),
(10, 3, 3, 4, 20, '2025-12-09 18:30:35', 1, 5, 2, 5, 0, 5, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `course` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `course`, `full_name`, `username`, `password`, `created_at`) VALUES
(1, 'BSIT', 'Vince Sumagaysay', 'Vince', '123', '2025-12-07 06:10:00'),
(2, 'BSHM', 'Joshua Magbanua', 'joshua', '123', '2025-12-07 07:18:42'),
(3, 'BSED', 'John Lester Dimzon', 'jan', '123', '2025-12-07 07:47:47');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `topic_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `course_id`, `topic_name`) VALUES
(1, 1, 'Programming Language'),
(2, 1, 'Web Development'),
(3, 1, 'Database Management'),
(4, 1, 'Networking'),
(5, 2, 'Hospitality Management'),
(6, 2, 'Tourism Marketing'),
(7, 2, 'Food and Beverage Service'),
(8, 2, 'Event Planning'),
(9, 3, 'Educational Psychology'),
(10, 3, 'Curriculum Development'),
(11, 3, 'Teaching Methods'),
(12, 3, 'Classroom Management');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_name` (`course_name`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `quiz_history`
--
ALTER TABLE `quiz_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `quiz_history`
--
ALTER TABLE `quiz_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz_history`
--
ALTER TABLE `quiz_history`
  ADD CONSTRAINT `quiz_history_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_history_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
