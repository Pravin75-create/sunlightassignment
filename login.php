<?php
session_start();
include 'db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            header('Location: index.php');
            exit();
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Invalid credentials.";
    }
}

// Get current date and time in NZST
date_default_timezone_set('Pacific/Auckland');
$currentDateTime = date('l, F d, Y, h:i A') . ' NZST';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - CRUD App</title>
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
            position: relative;
        }
        .login-card .datetime {
            font-size: 1rem;
            color: #2A5C8B;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        .mountain-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 1.2rem;
            box-shadow: 0 2px 8px rgba(42, 92, 139, 0.10);
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
        .signup-link {
            margin-top: 1.2rem;
            font-size: 1rem;
        }
        .signup-link a {
            color: #2A5C8B;
            font-weight: 600;
            text-decoration: none;
        }
        .signup-link a:hover {
            text-decoration: underline;
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
            .mountain-img {
                width: 60px;
                height: 60px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="datetime"><?= $currentDateTime ?></div>
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80" alt="Mountain" class="mountain-img">
        <h1>Login</h1>
        <?php if ($error): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
        <div class="signup-link">
            Don't have an account?
            <a href="signup.php">Sign Up</a>
        </div>
    </div>
</body>
</html>
