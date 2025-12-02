<?php
session_start();
require 'db.php';

// ✅ Ensure user and lesson/course exist
if (!isset($_SESSION['id']) || !isset($_GET['lesson_id']) || !isset($_GET['course'])) {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['id'];
$lessonId = intval($_GET['lesson_id']);
$course_name = trim($_GET['course']);

// ✅ STEP 1: Mark this lesson as completed (if not already)
$check = $conn->prepare("SELECT id FROM completed_lessons WHERE user_id = ? AND lesson_id = ?");
$check->bind_param("ii", $user_id, $lessonId);
$check->execute();
$result = $check->get_result();

if ($result->num_rows === 0) {
    $lesson_title = "Lesson " . $lessonId;
    $insert = $conn->prepare("INSERT INTO completed_lessons (user_id, lesson_id, lesson_title, status) VALUES (?, ?, ?, 'completed')");
    $insert->bind_param("iis", $user_id, $lessonId, $lesson_title);
    $insert->execute();
}

// ✅ STEP 2: Calculate progress for this course
$total_lessons = 10; // ⚙️ adjust based on total Hindi lessons in DB

$count_completed = $conn->prepare("
    SELECT COUNT(*) AS total_completed 
    FROM completed_lessons 
    WHERE user_id = ? AND lesson_title LIKE CONCAT(?, '%')
");
$count_completed->bind_param("is", $user_id, $course_name);
$count_completed->execute();
$total_done = $count_completed->get_result()->fetch_assoc()['total_completed'];

$progress = ($total_done / $total_lessons) * 100;

// ✅ STEP 3: Update user_courses progress
$update = $conn->prepare("UPDATE user_courses SET progress = ? WHERE user_id = ? AND course_name = ?");
$update->bind_param("iis", $progress, $user_id, $course_name);
$update->execute();

// ✅ STEP 4: Fetch flashcards for this lesson
$cards = [];
$stmt = $conn->prepare("SELECT front_text, back_text FROM lesson_flashcards WHERE lesson_id = ?");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $cards[] = $row;
}
?>
<!DOCTYPE html>
<html lang="hi">
<head>
  <meta charset="UTF-8">
  <title>Hindi Lesson Flashcards</title>
  <style>
    body {
      background: #ffe7d6;
      font-family: 'Comic Sans MS', cursive;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px;
    }
    .flashcard {
      background: #fff7c2;
      border: 4px dashed #ffb347;
      border-radius: 20px;
      padding: 30px;
      width: 300px;
      text-align: center;
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    .front, .back {
      font-size: 2rem;
      margin-bottom: 10px;
      color: #333;
    }
    .buttons {
      margin-top: 20px;
    }
    button {
      background: #ffa07a;
      border: none;
      padding: 10px 15px;
      margin: 5px;
      font-size: 16px;
      border-radius: 12px;
      cursor: pointer;
      box-shadow: 2px 2px 5px #999;
    }
    button:hover {
      background: #ff8c66;
    }
  </style>
</head>
<body>

<?php if (count($cards) > 0): ?>
  <div class="flashcard">
    <div class="front" id="frontText"><?php echo htmlspecialchars($cards[0]['front_text']); ?></div>
    <div class="back" id="backText"><?php echo htmlspecialchars($cards[0]['back_text']); ?></div>
  </div>

  <div class="buttons">
    <button onclick="nextCard()">➡️ Next</button>
    <a href="lessons.php?course=<?php echo urlencode($course_name); ?>"><button>🔙 Back</button></a>
  </div>

  <script>
    const flashcards = <?php echo json_encode($cards, JSON_UNESCAPED_UNICODE); ?>;
    let index = 0;

    function updateCard() {
      document.getElementById('frontText').innerText = flashcards[index].front_text;
      document.getElementById('backText').innerText = flashcards[index].back_text;
    }

    function nextCard() {
      index = (index + 1) % flashcards.length;
      updateCard();
    }
  </script>
<?php else: ?>
  <h2>No flashcards found for this lesson.</h2>
  <a href="lessons.php?course=<?php echo urlencode($course_name); ?>"><button>🔙 Back</button></a>
<?php endif; ?>

</body>
</html>
