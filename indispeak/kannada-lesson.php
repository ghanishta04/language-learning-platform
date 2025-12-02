<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$lessonId = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;
$course = "Kannada";

// Fetch flashcards or lesson content
$stmt = $conn->prepare("SELECT * FROM lesson_flashcards WHERE lesson_id = ?");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$result = $stmt->get_result();
$flashcards = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kannada Lesson</title>
  <style>
    body {
      font-family: 'Comic Sans MS', cursive, sans-serif;
      background: linear-gradient(to bottom right, #f7e8ff, #e1bee7);
      text-align: center;
      padding: 30px;
      margin: 0;
    }
    h2 {
      color: #6a1b9a;
      font-size: 28px;
      margin-bottom: 20px;
    }
    .flashcard {
      background: white;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      width: 300px;
      margin: 0 auto;
      font-size: 22px;
      transition: transform 0.3s;
    }
    .flashcard:hover { transform: scale(1.05); }
    .buttons {
      margin-top: 20px;
    }
    button {
      padding: 10px 20px;
      margin: 5px;
      border: none;
      border-radius: 20px;
      background-color: #ba68c8;
      color: white;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover { background-color: #9c27b0; }
    .back-btn {
      background: #8e24aa;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 25px;
      color: white;
      font-weight: bold;
      display: inline-block;
      margin-top: 30px;
    }
  </style>
</head>
<body>

<h2>Kannada - Lesson <?= $lessonId ?></h2>

<?php if (count($flashcards) > 0): ?>
  <div id="flashcard" class="flashcard">
    <div id="front"><?= htmlspecialchars($flashcards[0]['front_text']) ?></div>
    <div id="back" style="display:none;"><?= htmlspecialchars($flashcards[0]['back_text']) ?></div>
  </div>
  <div class="buttons">
    <button onclick="toggleCard()">Flip</button>
    <button onclick="nextCard()">Next</button>
  </div>
<?php else: ?>
  <p>No flashcards found for this lesson.</p>
<?php endif; ?>

<a href="lessons.php?course=Kannada" class="back-btn">⬅ Back to Lessons</a>

<script>
let cards = <?php echo json_encode($flashcards); ?>;
let current = 0;
let showingFront = true;

function toggleCard() {
  const front = document.getElementById('front');
  const back = document.getElementById('back');
  if (showingFront) {
    front.style.display = 'none';
    back.style.display = 'block';
  } else {
    front.style.display = 'block';
    back.style.display = 'none';
  }
  showingFront = !showingFront;
}

function nextCard() {
  current++;
  if (current >= cards.length) current = 0;
  document.getElementById('front').textContent = cards[current].front_text;
  document.getElementById('back').textContent = cards[current].back_text;
  showingFront = true;
  document.getElementById('front').style.display = 'block';
  document.getElementById('back').style.display = 'none';
}
</script>

</body>
</html>
