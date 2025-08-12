<?php
// assamese-lesson.php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$userId = $_SESSION['id'];
$lessonId = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;
$course = 'assamese';

// Fetch the lesson title
$stmt = $conn->prepare("SELECT title FROM lessons WHERE id = ? AND course_name = 'Assamese'");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$result = $stmt->get_result();
$lesson = $result->fetch_assoc();

if (!$lesson) {
    echo "<p>Lesson not found.</p>";
    exit();
}
$title = $lesson['title'];

// Fetch flashcards
$stmt = $conn->prepare("SELECT front_text, front_hinglish, back_text, back_hinglish FROM lesson_flashcards WHERE lesson_id = ?");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$cards = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($title); ?> - Assamese Lesson</title>
  <style>
    body {
      font-family: 'Comic Sans MS', cursive;
      background: #fef7e0;
      text-align: center;
      padding: 20px;
    }
    .flashcard {
      width: 300px;
      height: 200px;
      margin: 30px auto;
      background: #fff7c0;
      border: 4px dashed #ffaa00;
      border-radius: 25px;
      box-shadow: 4px 4px 10px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      transition: transform 0.6s;
      transform-style: preserve-3d;
      cursor: pointer;
    }
    .flashcard.flipped {
      transform: rotateY(180deg);
    }
    .card-face {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-size: 24px;
      padding: 10px;
    }
    .card-front {
      background: #ffe;
    }
    .card-back {
      background: #eef;
      transform: rotateY(180deg);
    }
    .controls {
      margin-top: 20px;
    }
    button {
      font-size: 18px;
      margin: 5px;
      padding: 10px 20px;
      border: none;
      border-radius: 12px;
      background: #ffbb33;
      cursor: pointer;
    }
    audio {
      display: none;
    }
  </style>
</head>
<body>
<h2><?php echo htmlspecialchars($title); ?></h2>
<div id="flashcard" class="flashcard">
  <div class="card-face card-front" id="card-front"></div>
  <div class="card-face card-back" id="card-back"></div>
</div>
<div class="controls">
  <button onclick="playAudio()">🔊 Speak</button>
  <button onclick="nextCard()">Next</button>
  <button onclick="window.location.href='lessons.php?course=assamese'">⬅ Back</button>
</div>
<audio id="tts"></audio>

<script>
const cards = <?php echo json_encode($cards); ?>;
let current = 0;

const cardFront = document.getElementById('card-front');
const cardBack = document.getElementById('card-back');
const flashcard = document.getElementById('flashcard');
const tts = document.getElementById('tts');

function showCard(index) {
  const card = cards[index];
  cardFront.textContent = card.front_text + " (" + card.front_hinglish + ")";
  cardBack.textContent = card.back_text + " (" + card.back_hinglish + ")";
  flashcard.classList.remove('flipped');
}

function nextCard() {
  current = (current + 1) % cards.length;
  showCard(current);
}

flashcard.addEventListener('click', () => {
  flashcard.classList.toggle('flipped');
});

function playAudio() {
  const msg = new SpeechSynthesisUtterance(cards[current].front_text);
  msg.lang = 'as-IN';
  window.speechSynthesis.speak(msg);
}

showCard(current);
</script>
</body>
</html>
