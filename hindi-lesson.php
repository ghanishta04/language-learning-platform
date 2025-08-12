<?php
session_start();
include 'db.php';

$lessonId = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;

$cards = [];
if ($lessonId > 0) {
    $stmt = $conn->prepare("SELECT front_text, back_text FROM lesson_flashcards WHERE lesson_id = ?");
    $stmt->bind_param("i", $lessonId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="hi">
<head>
  <meta charset="UTF-8">
  <title>Flashcards</title>
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
    <button onclick="speakCard()">🔊 Speak</button>
    <button onclick="nextCard()">➡️ Next</button>
    <a href="lessons.php?course=hindi"><button>🔙 Back</button></a>
  </div>

  <script>
    const flashcards = <?php echo json_encode($cards, JSON_UNESCAPED_UNICODE); ?>;
    let index = 0;

    function updateCard() {
      document.getElementById('frontText').innerText = flashcards[index].front_text;
      document.getElementById('backText').innerText = flashcards[index].back_text;
    }

    function speakCard() {
      const utter = new SpeechSynthesisUtterance();
      utter.lang = 'hi-IN';
      utter.text = flashcards[index].front_text + ' - ' + flashcards[index].back_text;
      speechSynthesis.speak(utter);
    }

    function nextCard() {
      index = (index + 1) % flashcards.length;
      updateCard();
    }
  </script>
<?php else: ?>
  <h2>No flashcards found for this lesson.</h2>
  <a href="lessons.php?course=hindi"><button>🔙 Back</button></a>
<?php endif; ?>

</body>
</html>
