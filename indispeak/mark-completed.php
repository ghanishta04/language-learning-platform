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

    // ✅ Update leaderboard score
    $updateScore = $conn->prepare("
        INSERT INTO leaderboard (user_id, score)
        VALUES (?, 10)
        ON DUPLICATE KEY UPDATE score = score + 10
    ");
    $updateScore->bind_param("i", $userId); // ✅ correct variable
    $updateScore->execute();
}

header("Location: lessons.php");
exit();
