<?php
session_start();
require "db.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['course'])) {
    header("Location: dashboard.php");
    exit();
}

$userId = $_SESSION['id'];
$courseName = mysqli_real_escape_string($conn, $_GET['course']);

$stmt = $conn->prepare("INSERT INTO user_courses (user_id, course_name, progress, started_at)
VALUES (?, ?, 0, NOW())
ON DUPLICATE KEY UPDATE started_at = NOW()");
$stmt->bind_param("is", $userId, $courseName);
$stmt->execute();

// IMPORTANT: redirect to lessons.php with course name
header("Location: lessons.php?course=$courseName");
exit();
