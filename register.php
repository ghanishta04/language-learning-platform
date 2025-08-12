
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = mysqli_query($conn, "SELECT * FROM signup WHERE email='$email' OR username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Username or Email already exists!";
    } else {
        $sql = "INSERT INTO signup (name, username, email, password) VALUES ('$name', '$username', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['id'] = mysqli_insert_id($conn);
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | Langlearn</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
        }

        button {
            width: 100%;
            background-color: #4a90e2;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #357abd;
        }

        .error {
            color: red;
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4a90e2;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Create Your Account</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST" action="">
        <label for="name">Full Name</label>
        <input type="text" name="name" required>

        <label for="username">Username</label>
        <input type="text" name="username" required>

        <label for="email">Email Address</label>
        <input type="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" required>

        <button type="submit">Sign Up</button>
    </form>

    <a class="login-link" href="login.php">Already have an account? Log in</a>
</div>

</body>
</html>