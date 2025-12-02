<?php
session_start();
require 'db.php';

// redirect if not logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$userId = intval($_SESSION['id']);

// Fetch username & profile_pic safely
$username = 'Learner';
$profilePic = 'uploads/default.png';
$stmt = $conn->prepare("SELECT username, profile_pic FROM signup WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows) {
        $row = $res->fetch_assoc();
        if (!empty($row['username'])) $username = $row['username'];
        if (!empty($row['profile_pic'])) $profilePic = 'uploads/' . $row['profile_pic'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Help & Support - Indispeak</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<!-- You can replace this with a single stylesheet if you have one -->
<style>
/* basic dashboard-like layout and styling (adapted) */
:root{
  --accent: #00acc1;
  --sidebar: linear-gradient(180deg,#007c91,#00acc1);
  --bg: linear-gradient(135deg,#cce6ff,#f0f9ff);
  --card: rgba(255,255,255,0.95);
  --text: #033047;
}
body { margin:0; font-family: "Poppins", "Segoe UI", Arial, sans-serif; background: var(--bg); color:var(--text); min-height:100vh; display:flex; }
.sidebar {
  width: 250px;
  padding: 28px 18px;
  background: var(--sidebar);
  color: #fff;
  display:flex;
  flex-direction:column;
  gap:10px;
  border-top-right-radius:18px;
  border-bottom-right-radius:18px;
}
.sidebar h2 { margin:0 0 10px 0; font-size:20px; }
.sidebar a { color: #fff; text-decoration:none; margin:8px 0; display:inline-block; font-size:15px; }
.sidebar a.active { font-weight:600; text-decoration:underline; }
.main {
  flex:1;
  padding:32px 40px;
  overflow:auto;
}
.header { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:18px; }
.header h1 { margin:0; font-size:22px; color:#012b35; }
.profile-section { display:flex; align-items:center; gap:12px; }
.profile-img { width:44px; height:44px; border-radius:50%; object-fit:cover; border:3px solid #fff; }

/* help card */
.help-card {
  background: var(--card);
  padding:22px;
  border-radius:14px;
  max-width:900px;
  box-shadow: 0 8px 26px rgba(0,0,0,0.12);
}
.help-card h2 { margin-top:0; color:#004d66; }
.help-card ul { margin:12px 0 0 1.05rem; }
.help-card li { margin:8px 0; color:#135; }

/* back button small */
.back-link { display:inline-block; margin-bottom:12px; padding:8px 14px; background:#fff3fc; color:#c05680; border-radius:10px; text-decoration:none; border:1px solid #ffcde5; }
@media (max-width:780px){
  .sidebar { display:none; }
  body { flex-direction:column; }
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <h2>🌍 Indispeak</h2>
  <a href="dashboard.php">🏠 Dashboard</a>
  <a href="my_courses.php">📘 My Courses</a>
  <a href="quizzes.php">✍️ Quizzes</a>
  <a href="help.php" class="active">❓ Help</a>
  <a href="about.php">ℹ️ About</a>
  <a href="profile.php">👤 Profile</a>
  <a href="logout.php">🚪 Logout</a>
</aside>

<!-- MAIN -->
<main class="main">
  <div class="header">
    <h1>Welcome, <?= htmlspecialchars($username) ?> 👋</h1>
    <div class="profile-section">
      <img src="<?= htmlspecialchars($profilePic) ?>" alt="Profile" class="profile-img">
      <!-- optionally add logout or theme toggle here -->
      <form action="logout.php" method="post" style="margin:0">
        <button type="submit" style="background:#ff5f6d;border:none;color:#fff;padding:8px 12px;border-radius:18px;cursor:pointer">Logout</button>
      </form>
    </div>
  </div>

  

  <section class="help-card" role="region" aria-labelledby="helpTitle">
    <h2 id="helpTitle">❓ Help & Support</h2>

    <p>If you're facing any issues, try the following first:</p>
    <ul>
      <li>🔄 Refresh the page</li>
      <li>🌐 Check your internet connection</li>
      <li>🎤 Allow microphone access if you're using the speak feature</li>
      <li>💻 Try Chrome or Microsoft Edge for best compatibility</li>
      <li>🧹 Clear browser cache/cookies if UI looks broken</li>
    </ul>

    <h3 style="margin-top:18px">Still need help?</h3>
    <p>📧 Email us at: <strong>support@indispeak.com</strong></p>

    <hr style="margin:18px 0;border:none;border-top:1px solid rgba(0,0,0,0.06)">

    <p style="font-size:0.95rem;color:#234">Quick diagnostics</p>
    <ul>
      <li>🧪 Microphone test: open browser site permissions and check mic</li>
      <li>🔈 Audio test: confirm volume and allow autoplay in browser</li>
    </ul>
  </section>
</main>

</body>
</html>
