<?php
session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'msg' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['id'];
$lesson = $_POST['lesson'];
$total = $_POST['total'];
$correct = $_POST['correct'];

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'langlearn';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'msg' => 'DB error']);
    exit;
}

// Insert into lesson_scores
$stmt = $conn->prepare("INSERT INTO lesson_scores (user_id, lesson_title, total_questions, correct_answers) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isii", $user_id, $lesson, $total, $correct);
$stmt->execute();
$stmt->close();

// Optional: mark lesson completed
$stmt2 = $conn->prepare("INSERT INTO completed_lessons (user_id, lesson_title) VALUES (?, ?) ON DUPLICATE KEY UPDATE status = 'completed'");
$stmt2->bind_param("is", $user_id, $lesson);
$stmt2->execute();
$stmt2->close();

$conn->close();

echo json_encode(['success' => true]);
?>