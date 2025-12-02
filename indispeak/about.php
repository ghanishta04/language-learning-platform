<?php
session_start();

if (!isset($_SESSION['id'])) { 
    // user not logged in
    header("Location: login.php");
    exit();
}

// load values safely
$user_id = $_SESSION['id'];
$username = $_SESSION['username'] ?? "User";

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About Indispeak</title>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(to bottom right, #d9eeff, #e6f3ff);
        display: flex;
    }

    /* Sidebar */
    .sidebar {
        width: 230px;
        background: linear-gradient(180deg, #005c97, #0083b0);
        height: 100vh;
        padding: 20px;
        color: white;
        position: fixed;
    }

    .sidebar h2 {
        font-size: 22px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sidebar a {
        display: block;
        padding: 10px 0;
        text-decoration: none;
        color: white;
        font-size: 16px;
        margin: 6px 0;
    }

    .sidebar a:hover {
        background: rgba(255,255,255,0.2);
        border-radius: 6px;
        padding-left: 12px;
        transition: 0.3s;
    }

    /* Main Content */
    .main-content {
        margin-left: 260px;
        padding: 40px;
        width: calc(100% - 260px);
    }

    .container {
        width: 90%;
        max-width: 1200px;
        background: white;
        padding: 35px 45px;
        border-radius: 16px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        margin: auto;
    }

    h1 {
        margin-bottom: 15px;
    }

    ul {
        line-height: 1.8;
    }

    /* Profile Image (top right of screen) */
    .profile-img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        position: absolute;
        right: 25px;
        top: 20px;
        border: 2px solid #0077aa;
    }
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>🌐 Indispeak</h2>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="my_courses.php">📘 My Courses</a>
    <a href="quizzes.php">📝 Quizzes</a>
    <a href="help.php">❓ Help</a>
    <a href="about.php"><b>📖 About</b></a>
    <a href="profile.php">👤 Profile</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<!-- Profile Top Right -->
<img src="uploads/<?php echo $profile_pic; ?>" class="profile-img">

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h1>About Indispeak 🌟</h1>

        <h2>🇮🇳 What is Indispeak?</h2>
        <p>Indispeak is a fun & friendly platform that helps you learn Indian regional languages easily and interactively!</p><br>

        <h2>✨ Why Indispeak?</h2>
        <ul>
            <li>Simple Flashcards for quick learning</li>
            <li>Speak & Listen pronunciation feature</li>
            <li>Quizzes to test what you learn</li>
            <li>Supports multiple Indian languages</li>
        </ul><br>

        <h2>💛 Made With Love</h2>
        <p>Designed, developed and improved step-by-step — just for learners like you!</p>
    </div>
</div>

</body>
</html>
