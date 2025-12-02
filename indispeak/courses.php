<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Courses</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>
    /* Copy your existing CSS styles here */
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h3>LangLearn</h3>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="courses.php">📘 My Courses</a>
    <a href="profile.php">👤 Profile</a>
    <a href="#">⚙️ Settings</a>
    <a href="home.php">🚪 Logout</a>
  </div>

  <!-- Main Content -->
  <div class="dashboard-container">
    <h2 class="text-center mb-4">📘 Your Courses</h2>

    <div class="row g-4" id="courseList">
      <?php
      $stmt = $conn->query("SELECT * FROM course");
      while ($course = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo '<div class="col-md-6 col-lg-4 course-item" data-level="' . htmlspecialchars($course['level']) . '">';
          echo '  <div class="course-card">';
          echo '    <h6>' . htmlspecialchars($course['title']) . '</h6>';
          echo '    <p>' . htmlspecialchars($course['lessons']) . ' Lessons | ' . htmlspecialchars($course['progress']) . '% Complete</p>';
          echo '    <div class="progress mb-2">';
          echo '      <div class="progress-bar" style="width: ' . htmlspecialchars($course['progress']) . '%"></div>';
          echo '    </div>';
          echo '    <button class="btn btn-start">Start Course</button>';
          echo '  </div>';
          echo '</div>';
      }
      ?>
    </div>
  </div>

  <script>
    // Keep your original JS filtering logic
  </script>
</body>
</html>