<?php
// lessons.php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$userId = $_SESSION['id'];
$course = isset($_GET['course']) ? trim(strtolower($_GET['course'])) : null;

if (!$course) {
    $noCourse = true;
} else {
    $stmt = $conn->prepare("SELECT * FROM lessons WHERE course_name = ? AND level = 'beginner'");
    $stmt->bind_param("s", $course);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $course ? htmlspecialchars(ucfirst($course)) : "No Course" ?> - Lessons</title>
  <style>
    body {
      font-family: 'Comic Sans MS', 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right, #fef5e7, #fce4ec);
      padding: 30px;
      margin: 0;
    }
    h2 {
      font-size: 28px;
      text-align: center;
      color: #5d3a00;
      margin-bottom: 25px;
      text-shadow: 1px 1px #fff;
    }
    .lesson-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }
    .card {
      background: #fff;
      padding: 20px;
      border-radius: 25px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
      position: relative;
      transition: transform 0.2s ease;
      border: 2px solid #e0e0e0;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card h3 {
      font-size: 18px;
      color: #444;
      margin-bottom: 15px;
    }
    .start-btn {
      background-color: #ffda79;
      border: none;
      color: #5d3a00;
      padding: 10px 20px;
      border-radius: 50px;
      font-weight: bold;
      cursor: pointer;
      font-size: 14px;
      margin: 5px;
      transition: background-color 0.3s ease;
      display: inline-block;
      text-decoration: none;
    }
    .start-btn:hover {
      background-color: #ffd54f;
    }
    /* Fun course-specific colors */
    .card.english   { background: #cce5ff; }
    .card.hindi     { background: #ffe0b2; }
    .card.malayalam { background: #c1f7d9ff; }
    .card.gujarati  { background: #e8daef; }
    .card.assamese  { background: #d1f2eb; }
    .card.telugu    { background: #f9978fff; }
    .card a {
      color: #333;
      text-decoration: none;
      font-weight: bold;
    }
    .card a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<a href="dashboard.php" style="display: inline-block; margin-bottom: 20px; background-color: #ffb347; color: white; padding: 10px 20px; border-radius: 25px; text-decoration: none; font-weight: bold; box-shadow: 2px 2px 5px rgba(0,0,0,0.1);">
  ⬅ Back to Dashboard
</a>

<h2><?= htmlspecialchars(ucfirst($course)) ?> - Beginner Lessons</h2>

<?php if (!empty($noCourse)): ?>
  <div>No course selected. Please go back and choose a course.</div>
<?php else: ?>
  <?php if ($result->num_rows > 0): ?>
    <div class="lesson-grid">
      <?php $i=1; foreach($result as $row): ?>
        <?php 
          $lessonLink = match (strtolower($course)) {
            'english' => 'english-lesson.php',
            'hindi' => 'hindi-lesson.php',
            'malayalam' => 'malayalam-lesson.php',
            'gujarati' => 'gujarati-lesson.php',
            'assamese' => 'assamese-lesson.php',
            'telugu' => 'telugu-lesson.php',
            default => 'lesson-detail.php'
          };
        ?>
        <div class="card <?= htmlspecialchars($course) ?>">
          <h3>
            <a href="<?= $lessonLink ?>?lesson_id=<?= $row['id'] ?>&course=<?= urlencode($course) ?>">
              <?= $i++ ?>. <?= htmlspecialchars($row['title']) ?>
            </a>
          </h3>
          <a href="<?= $lessonLink ?>?lesson_id=<?= $row['id'] ?>&course=<?= urlencode($course) ?>" class="start-btn">Start Lesson</a>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p>No beginner lessons found for this course.</p>
  <?php endif; ?>
<?php endif; ?>

</body>
</html>
