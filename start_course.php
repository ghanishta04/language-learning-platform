<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id']) || !isset($_GET['course_name'])) {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['id'];
$course_name = trim($_GET['course_name']);

// ✅ Check if course already exists for this user
$stmt = $conn->prepare("SELECT id FROM user_courses WHERE user_id = ? AND course_name = ?");
$stmt->bind_param("is", $user_id, $course_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // 🚀 Insert new course for the user
    $insert = $conn->prepare("INSERT INTO user_courses (user_id, course_name, progress, started_at) VALUES (?, ?, 0, NOW())");
    $insert->bind_param("is", $user_id, $course_name);
    $insert->execute();
    $course_id = $conn->insert_id; // last inserted row ID
} else {
    $row = $result->fetch_assoc();
    $course_id = $row['id'];
}

// ✅ Save current course in session for highlighting
$_SESSION['current_course_id'] = $course_id;

// Redirect to lessons page for that course
header("Location: lessons.php?course=" . urlencode($course_name));
exit();
?>
