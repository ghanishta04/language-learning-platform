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

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $profilePic = $user['profile_pic'] ?? ''; // default

  // Handle file upload
  if (!empty($_FILES['profile_pic']['name'])) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $fileName = basename($_FILES['profile_pic']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
      $profilePic = $fileName;
    }
  }

  // Update DB
  $update = mysqli_query($conn, "UPDATE signup SET 
    name = '$name', 
    username = '$username', 
    email = '$email', 
    profile_pic = '$profilePic' 
    WHERE id = $userId");

  if ($update) {
    header("Location: profile.php");
    exit();
  } else {
    echo "Error updating profile.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile - LangLearn</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(120deg, #f9f8ff, #eaf7ff);
      font-family: 'Comic Sans MS', cursive, sans-serif;
    }
    .container {
      max-width: 700px;
      margin-top: 50px;
    }
    .card {
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      background: #fff8f0;
      border: 3px dashed #ffb347;
      position: relative;
    }
    .card h3 {
      font-size: 28px;
      color: #ff6f61;
      text-align: center;
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
      color: #444;
    }
    input.form-control {
      border: 2px solid #ffe29f;
      border-radius: 12px;
      padding: 10px;
      font-size: 16px;
    }
    input.form-control:focus {
      border-color: #f9a826;
      box-shadow: 0 0 10px rgba(255, 168, 0, 0.5);
    }
    .btn-success {
      background: #ff6f61;
      border: none;
      font-size: 18px;
      padding: 12px;
      border-radius: 12px;
    }
    .btn-success:hover {
      background: #ff8a65;
    }
    img.rounded-circle {
      border: 4px solid #ffd54f;
      padding: 4px;
    }
    .back-btn {
      position: fixed;
      top: 20px;
      left: 20px;
      background: #ffd54f;
      border: none;
      padding: 8px 14px;
      border-radius: 10px;
      font-weight: bold;
      color: #444;
      text-decoration: none;
      font-size: 16px;
    }
    .back-btn:hover {
      background: #ffca28;
    }
    .emoji-title {
      font-size: 30px;
    }
  </style>
</head>
<body>

<a href="dashboard.php" class="back-btn">⬅️ Back</a>

<div class="container">
  <div class="card">
    <h3 class="emoji-title">🎨 Edit Your Profile!</h3>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="name" class="form-label">🧑 Full Name</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="username" class="form-label">🎮 Username</label>
        <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">📧 Email ID</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="profile_pic" class="form-label">🖼️ Profile Picture</label><br>
        <?php if (!empty($user['profile_pic'])): ?>
          <img src="uploads/<?= htmlspecialchars($user['profile_pic']) ?>" width="100" class="mb-2 rounded-circle">
        <?php else: ?>
          <img src="https://via.placeholder.com/100" width="100" class="mb-2 rounded-circle">
        <?php endif; ?>
        <input type="file" name="profile_pic" id="profile_pic" class="form-control mt-2">
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-success">✨ Update Profile</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>