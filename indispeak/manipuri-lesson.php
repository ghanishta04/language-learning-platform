<?php
session_start();
if(!isset($_SESSION['id'])){header("Location: login.php");exit();}
require 'db.php';

$lessonId = $_GET['lesson_id'] ?? null;
$course = "Manipuri";

if(!$lessonId){echo "Lesson ID missing.";exit();}

$stmt = $conn->prepare("SELECT * FROM lesson_flashcards WHERE lesson_id = ?");
$stmt->bind_param("i",$lessonId);
$stmt->execute();
$cards = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title><?= $course ?> Lesson</title>
<style>
body{font-family:Arial;text-align:center;background:#fff4f5;}
.card{margin:80px auto;background:white;width:420px;padding:30px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,0.15);}
button{margin:10px;padding:10px 18px;background:#d12e5c;color:white;border:none;border-radius:8px;cursor:pointer;}
.hidden{display:none;}
</style>
</head>
<body>
<a href="dashboard.php" style="
  position:fixed;
  top:20px;
  left:20px;
  background:#0077aa;
  color:white;
  padding:10px 16px;
  border-radius:8px;
  text-decoration:none;
  font-size:15px;
">
← Back to Dashboard
</a>
<h2><?= $course ?> Lesson Flashcards 🌸</h2>

<div class="card">
  <h3 id="front"></h3>
  <p id="frontHin"></p>
  <hr>
  <h3 id="back" class="hidden"></h3>
  <p id="backHin" class="hidden"></p>

  <button onclick="showBack()">Show Meaning</button>
  <button onclick="nextCard()">Next ➜</button>
</div>

<script>
let data = <?= json_encode($cards) ?>;
let i = 0;

function load(){front.innerText=data[i].front_text;frontHin.innerText=data[i].front_hinglish;back.innerText=data[i].back_text;backHin.innerText=data[i].back_hinglish;back.classList.add("hidden");backHin.classList.add("hidden");}
function showBack(){back.classList.remove("hidden");backHin.classList.remove("hidden");}
function nextCard(){i=(i+1)%data.length;load();}
load();
</script>

</body></html>
