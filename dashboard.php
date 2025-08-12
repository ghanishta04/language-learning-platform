
<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    
    exit();
}
include 'db.php'; // if not already included

$userId = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT profile_pic FROM signup WHERE id = $userId");
$user = mysqli_fetch_assoc($query);
$profilePic = !empty($user['profile_pic']) ? 'uploads/' . $user['profile_pic'] : 'uploads/default.png';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    body {
      display: flex;
      height: 100vh;
      background: #cce6ff;
    }

    .sidebar {
      width: 250px;
      background-color: #0097a7;
      padding: 20px;
      color: white;
      display: flex;
      flex-direction: column;
    }

    .sidebar h2 {
      margin-bottom: 30px;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      margin-bottom: 20px;
      font-size: 16px;
      display: flex;
      align-items: center;
    }

    .sidebar a:hover {
      text-decoration: underline;
    }

    .main {
      flex-grow: 1;
      padding: 20px 40px;
      overflow-y: auto;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .header h1 {
      color: #004d66;
    }

    .logout-btn {
      background-color: #e53935;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    .course-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    .course-card {
      background-color: #e3f2fd;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 5px 10px rgba(0,0,0,0.1);
    }

    .course-card h3 {
      font-size: 18px;
      color: #0077a7;
      margin-bottom: 20px;
    }

    .start-btn {
      background-color: #00acc1;
      color: white;
      padding: 10px 18px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  
  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Indispeak</h2>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="my_courses.php">📘 My Courses</a>
    <a href="profile.php">👤 Profile</a>
    
    <a href="logout.php">🚪 Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main">
    <div class="header">
      <h1> Courses</h1>
      
      <form action="logout.php" method="POST">
        <button class="logout-btn" type="submit">Logout</button>
      </form>
    </div>

   <div class="course-grid">
  <!-- English -->
  <div class="course-card">
    <h3>English Basics</h3>
    <a href="start_course.php?course_name=<?= urlencode('english') ?>" 
       class="start-btn">Start Course</a>
  </div>

  <!-- Hindi -->
  <div class="course-card">
    <h3>Hindi</h3>
    <a href="start_course.php?course_name=<?= urlencode('Hindi') ?>" 
       class="start-btn">Start Course</a>
  </div>

  <!-- Malayalam -->
  <div class="course-card">
    <h3>Malayalam</h3>
    <a href="start_course.php?course_name=<?= urlencode('Malayalam') ?>" 
       class="start-btn">Start Course</a>
  </div>

  <!-- Gujarati -->
  <div class="course-card">
    <h3>Gujarati</h3>
    <a href="start_course.php?course_name=<?= urlencode('Gujarati') ?>" 
       class="start-btn">Start Course</a>
  </div>

  <!-- Assamese -->
  <div class="course-card">
    <h3>Assamese</h3>
    <a href="start_course.php?course_name=<?= urlencode('Assamese') ?>" 
       class="start-btn">Start Course</a>
  </div>

  <!-- Telugu -->
  <div class="course-card">
    <h3>Telugu</h3>
    <a href="start_course.php?course_name=<?= urlencode('Telugu') ?>" 
       class="start-btn">Start Course</a>
  </div>
</div>

    </div>
  </div>
  
</body>
</html>