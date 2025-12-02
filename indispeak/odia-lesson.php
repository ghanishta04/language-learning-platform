<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
require 'db.php';

$lessonId = $_GET['lesson_id'] ?? null;
$course = $_GET['course'] ?? 'Odia';

if (!$lessonId) {
    echo "Missing lesson_id.";
    exit();
}

// Fetch flashcards for this lesson
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
  <title>Odia Lesson</title>
  <style>
    body {
      font-family: 'Comic Sans MS', sans-serif;
      background: linear-gradient(to bottom right, #fff8e1, #ffe0b2);
      text-align: center;
      padding: 20px;
    }
    h2 {
      color: #5d4037;
      margin-bottom: 20px;
    }
    .flashcard {
      background: #fff3e0;
      border-radius: 25px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 30px;
      max-width: 400px;
      margin: 0 auto;
      font-size: 24px;
      transition: transform 0.3s ease;
    }
    .flashcard:hover {
      transform: scale(1.02);
    }
    .translation {
      margin-top: 15px;
      font-size: 18px;
      color: #4e342e;
    }
    .controls {
      margin-top: 25px;
    }
    button {
      background-color: #ffb74d;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 20px;
      margin: 5px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    button:hover {
      background-color: #ffa726;
    }
    .back-btn {
      background: #8d6e63;
      color: white;
      text-decoration: none;
      padding: 10px 25px;
      border-radius: 25px;
      display: inline-block;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<h2>Odia Lesson</h2>

<?php if (count($flashcards) > 0): ?>
  <div class="flashcard" id="flashcard">
    <div id="odiaWord"><?= htmlspecialchars($flashcards[0]['front_text']) ?></div>
    <div class="translation" id="translation"><?= htmlspecialchars($flashcards[0]['back_text']) ?></div>
  </div>

  <div class="controls">
    <button onclick="speakWord()">🔊 Speak</button>
    <button onclick="nextCard()">➡ Next</button>
    <button onclick="shuffleCards()">🔀 Shuffle</button>
    <button onclick="markLearned()">✅ Mark as Learned</button>
  </div>

  <a href="lessons.php?course=Odia" class="back-btn">⬅ Back to Lessons</a>

  <script>
    const cards = <?php echo json_encode($flashcards); ?>;
    let index = 0;

    function updateCard() {
      document.getElementById('odiaWord').textContent = cards[index].front_text;
      document.getElementById('translation').textContent = cards[index].back_text;
    }

    function nextCard() {
      index = (index + 1) % cards.length;
      updateCard();
    }

    function shuffleCards() {
      for (let i = cards.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [cards[i], cards[j]] = [cards[j], cards[i]];
      }
      index = 0;
      updateCard();
    }

    function speakWord() {
      const msg = new SpeechSynthesisUtterance(cards[index].front_text);
      msg.lang = "or-IN"; // Odia voice if supported
      window.speechSynthesis.speak(msg);
    }

    function markLearned() {
      alert("Marked as learned ✅");
    }
  </script>

<?php else: ?>
  <p>No flashcards found for this lesson.</p>
  <a href="lessons.php?course=Odia" class="back-btn">⬅ Back</a>
<?php endif; ?>

</body>
</html>
