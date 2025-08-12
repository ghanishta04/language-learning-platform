<?php
session_start();
include 'db.php';

$lessonId = isset($_GET['lesson_id']) ? intval($_GET['lesson_id']) : 0;

if (!$lessonId) {
    echo "No lesson selected.";
    exit;
}

// Fetch lesson title
$lessonStmt = $conn->prepare("SELECT title FROM lessons WHERE id = ?");
$lessonStmt->bind_param("i", $lessonId);
$lessonStmt->execute();
$lessonResult = $lessonStmt->get_result();
$lesson = $lessonResult->fetch_assoc();
$lessonTitle = $lesson ? $lesson['title'] : "Unknown Lesson";

// Fetch flashcards
$stmt = $conn->prepare("SELECT front_text, back_text FROM lesson_flashcards WHERE lesson_id = ?");
$stmt->bind_param("i", $lessonId);
$stmt->execute();
$result = $stmt->get_result();

$flashcards = [];
while ($row = $result->fetch_assoc()) {
    $flashcards[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($lessonTitle); ?> - Flashcards</title>
    <style>
        body {
            font-family: Comic Sans MS, cursive, sans-serif;
            background-color: #fce4ec;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px;
        }
        h1 {
            color: #d81b60;
        }
        .card-container {
            perspective: 1000px;
            margin-bottom: 20px;
        }
        .flashcard {
            width: 300px;
            height: 200px;
            background-color: #fff;
            border: 5px dashed #ff69b4;
            border-radius: 20px;
            box-shadow: 5px 5px 15px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            font-size: 20px;
            transform-style: preserve-3d;
            transition: transform 0.6s;
            cursor: pointer;
            position: relative;
        }
        .flashcard.flipped {
            transform: rotateY(180deg);
        }
        .flashcard .front, .flashcard .back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            padding: 20px;
            text-align: center;
        }
        .flashcard .back {
            transform: rotateY(180deg);
        }
        .buttons {
            margin-top: 20px;
        }
        button {
            margin: 5px;
            padding: 10px 15px;
            font-size: 16px;
            border: none;
            border-radius: 12px;
            background-color: #ffb6c1;
            cursor: pointer;
        }
        button:hover {
            background-color: #f06292;
        }
    </style>
</head>
<body>

    <h1>🎉 <?php echo htmlspecialchars($lessonTitle); ?> 🎉</h1>

    <div class="card-container">
        <div class="flashcard" id="flashcard">
            <div class="front" id="front"></div>
            <div class="back" id="back"></div>
        </div>
    </div>

    <div class="buttons">
        <button onclick="speak()">🔊 Speak</button>
        <button onclick="flipCard()">🔁 Flip</button>
        <button onclick="nextCard()">➡️ Next</button>
        <button onclick="shuffleCards()">🔀 Shuffle</button>
        <button onclick="markLearned()">✅ Mark as Learned</button>
    </div>

    <script>
        const flashcards = <?php echo json_encode($flashcards); ?>;
        let current = 0;

        const frontDiv = document.getElementById("front");
        const backDiv = document.getElementById("back");
        const card = document.getElementById("flashcard");

        function showCard(index) {
            if (flashcards.length === 0) {
                frontDiv.innerHTML = "No Flashcards";
                backDiv.innerHTML = "Please add some!";
                return;
            }
            const cardData = flashcards[index];
            frontDiv.innerHTML = `<strong>${cardData.front_text}</strong>`;
            backDiv.innerHTML = `<strong>${cardData.back_text}</strong>`;
            card.classList.remove("flipped");
        }

        function flipCard() {
            card.classList.toggle("flipped");
        }

        function nextCard() {
            current = (current + 1) % flashcards.length;
            showCard(current);
        }

        function shuffleCards() {
            for (let i = flashcards.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [flashcards[i], flashcards[j]] = [flashcards[j], flashcards[i]];
            }
            current = 0;
            showCard(current);
        }

        function speak() {
            let text = card.classList.contains("flipped")
                ? flashcards[current].back_text
                : flashcards[current].front_text;
            const utter = new SpeechSynthesisUtterance(text);
            speechSynthesis.speak(utter);
        }

        function markLearned() {
            alert("Marked as learned! 🎉");
        }

        // Initial card
        showCard(current);
    </script>

    <div style="margin-top: 30px;">
        <a href="lessons.php?course=telugu">
            <button style="
                background-color: #ffcccb;
                color: black;
                font-family: Comic Sans MS;
                font-size: 16px;
                border: 2px solid #f06292;
                border-radius: 12px;
                padding: 10px 20px;
                cursor: pointer;
            ">⬅️ Back to Lessons</button>
        </a>
    </div>

</body>
</html>