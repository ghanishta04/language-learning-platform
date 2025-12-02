<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'] ?? "Learner";

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Quizzes | Indispeak</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #d9efff, #e9f5ff);
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

/* Main Section */
.main {
    margin-left: 260px;
    padding: 40px;
    width: calc(100% - 260px);
}

/* Profile image */
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

/* Quiz Box */
.quiz-box {
  background: #ffffffee;
  padding: 25px;
  border-radius: 16px;
  margin-top: 25px;
  box-shadow: 0 3px 12px rgba(0,0,0,0.15);
}
.quiz-select {
  padding: 12px;
  border-radius: 10px;
  border: 1px solid #bbb;
  width: 100%;
  font-size: 17px;
  outline: none;
  margin-bottom: 15px;
}
.start-quiz {
  background: #0077aa;
  border: none;
  padding: 12px 18px;
  border-radius: 12px;
  color: white;
  transition:.3s;
  cursor:pointer;
}
.start-quiz:hover {
  transform: scale(1.08);
  background:#0096c7;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
  <h2>🌍 Indispeak</h2>

  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="my_courses.php">📘 My Courses</a>
  <a href="profile.php">👤 Profile</a>

  <hr style="border: none; height: 1px; background: rgba(255,255,255,0.4); margin: 14px 0;">

  <a href="quizzes.php">✍️ Quizzes</a>
  <a href="help.php">❓ Help</a>
  <a href="about.php">ℹ️ About</a>

  <hr style="border: none; height: 1px; background: rgba(255,255,255,0.4); margin: 14px 0;">

  <a href="logout.php">🚪 Logout</a>
</div>



<!-- Main Content -->
<div class="main">
  <h1>📝 Quizzes</h1>
  <p>Select a language to test your knowledge!</p>

  <form action="quiz_start.php" method="GET" class="quiz-box">
      <select name="course" class="quiz-select" required>
          <option value="">Choose Language</option>
          <option>Hindi</option>
          <option>Marathi</option>
          <option>Gujarati</option>
          <option>Telugu</option>
          <option>Malayalam</option>
          <option>Assamese</option>
          <option>Bengali</option>
      </select>
      <button type="submit" class="start-quiz">Start Quiz 🚀</button>
  </form>
</div>

</body>
</html>
