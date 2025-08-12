<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$title = $_POST['title'] ?? '';
$user_id = $_SESSION['id'];

// Optionally check answers here...

// Save progress as completed (optional)
$conn = new mysqli("localhost", "root", "", "your_database");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("INSERT INTO completed_lessons (user_id, lesson_title, status) VALUES (?, ?, 'completed')");
$stmt->bind_param("is", $user_id, $title);
$stmt->execute();
$stmt->close();
$conn->close();

echo "<h3>Lesson Completed! ✅</h3>";
echo "<a href='lessons.php'>Back to Lessons</a>";
