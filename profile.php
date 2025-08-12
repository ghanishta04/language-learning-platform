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
  <title>LangLearn - 🧸 My Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(120deg, #fceabb, #f8b500);
      font-family: 'Comic Sans MS', 'Segoe UI', cursive;
      color: #333;
    }

    .container {
      max-width: 900px;
      margin-top: 60px;
    }

    .profile-card {
      background: #fffaf0;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      text-align: center;
      border: 4px dashed #ffb347;
      position: relative;
    }

    .profile-img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border-radius: 50%;
      border: 5px solid #ffd700;
      margin-bottom: 15px;
    }

    .profile-card h3 {
      font-size: 28px;
      color: #e67e22;
    }

    .profile-card p {
      font-size: 18px;
    }

    .btn-settings {
      background-color: #ff69b4;
      border: none;
      font-size: 18px;
      padding: 10px 25px;
      margin-top: 20px;
      border-radius: 10px;
      color: white;
      font-weight: bold;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }

    .btn-settings:hover {
      background-color: #ff1493;
    }

    .back-button {
      position: fixed;
      top: 20px;
      left: 30px;
      z-index: 1000;
    }

    .btn-outline-primary {
      background-color: #ffda77;
      color: #5d4037;
      border-color: #ffda77;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
    }

    .btn-outline-primary:hover {
      background-color: #ffe082;
      color: #4e342e;
    }
  </style>
</head>
<body>

<div class="back-button">
  <a href="dashboard.php" class="btn btn-outline-primary btn-sm">⬅️ Back to Dashboard</a>
</div>

<div class="container">
  <div class="profile-card">
    <div style="font-size: 30px;">👶💬📚</div>
    
    <?php if (!empty($user['profile_pic'])): ?>
      <img src="uploads/<?= htmlspecialchars($user['profile_pic']) ?>" class="profile-img" alt="Profile Picture">
    <?php else: ?>
      <img src="https://via.placeholder.com/140?text=🙂" class="profile-img" alt="No Picture">
    <?php endif; ?>

    <h3><?= htmlspecialchars($user['name']) ?> ✨</h3>
    <p>👤 <strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p>📧 <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p>🕒 <strong>Last Login:</strong> <?= $user['last_login'] ? date("F j, Y", strtotime($user['last_login'])) : "Never" ?></p>

    <a href="settings.php" class="btn-settings">🖍️ Edit Profile</a>
  </div>
</div>

</body>
</html>
