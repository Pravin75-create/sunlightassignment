<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $conn->query("INSERT INTO items (name, description) VALUES ('$name', '$desc')");
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add New Item</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Name" required>
        <textarea name="description" placeholder="Description"></textarea>
        <button type="submit">Create</button>
    </form>
    <a href="index.php">Back</a>
    <a href="logout.php" class="btn" style="background:#FF6B6B;">Logout</a>
</body>
</html>
