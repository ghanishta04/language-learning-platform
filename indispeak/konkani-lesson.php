<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$lessonId = $_GET['lesson_id'] ?? null;
$course = $_GET['course'] ?? 'Konkani';

if (!$lessonId) {
    echo "Lesson not found!";
    exit();
}

// Fetch flashcards for Konkani lesson
$stmt = $conn->prepare("SELECT * FROM lesson_flashcards WHERE lesson_id = ?");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$result = $stmt->get_result();

$flashcards = [];
while ($row = $result->fetch_assoc()) {
    $flashcards[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Konkani Lesson</title>
<style>
body {
    font-family: 'Comic Sans MS', cursive;
    background: linear-gradient(to right, #ffecd2, #fcb69f);
    text-align: center;
    margin: 0;
    padding: 20px;
}
.flashcard {
    background-color: #fff8dc;
    border-radius: 20px;
    padding: 30px;
    margin: 20px auto;
    box-shadow: 0px 6px 12px rgba(0,0,0,0.2);
    width: 300px;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    cursor: pointer;
    transition: transform 0.4s;
}
.flashcard:hover {
    transform: scale(1.05);
}
button {
    margin: 10px;
    padding: 10px 20px;
    background-color: #f4a261;
    border: none;
    border-radius: 10px;
    color: white;
    cursor: pointer;
    transition: 0.3s;
}
button:hover {
    background-color: #e76f51;
}
#speakBtn {
    background-color: #2a9d8f;
}
#speakBtn:hover {
    background-color: #21867a;
}
.back-btn {
    display: inline-block;
    margin-top: 20px;
    background-color: #264653;
}
.back-btn:hover {
    background-color: #1b3a42;
}
</style>
</head>
<body>

<h2>🪸 Konkani Lesson - <?php echo htmlspecialchars($course); ?></h2>

<div class="flashcard" id="flashcard">Click to Flip</div>

<div>
    <button id="prevBtn">Previous</button>
    <button id="nextBtn">Next</button>
    <button id="shuffleBtn">Shuffle</button>
    <button id="learnedBtn">Mark as Learned</button>
    <button id="speakBtn">🔊 Speak</button>
</div>

<a href="lessons.php?course=Konkani" class="back-btn" style="text-decoration:none; color:white; padding:10px 20px;">⬅ Back</a>

<script>
const flashcards = <?php echo json_encode($flashcards); ?>;
let currentIndex = 0;
let showBack = false;

const flashcardDiv = document.getElementById('flashcard');

function updateFlashcard() {
    if (flashcards.length === 0) {
        flashcardDiv.innerText = "No flashcards found.";
        return;
    }
    flashcardDiv.innerText = showBack 
        ? flashcards[currentIndex].back_text 
        : flashcards[currentIndex].front_text;
}

flashcardDiv.addEventListener('click', () => {
    showBack = !showBack;
    updateFlashcard();
});

document.getElementById('nextBtn').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % flashcards.length;
    showBack = false;
    updateFlashcard();
});

document.getElementById('prevBtn').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + flashcards.length) % flashcards.length;
    showBack = false;
    updateFlashcard();
});

document.getElementById('shuffleBtn').addEventListener('click', () => {
    flashcards.sort(() => Math.random() - 0.5);
    currentIndex = 0;
    showBack = false;
    updateFlashcard();
});

document.getElementById('learnedBtn').addEventListener('click', () => {
    alert("✅ Marked as learned!");
});

document.getElementById('speakBtn').addEventListener('click', () => {
    let utter = new SpeechSynthesisUtterance(flashcards[currentIndex].front_text);
    utter.lang = "gom-Latn-IN"; // Konkani language code (Latin script)
    speechSynthesis.speak(utter);
});

updateFlashcard();
</script>
</body>
</html>
