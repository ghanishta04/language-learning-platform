<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// ✅ Correct query: fetch all courses the logged-in user is learning
$stmt = $conn->prepare("
    SELECT id, course_name, progress 
    FROM user_courses 
    WHERE user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LangLearn - My Courses</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right top, #e3f2fd, #bbdefb, #90caf9);
      min-height: 100vh;
      display: flex;
    }
    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom, #00acc1, #007c91);
      color: white;
      padding: 30px 20px;
      min-height: 100vh;
    }
    .sidebar h3 {
      font-weight: bold;
      margin-bottom: 30px;
    }
    .sidebar a {
      color: white;
      display: block;
      margin: 15px 0;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s;
    }
    .sidebar a:hover {
      color: #ffd54f;
    }
    .dashboard-container {
      flex: 1;
      padding: 40px;
    }
    h2 {
      font-weight: bold;
      color: #004d61;
    }
    .filter-search {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-bottom: 30px;
    }
    .filter-search input, .filter-search select {
      padding: 8px 12px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-bottom: 10px;
      width: 100%;
      max-width: 250px;
    }
    .course-card {
      border-radius: 20px;
      padding: 25px;
      background: linear-gradient(135deg, #ffffff, #e3f2fd);
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .course-card:hover {
      transform: scale(1.03);
      box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .course-card h6 {
      font-weight: bold;
      color: #007c91;
      margin-bottom: 10px;
    }
    .course-card p {
      color: #555;
    }
    .active-course {
      border: 2px solid #00acc1;
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <h3>Indispeak</h3>
    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="my_courses.php">📘 My Courses</a>
    <a href="profile.php">👤 Profile</a>
    
    <a href="logout.php">🚪 Logout</a>
  </div>

  <!-- Main Courses Content -->
  <div class="dashboard-container">
    <h2 class="text-center mb-4">📘 Your Courses</h2>

    <div class="filter-search mb-4">
      <input type="text" id="searchInput" placeholder="Search courses..." class="form-control">
      <select id="filterSelect" class="form-control">
        <option value="all">All Levels</option>
        <option value="beginner">Beginner</option>
        <option value="intermediate">Intermediate</option>
        <option value="advanced">Advanced</option>
      </select>
    </div>

    <div class="row g-4" id="courseList">
      <?php
      if ($result->num_rows > 0) {
          $current_course_id_from_session = $_SESSION['current_course_id'] ?? null;
          while ($row = $result->fetch_assoc()) {
              $is_current = ($row['course_name'] == $current_course_id_from_session) ? 'active-course' : '';
              $badge = ($row['course_name'] == $current_course_id_from_session) ? '<span class="badge bg-success">Current</span>' : '';
      ?>
        <div class="col-md-6 col-lg-4 course-item" data-level="beginner">
          <div class="course-card <?= $is_current ?>">
            <h6><?= ucfirst(htmlspecialchars($row['course_name'])) ?> <?= $badge ?></h6>
          </div>
        </div>
      <?php
          }
      } else {
          echo '<p class="text-center">😕 You have not started any courses yet!</p>';
      }
      ?>
    </div>
  </div>

  <script>
    const searchInput = document.getElementById("searchInput");
    const filterSelect = document.getElementById("filterSelect");
    const courseItems = document.querySelectorAll(".course-item");

    function filterCourses() {
      const searchText = searchInput.value.toLowerCase();
      const levelFilter = filterSelect.value;

      courseItems.forEach(item => {
        const title = item.querySelector("h6").textContent.toLowerCase();
        const level = item.dataset.level;
        const matchesSearch = title.includes(searchText);
        const matchesFilter = levelFilter === "all" || level === levelFilter;
        item.style.display = (matchesSearch && matchesFilter) ? "block" : "none";
      });
    }

    searchInput.addEventListener("input", filterCourses);
    filterSelect.addEventListener("change", filterCourses);
  </script>
</body>
</html>
