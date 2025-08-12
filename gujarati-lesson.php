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
    <title>Gujarati Lesson Flashcards</title>
    <style>
      body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, #f9f9f9, #e0f7fa);
    padding: 20px;
    margin: 0;
    text-align: center;
}

.card {
    background: #ffffff;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    max-width: 600px;
    margin: 60px auto 0;
    position: relative;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: scale(1.02);
}

.card h2 {
    font-size: 36px;
    margin-bottom: 10px;
    color: #2c3e50;
}

.card p {
    font-size: 18px;
    color: #555;
}

.controls {
    margin-top: 30px;
}

button {
    padding: 12px 25px;
    border: none;
    border-radius: 8px;
    background: #009688;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin: 8px;
    transition: background 0.2s ease;
}

button:hover {
    background: #00796b;
}

.back-btn {
    position: absolute;
    left: 20px;
    top: 20px;
    background: #7f8c8d;
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    transition: background 0.2s ease;
}

.back-btn:hover {
    background: #616a6b;
}

    </style>
</head>
<body>

<a href="lessons.php?course=gujarati" class="back-btn">&larr; Back</a>
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
    utterance.lang = 'gu-IN';
    speechSynthesis.speak(utterance);
}

// Initial card load
loadCard(current);
</script>

</body>
</html>
