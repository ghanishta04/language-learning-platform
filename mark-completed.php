<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['lesson_id'], $_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $lessonId = intval($_POST['lesson_id']);

    // Mark lesson as completed
    $stmt = $conn->prepare("INSERT IGNORE INTO completed_lessons (user_id, lesson_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $userId, $lessonId);
    $stmt->execute();
}

header("Location: lessons.php");
exit();
