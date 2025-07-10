<?php
// Run this ONCE to create a user, then delete or comment it out for security!
include 'db.php';
$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);
$conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')");
echo "User created.";
?>
