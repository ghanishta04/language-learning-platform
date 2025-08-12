
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Indispeak - Home</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #e0f2f1, #b2ebf2, #80deea);
      background-size: 400% 400%;
      animation: gradientAnimation 15s ease infinite;
    }

    @keyframes gradientAnimation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .navbar {
      background-color: #00acc1;
    }
    .navbar-brand, .nav-link, .btn-primary {
      color: white !important;
    }
    .hero {
      text-align: center;
      padding: 100px 20px;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
      color: #00796b;
      animation: fadeInDown 1.5s ease;
    }
    .hero p {
      font-size: 1.2rem;
      margin-top: 10px;
      animation: fadeInUp 2s ease;
    }
    .cta-btn {
      margin-top: 30px;
      padding: 10px 25px;
      font-size: 1.2rem;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0, 150, 136, 0.4);
    }
    .cta-btn:hover {
      background-color: #004d40;
      transform: scale(1.05);
      box-shadow: 0 6px 14px rgba(0, 77, 64, 0.5);
    }
    .features {
      padding: 50px 20px;
      text-align: center;
    }
    .features .row {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }
    .feature {
      flex: 1 1 300px;
      max-width: 350px;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.85);
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }
    .feature:hover {
      transform: translateY(-10px);
    }
    .feature h3 {
      margin-top: 15px;
      color: #006064;
    }
    footer {
      background-color: #f5f5f5;
    }

    @keyframes fadeInDown {
      0% { opacity: 0; transform: translateY(-30px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(30px); }
      100% { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">Indispeak</a>
      <div class="ms-auto">
        <a href="login.php" class="btn btn-outline-light">Login</a>
        <a href="register.php" class="btn btn-primary ms-2">Sign Up</a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Learn a New Language the Fun Way!</h1>
    <p>Practice daily, earn XP, and become fluent with interactive lessons.</p>
    <a href="dashboard.php" class="btn btn-success cta-btn">Start Learning</a>
  </section>

  <!-- Features -->
  <section class="features">
    <div class="row justify-content-center">
      <div class="feature">
        <img src="https://img.icons8.com/color/96/000000/brainstorm-skill.png" alt="Lessons" />
        <h3>Interactive Lessons</h3>
        <p>Complete bite-sized lessons daily and grow your language skills.</p>
      </div>
      <div class="feature">
        <img src="https://img.icons8.com/color/96/000000/trophy.png" alt="Gamified Learning" />
        <h3>Gamified Learning</h3>
        <p>Earn XP, level up, and maintain your streak like a game!</p>
      </div>
      <div class="feature">
        <img src="https://img.icons8.com/color/96/000000/combo-chart--v1.png" alt="Track Progress" />
        <h3>Progress Tracking</h3>
        <p>Keep track of your lessons, XP, and achievements in real-time.</p>
      </div>
    </div>
  </section>

  <footer class="text-center py-4 bg-light">
    <small>&copy; 2025 LangLearn. All rights reserved.</small>
  </footer>
</body>
</html>