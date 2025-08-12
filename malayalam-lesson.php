<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

require 'db.php'; // include DB connection

$lessonId = $_GET['lesson_id'] ?? null;

if (!$lessonId) {
    echo "Missing lesson_id.";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM lesson_flashcards WHERE lesson_id = ?");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$result = $stmt->get_result();

$flashcards = $result->fetch_all(MYSQLI_ASSOC);

if (empty($flashcards)) {
    echo "No flashcards found for this lesson.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Malayalam Lesson Flashcards</title>
    <style>
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background: #fffbf0;
            padding: 20px;
            text-align: center;
        }
        .card {
            background: #fff8dc;
            padding: 40px;
            border: 5px dotted #ffa500;
            border-radius: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 0 auto;
            position: relative;
            transition: transform 0.4s;
        }
        .card h2 {
            font-size: 30px;
            color: #ff4500;
        }
        .card p {
            font-size: 20px;
            color: #444;
        }
        .controls {
            margin-top: 30px;
        }
        button {
            padding: 12px 25px;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            background: #00bfff;
            color: white;
            cursor: pointer;
            margin: 10px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.2);
            transition: background 0.3s ease;
        }
        button:hover {
            background: #1e90ff;
        }
        .back-btn {
            position: absolute;
            left: 10px;
            top: 10px;
            background: #ff69b4;
            font-size: 16px;
            padding: 8px 15px;
        }
    </style>
</head>
<body>

<a href="lessons.php?course=malayalam" class="back-btn">&larr; Back</a>
<div class="card">
    <h2 id="front"></h2>
    <p id="front_hinglish"></p>
    <hr>
    <h2 id="back" style="display:none;"></h2>
    <p id="back_hinglish" style="display:none;"></p>

    <div class="controls">
        <button onclick="playText('front')">🔈 Front</button>
        <button onclick="playText('back')">🔈 Back</button>
        <button onclick="flipCard()">Flip</button>
        <button onclick="nextCard()">Next</button>
    </div>
</div>

<script>
const flashcards = <?= json_encode($flashcards) ?>;
let current = 0;

function loadCard(index) {
    const card = flashcards[index];
    document.getElementById('front').innerText = card.front_text;
    document.getElementById('front_hinglish').innerText = card.front_hinglish;
    document.getElementById('back').innerText = card.back_text;
    document.getElementById('back_hinglish').innerText = card.back_hinglish;
    document.getElementById('back').style.display = 'none';
    document.getElementById('back_hinglish').style.display = 'none';
}

function flipCard() {
    const back = document.getElementById('back');
    const back_hinglish = document.getElementById('back_hinglish');
    const isVisible = back.style.display === 'block';
    back.style.display = isVisible ? 'none' : 'block';
    back_hinglish.style.display = isVisible ? 'none' : 'block';
}

function nextCard() {
    current = (current + 1) % flashcards.length;
    loadCard(current);
}

function playText(part) {
    let text = '';
    if (part === 'front') {
        text = document.getElementById('front').innerText;
    } else {
        text = document.getElementById('back').innerText;
    }
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'ml-IN';
    speechSynthesis.speak(utterance);
}

// Initial card load
loadCard(current);
</script>

</body>
</html>
