<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['id'];
$lessonId = $_GET['lesson_id'] ?? null;
$course = $_GET['course'] ?? "Assamese";

if (!$lessonId) {
    echo "Lesson ID missing!";
    exit();
}

// Fetch lesson details
$stmt = $conn->prepare("SELECT * FROM lessons WHERE id = ?");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$lesson = $stmt->get_result()->fetch_assoc();

if (!$lesson) {
    echo "Lesson not found!";
    exit();
}

// Fetch flashcards
$flash = $conn->prepare("SELECT * FROM lesson_flashcards WHERE lesson_id = ?");
$flash->bind_param("i", $lessonId);
$flash->execute();
$flashcards = $flash->get_result();

// When marking lesson completed
if (isset($_POST['complete'])) {

    // ✅ Insert into completed lessons
    $mark = $conn->prepare("INSERT IGNORE INTO completed_lessons (user_id, lesson_id) VALUES (?, ?)");
    $mark->bind_param("ii", $user_id, $lessonId);
    $mark->execute();

    // ✅ Update Leaderboard (+10 points per completed lesson)
    $updateScore = $conn->prepare("INSERT INTO leaderboard (user_id, score)
    VALUES (?, 10)
    ON DUPLICATE KEY UPDATE score = score + 10");
    $updateScore->bind_param("i", $user_id);
    $updateScore->execute();

    $message = "✅ Lesson marked as completed! +10 points added to your leaderboard score!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($lesson['title']) ?> - Assamese Lesson</title>
<style>
body {
  font-family: 'Comic Sans MS', 'Segoe UI', sans-serif;
  background: #d1f2eb;
  text-align: center;
  padding: 30px;
}
.flashcard {
  background: white;
  width: 300px;
  margin: 15px auto;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  transition: transform .3s;
  cursor: pointer;
}
.flashcard:hover { transform: scale(1.05); }
.back-btn {
  background: #ffb347;
  padding: 10px 18px;
  border-radius: 20px;
  color: white;
  text-decoration: none;
  font-weight: bold;
}
.complete-btn {
  margin-top:20px;
  padding:10px 20px;
  background:#4CAF50;
  color:white;
  border:none;
  border-radius:10px;
  cursor:pointer;
  font-weight:bold;
}
</style>
<script>
function toggleCard(card) {
    card.classList.toggle("show-back");
}
</script>
</head>
<body>

<a href="lessons.php?course=assamese" class="back-btn">⬅ Back</a>
<h2><?= htmlspecialchars($lesson['title']) ?></h2>

<?php if (!empty($message)): ?>
  <p style="color:green; font-weight:bold;"><?= $message ?></p>
<?php endif; ?>

<?php foreach ($flashcards as $f): ?>
<div class="flashcard" onclick="toggleCard(this)">
  <div class="front"><?= htmlspecialchars($f['front_text']) ?></div>
  <div class="back" style="display:none;"><?= htmlspecialchars($f['back_text']) ?></div>
</div>
<script>
document.querySelectorAll('.flashcard').forEach(card => {
  card.addEventListener('click', () => {
    let front = card.querySelector('.front');
    let back = card.querySelector('.back');
    if (front.style.display === "none") {
        front.style.display = "block";
        back.style.display = "none";
    } else {
        front.style.display = "none";
        back.style.display = "block";
    }
  });
});
</script>
<?php endforeach; ?>

<form method="post">
  <button type="submit" name="complete" class="complete-btn">✅ Mark Lesson Completed</button>
</form>

</body>
</html>
