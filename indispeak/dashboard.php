<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "db.php";

$userId = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT username, profile_pic FROM signup WHERE id = $userId");
$user = mysqli_fetch_assoc($query);

$profilePic = (!empty($user['profile_pic'])) ? 'uploads/' . $user['profile_pic'] : 'uploads/default.png';
$username = $user['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Dashboard - Indispeak</title>

<style>
body {
  display: flex;
  margin: 0;
  height: 100vh;
  background: linear-gradient(135deg, #cce6ff, #f0f9ff);
  font-family: "Segoe UI", sans-serif;
  overflow: hidden;
  position: relative;
  animation: fadeIn 0.8s ease-in-out;
}

/* Floating Background Animations */
body::before, body::after {
  content: "";
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  opacity: 0.5;
  z-index: -1;
}
body::before {
  width: 400px;
  height: 400px;
  background: #00acc1;
  top: -100px;
  left: -100px;
  animation: float 6s infinite alternate ease-in-out;
}
body::after {
  width: 350px;
  height: 350px;
  background: #ff8a80;
  bottom: -80px;
  right: -80px;
  animation: float 8s infinite alternate ease-in-out;
}

@keyframes float {
  from { transform: translateY(0px); }
  to { transform: translateY(40px); }
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Sidebar */
.sidebar {
  width: 250px;
  background: linear-gradient(180deg, #007c91, #00acc1);
  padding: 25px 20px;
  color: white;
  display: flex;
  flex-direction: column;
  border-top-right-radius: 18px;
  border-bottom-right-radius: 18px;
  animation: slideSidebar 0.7s ease;
}
.sidebar h2 {
  margin-bottom: 35px;
  text-align: center;
  font-size: 28px;
}
.sidebar a {
  color: white;
  text-decoration: none;
  margin: 14px 0;
  font-size: 18px;
  display: block;
  transition: 0.25s;
}
.sidebar a:hover {
  transform: translateX(8px);
  font-weight: bold;
}
@keyframes slideSidebar {
  from { transform: translateX(-60px); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

/* Main Area */
.main {
  flex-grow: 1;
  padding: 25px 40px;
  overflow-y: auto;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Profile + Buttons */
.profile-section {
  display: flex;
  align-items: center;
  gap: 12px;
}
.profile-img {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid white;
  animation: glowPulse 2s infinite ease-in-out;
}
@keyframes glowPulse {
  0% { box-shadow: 0 0 5px rgba(0,0,0,0.3); }
  50% { box-shadow: 0 0 14px rgba(0,150,200,0.7); }
  100% { box-shadow: 0 0 5px rgba(0,0,0,0.3); }
}

.logout-btn, .dark-toggle {
  padding: 8px 14px;
  border: none;
  border-radius: 20px;
  cursor: pointer;
  transition: 0.3s;
}
.logout-btn {
  background: linear-gradient(90deg, #ff5f6d, #ff1e42);
  color: white;
}
.logout-btn:hover { transform: scale(1.1); }
.dark-toggle {
  background: #004d66; color: white;
}
.dark-toggle:hover { transform: scale(1.15); }

/* Course Cards */
.course-grid {
  margin-top: 30px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 22px;
}
.course-card {
  background: #ffffff;
  border-radius: 18px;
  padding: 22px;
  text-align: center;
  box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
  transition: transform 0.4s, box-shadow 0.4s;
}
.course-card:hover {
  transform: translateY(-10px) scale(1.05);
  box-shadow: 0px 6px 20px rgba(0,0,0,0.25);
}
.start-btn {
  background: linear-gradient(90deg, #007c91, #00acc1);
  color: white;
  padding: 8px 18px;
  border: none;
  border-radius: 25px;
  cursor: pointer;
  transition: 0.3s;
}
.start-btn:hover { transform: scale(1.12); }

/* WORD OF THE DAY */
.word-box {
  background: #ffffff99;
  backdrop-filter: blur(6px);
  padding: 15px 18px;
  margin-top: 15px;
  border-radius: 14px;
  display: inline-block;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  font-size: 18px;
}

/* DARK MODE */
.dark-mode { background: #0f172a !important; color: #e6f6ff !important; }
.dark-mode .main { background: #102132 !important; }
.dark-mode .sidebar { background: linear-gradient(180deg, #033747, #005f6b) !important; }
.dark-mode .course-card { background: #1b2b3a !important; box-shadow: 0px 4px 12px rgba(255,255,255,0.15) !important; }
.dark-mode .word-box { background: #1e293b !important; }
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
  <h2>🌍 Indispeak</h2>

  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="my_courses.php">📘 My Courses</a>
  <a href="profile.php">👤 Profile</a>

  <hr style="border: none; height: 1px; background: rgba(255,255,255,0.4); margin: 14px 0;">

  <a href="quizzes.php">✍️ Quizzes</a>
  <a href="help.php">❓ Help</a>
  <a href="about.php">ℹ️ About</a>

  <hr style="border: none; height: 1px; background: rgba(255,255,255,0.4); margin: 14px 0;">

  <a href="logout.php">🚪 Logout</a>
</div>


<!-- Main Content -->
<div class="main">
  <div class="header">
    <h1>Welcome, <?= htmlspecialchars($username) ?> 👋</h1>
    <div class="profile-section">
      <img src="<?= $profilePic ?>" class="profile-img">
      <button class="dark-toggle" id="darkToggle">🌓</button>
      <form action="logout.php" method="POST">
        <button class="logout-btn" type="submit">Logout</button>
      </form>
    </div>
  </div>

  <h2>✨ Explore Languages</h2>

  <!-- Word of the Day -->
  <div class="word-box" id="wordBox">Word of the Day loading...</div>

 <div class="course-grid">
  <?php 
  $courses = ["Marathi","Hindi","Malayalam","Gujarati","Assamese","Telugu","Odia","Kannada","Konkani","Rajasthani","Manipuri","Bengali"];
  $emojis = ["🙏","🟧","🌴","💠","🌄","🎶","🌾","🌿","🏖️","🏜️","🎭","🐅"];

  foreach($courses as $i=>$c){
    echo "<div class='course-card'>
            <h3>{$emojis[$i]} $c</h3>
            <a href='start_course.php?course=$c' class='start-btn'>Start</a>
          </div>";
  }
  ?>
</div>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
// 🎤 Speak Text Function
function speak(text) {
  const msg = new SpeechSynthesisUtterance(text);
  msg.rate = 1.05;
  msg.pitch = 1.1;
  msg.lang = "en-IN";
  speechSynthesis.speak(msg);
}

// 📅 Word of the Day
const words = [
  {word: "Namaste", meaning: "Hello in (Hindi)"},
  {word: "Vanakkam", meaning: "Hello In  (Tamil)"},
  {word: "Suswagatam", meaning: "Welcome In  (Sanskrit)"},
  {word: "Kem Cho", meaning: "How are you? In (Gujarati)"},
  {word: "Nomoskar", meaning: "Hello In  (Bengali/Assamese)"},
  {word: "Vandanalu", meaning: "Greetings In  (Telugu)"},
  {word: "Sat Sri Akal", meaning: "Hello In  (Punjabi)"}
];

const today = new Date().getDate();
const w = words[today % words.length];
document.getElementById("wordBox").innerHTML = `📚 <b>${w.word}</b> — ${w.meaning}`;

// ✅ Speak welcome only once per user (not every time dashboard loads)
window.onload = function () {
  const username = "<?= htmlspecialchars($username) ?>";
  const userKey = "welcomeSpoken_<?= $userId ?>"; // unique per user

  if (!localStorage.getItem(userKey)) {
    speak(`Welcome ${username}! Let's continue learning together.`);
    localStorage.setItem(userKey, "yes");
  }


  // 🎤 Speak word of the day (always)
  setTimeout(() => {
    speak(`Today's word of the day is ${w.word}. It means, ${w.meaning}.`);
  }, 1200);

  // 🎉 Soft confetti effect on page load
  setTimeout(() => {
    confetti({ particleCount: 90, spread: 65, origin: { y: 0.6 } });
  }, 900);
};

// 🎉 Confetti on Start Button Click
document.querySelectorAll('.start-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    confetti({ particleCount: 140, spread: 80, origin: { y: 0.6 } });
  });
});

// 🌙 Dark Mode Toggle
const toggle = document.getElementById("darkToggle");
if (localStorage.getItem("indispeakMode") === "dark") document.body.classList.add("dark-mode");
toggle.onclick = () => {
  document.body.classList.toggle("dark-mode");
  localStorage.setItem("indispeakMode", document.body.classList.contains("dark-mode") ? "dark" : "light");
};
</script>


</body>
</html>
