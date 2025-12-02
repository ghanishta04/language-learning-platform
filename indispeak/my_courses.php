<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch user profile
$userQuery = $conn->prepare("SELECT username, profile_pic FROM signup WHERE id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result()->fetch_assoc();
$username = $userResult['username'];
$profilePic = (!empty($userResult['profile_pic'])) ? 'uploads/' . $userResult['profile_pic'] : 'uploads/default.png';

// Fetch enrolled courses
$stmt = $conn->prepare("SELECT * FROM user_courses WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Active course indicator
$current_course_id = $_SESSION['current_course_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Courses | IndiSpeak</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
body {
  display: flex;
  margin: 0;
  background: #cce6ff;
  font-family: "Poppins", sans-serif;
}

/* Sidebar */
.sidebar {
  width: 250px;
  background-color: #0097a7;
  padding: 25px 20px;
  color: white;
  display: flex;
  flex-direction: column;
  height: 100vh;
}
.sidebar h2 { margin-bottom: 35px; }
.sidebar a {
  color: white;
  text-decoration: none;
  margin: 14px 0;
  font-size: 17px;
}
.sidebar a:hover { text-decoration: underline; }

/* Main layout */
.main {
  flex-grow: 1;
  padding: 30px 45px;
  overflow-y: auto;
}

/* Header */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.header h1 { color: #004d66; }

.profile-section {
  display: flex;
  align-items: center;
  gap: 12px;
}
.profile-img {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid white;
}
.logout-btn {
  background-color: #e53935;
  color: white;
  padding: 8px 16px;
  border: none;
  border-radius: 20px;
  cursor: pointer;
}

/* Courses Section */
.course-grid {
  margin-top: 35px;
  display: flex;
  flex-wrap: wrap;
  gap: 24px;
}

.course-card {
  width: 260px;
  background: rgba(255,255,255,0.9);
  border-radius: 18px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.12);
  border-left: 6px solid #007a99;
  transition: transform .25s, box-shadow .25s;
  opacity: 0;
  transform: translateY(40px);
  animation: fadeSlide 0.6s forwards;
}
.course-card:nth-child(n) { animation-delay: calc(0.1s * var(--i)); }

.course-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 7px 20px rgba(0,0,0,0.20);
}

.active-course {
  border-left: 7px solid #00acc1;
  background: #e0faff !important;
}

.course-card h4 {
  margin-bottom: 6px;
  color: #005b73;
}

/* Entry Animation */
@keyframes fadeSlide {
  to {
    opacity: 1;
    transform: translateY(0);
  }
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

<!-- Main Page -->
<div class="main">
  <div class="header">
    <h1>📘 My Courses</h1>
    <div class="profile-section">
      <img src="<?= $profilePic ?>" class="profile-img">
      <form action="logout.php" method="POST">
        <button class="logout-btn">Logout</button>
      </form>
    </div>
  </div>

  <div class="course-grid">
    <?php
    $i = 1;
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $is_current = ($row['id'] == $current_course_id) ? 'active-course' : '';
        $badge = ($row['id'] == $current_course_id) ? '<span class="badge bg-success">Current</span>' : '';
        echo "
        <div class='course-card $is_current' style='--i:$i'>
          <h4>".ucfirst(htmlspecialchars($row['course_name']))." $badge</h4>
          <p class='text-muted'>Started: ".date("d M Y", strtotime($row['started_at']))."</p>
        </div>";
        $i++;
      }
    } else {
      echo "<p class='text-muted'>No courses started yet.</p>";
    }
    ?>
  </div>

</div>

</body>
</html>
