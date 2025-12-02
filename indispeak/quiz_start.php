<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$course = $_GET['course'] ?? "Hindi";
$username = $_SESSION['username'] ?? "Learner";


// Sample quiz (you will replace later for each language)
// MULTI-LANGUAGE QUIZZES
switch($course) {

  // HINDI
  case "Hindi":
    $quiz = [
      ["Namaste", "Hello", "Bye", "Thanks", "Hello"],
      ["Shukriya", "Sorry", "Thank You", "Yes", "Thank You"],
      ["Kaise ho?", "How are you?", "Where are you?", "What is this?", "How are you?"],
      ["Aao", "Come", "Go", "Walk", "Come"],
      ["Ruko", "Stop", "Run", "Speak", "Stop"]
    ];
  break;

  // GUJARATI
  case "Gujarati":
    $quiz = [
      ["Kem cho?", "How are you?", "Where are you?", "What is your name?", "How are you?"],
      ["Dhanyavaad", "Sorry", "Thanks", "Please", "Thanks"],
      ["Aavo", "Go", "Walk", "Come", "Come"],
      ["Raho", "Speak", "Stop", "Run", "Stop"],
      ["Saras", "Good", "Bad", "Slow", "Good"]
    ];
  break;

  // TELUGU
  case "Telugu":
    $quiz = [
      ["Namaskaram", "Hello", "Bye", "Yes", "Hello"],
      ["Dhanyavadamulu", "Thank You", "Sorry", "Please", "Thank You"],
      ["Ela unnaru?", "How are you?", "Who are you?", "Where to go?", "How are you?"],
      ["Randi", "Come", "Stop", "Eat", "Come"],
      ["Aapandi", "Stop", "Go", "Speak", "Stop"]
    ];
  break;

  // MARATHI
  case "Marathi":
    $quiz = [
      ["Namaskar", "Hello", "Bye", "Thanks", "Hello"],
      ["Dhanyavaad", "Thank You", "Sorry", "Please", "Thank You"],
      ["Kasa/Kashi Ahesh?", "How are you?", "Where are you?", "What is this?", "How are you?"],
      ["Ya", "Come", "Go", "Walk", "Come"],
      ["Thamba", "Stop", "Run", "Speak", "Stop"]
    ];
  break;

  // PUNJABI
  case "Punjabi":
    $quiz = [
      ["Sat Sri Akal", "Hello", "Goodbye", "Thank You", "Hello"],
      ["Shukriya", "Sorry", "Thank You", "Yes", "Thank You"],
      ["Ki Haal Ae?", "How are you?", "Where are you?", "What is your name?", "How are you?"],
      ["Aao", "Come", "Go", "Sit", "Come"],
      ["Rukho", "Stop", "Run", "Speak", "Stop"]
    ];
  break;

  // DEFAULT IF NO MATCH
  default:
    $quiz = [
      ["Hello", "Hi", "Bye", "Thanks", "Hi"],
      ["Thanks", "Sorry", "Thank You", "Yes", "Thank You"],
      ["How are you?", "Good", "How are you?", "Where are you?", "How are you?"],
      ["Come", "Come", "Go", "Stop", "Come"],
      ["Stop", "Stop", "Speak", "Eat", "Stop"]
    ];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $score = 0;
  foreach ($quiz as $i=>$q) {
    if ($_POST["q$i"] == $q[4]) $score++;
  }

  echo "<script src='https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0'></script>";
  echo "<body style='text-align:center;font-family:Arial;background:#e9f5ff;'>";
  echo "<h1 style='margin-top:50px;'>Your Score: <span style='color:#0077aa;'>$score / 5</span></h1>";
  echo "<p style='font-size:18px;'>$course Quiz Completed 🎉</p>";

  echo "<script>if($score>=3){confetti({particleCount:150,spread:90});}</script>";

  echo "<a href='quizzes.php' style='display:inline-block;margin-top:25px;padding:10px 18px;background:#0077aa;color:white;border-radius:10px;text-decoration:none;'>← Back to Quizzes</a>";
  echo "</body>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $course ?> Quiz | Indispeak</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to right, #d9efff, #e9f5ff);
    display: flex;
}

/* Sidebar */
.sidebar {
    width: 230px;
    background: linear-gradient(180deg, #005c97, #0083b0);
    height: 100vh;
    padding: 20px;
    color: white;
    position: fixed;
}
.sidebar h2 { margin-bottom: 20px; }
.sidebar a {
    display: block; padding: 10px 0; text-decoration: none; color: white; 
    margin: 6px 0; font-size: 16px;
}
.sidebar a:hover {
    background: rgba(255,255,255,0.2);
    border-radius: 6px;
    padding-left: 12px;
    transition: 0.3s;
}

/* Main */
.main {
    margin-left: 260px;
    padding: 40px;
    width: calc(100% - 260px);
}

/* Profile */
.profile-img {
    width: 45px; height: 45px; border-radius: 50%;
    object-fit: cover; position: absolute; right: 25px; top: 20px;
    border: 2px solid #0077aa;
}

/* Quiz Card */
.quiz-card {
  background: #ffffffee;
  padding: 30px;
  border-radius: 16px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.15);
  max-width: 700px;
  margin: auto;
}
.quiz-card hr { margin: 18px 0; }
button {
  padding: 12px 18px; background:#0077aa;
  border:none; border-radius:12px; color:white; cursor:pointer;
}
button:hover { background:#0096c7; transform:scale(1.05); }
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>🌐 Indispeak</h2>
    <a href="dashboard.php">📊 Dashboard</a>
    <a href="my_courses.php">📘 My Courses</a>
    <a href="quizzes.php"><b>📝 Quizzes</b></a>
    <a href="help.php">❓ Help</a>
    <a href="about.php">📖 About</a>
    <a href="profile.php">👤 Profile</a>
    <a href="logout.php">🚪 Logout</a>
</div>



<div class="main">
    <h1><?= $course ?> Quiz 📝</h1>

    <form method="POST" class="quiz-card">
      <?php foreach($quiz as $i=>$q): ?>
        <p><b><?= $q[0] ?></b></p>
        <?php for($x=1;$x<=3;$x++): ?>
          <label><input type="radio" name="q<?= $i ?>" value="<?= $q[$x] ?>" required> <?= $q[$x] ?></label><br>
        <?php endfor; ?>
        <hr>
      <?php endforeach; ?>

      <button>Submit Quiz ✅</button>
    </form>
</div>

</body>
</html>
