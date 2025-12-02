<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

$userId = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM signup WHERE id = $userId");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>LangLearn - Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root {
  --bg: #fff2f8;
  --text: #333;
  --card-bg: #ffffff;
  --accent: #ff7bac;
  --soft-shadow: rgba(0,0,0,0.15);
}

/* Soft Dark Mode */
body.dark {
  --bg: #2a2a2a;
  --text: #f4f4f4;
  --card-bg: #3a3a3a;
  --accent: #ff9dc8;
  --soft-shadow: rgba(0,0,0,0.4);
}

body {
  background: var(--bg);
  font-family: "Poppins", sans-serif;
  color: var(--text);
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.4s background, 0.4s color;
  padding: 30px;
}

/* Dark Mode Toggle */
.theme-btn {
  position: fixed;
  top: 20px;
  right: 20px;
  background: var(--accent);
  border: none;
  padding: 10px 16px;
  border-radius: 50px;
  cursor: pointer;
  font-size: 18px;
  color: white;
  transition: 0.3s;
  box-shadow: 0px 6px 15px var(--soft-shadow);
}
.theme-btn:hover { transform: scale(1.12); }

.profile-card {
  background: var(--card-bg);
  border-radius: 22px;
  padding: 45px 38px;
  text-align: center;
  width: 600px;
  box-shadow: 0 12px 40px var(--soft-shadow);
  border: 2px solid var(--accent);
  transition: 0.3s transform, 0.4s background;
}
.profile-card:hover { transform: translateY(-6px); }

.profile-img {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  border: 5px solid var(--accent);
  box-shadow: 0 0 15px var(--accent);
  margin-bottom: 20px;
}

h3 { font-weight: 700; font-size: 27px; color: var(--accent); margin-bottom: 10px; }

p { font-size: 16px; margin: 5px 0; }

.edit-btn {
  background: var(--accent);
  border: none;
  padding: 12px 28px;
  border-radius: 12px;
  font-size: 17px;
  font-weight: 600;
  color: white;
  transition: 0.3s;
  box-shadow: 0 8px 18px rgba(0,0,0,0.2);
}
.edit-btn:hover { transform: scale(1.07); }

.back-button a {
  background: transparent;
  border: 2px solid var(--accent);
  padding: 8px 16px;
  border-radius: 10px;
  text-decoration: none;
  color: var(--accent);
  font-weight: 600;
  position: absolute;
  top: 25px;
  left: 25px;
  transition: 0.3s;
}
.back-button a:hover { background: var(--accent); color: white; }
</style>
</head>
<body>

<button id="darkModeToggle" class="theme-btn">🌙</button>

<div class="back-button">
  <a href="dashboard.php">⬅ Back</a>
</div>

<div class="profile-card">

  <?php if (!empty($user['profile_pic'])): ?>
    <img src="uploads/<?= htmlspecialchars($user['profile_pic']) ?>" class="profile-img">
  <?php else: ?>
    <img src="https://via.placeholder.com/150?text=🙂" class="profile-img">
  <?php endif; ?>

  <h3><?= htmlspecialchars($user['name']) ?> ✨</h3>
  <p><strong>@<?= htmlspecialchars($user['username']) ?></strong></p>
  <p>📧 <?= htmlspecialchars($user['email']) ?></p>
  <p>🕒 Last Login: <?= $user['last_login'] ? date("F j, Y", strtotime($user['last_login'])) : "Never" ?></p>

  <a href="settings.php" class="edit-btn">Edit Profile ✏️</a>
</div>

<script>
// Load mode
if(localStorage.getItem("theme") === "dark"){
  document.body.classList.add("dark");
  document.getElementById("darkModeToggle").textContent = "☀️";
}

document.getElementById("darkModeToggle").onclick = () => {
  document.body.classList.toggle("dark");
  if(document.body.classList.contains("dark")){
    localStorage.setItem("theme","dark");
    darkModeToggle.textContent = "☀️";
  } else {
    localStorage.setItem("theme","light");
    darkModeToggle.textContent = "🌙";
  }
};
</script>

</body>
</html>
