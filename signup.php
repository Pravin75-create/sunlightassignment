<?php
session_start();
include 'db.php';

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($conn->real_escape_string($_POST['username']));
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($username) < 3 || strlen($password) < 4) {
        $error = "Username or password too short.";
    } else {
        $exists = $conn->query("SELECT id FROM users WHERE username='$username'");
        if ($exists && $exists->num_rows > 0) {
            $error = "Username already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO users (username, password) VALUES ('$username', '$hash')");
            $success = "Registration successful! <a href='login.php'>Login here</a>.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - CRUD App</title>
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(120deg, #2A5C8B 0%, #6EC6CA 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .login-card {
            background: #fff;
            padding: 2.5rem 2rem 2rem 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(42, 92, 139, 0.15);
            width: 350px;
            text-align: center;
            animation: fadeIn 1s;
        }
        .login-card h1 {
            margin-bottom: 1.5rem;
            color: #2A5C8B;
            font-size: 2rem;
            font-weight: 700;
        }
        .login-card form {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }
        .login-card input[type="text"],
        .login-card input[type="password"] {
            padding: 0.75rem 1rem;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }
        .login-card input:focus {
            border-color: #2A5C8B;
            outline: none;
        }
        .login-card button {
            background: #2A5C8B;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .login-card button:hover {
            background: #174060;
        }
        .error-message {
            color: #ff6b6b;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        .success-message {
            color: #2A5C8B;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        @media (max-width: 400px) {
            .login-card {
                width: 95vw;
                padding: 1.5rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Sign Up</h1>
        <?php if ($error): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?= $success ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <div style="margin-top:1rem;">
            Already have an account? <a href="login.php" style="color:#2A5C8B;font-weight:600;">Login</a>
        </div>
    </div>
</body>
</html>
