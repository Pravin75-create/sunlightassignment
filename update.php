<?php
include 'db.php';
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $conn->query("UPDATE items SET name='$name', description='$desc' WHERE id=$id");
    header('Location: index.php');
}
$result = $conn->query("SELECT * FROM items WHERE id=$id");
$item = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Item</h1>
    <form method="post">
        <input type="text" name="name" value="<?= $item['name'] ?>" required>
        <textarea name="description"><?= $item['description'] ?></textarea>
        <button type="submit">Update</button>
    </form>
    <a href="index.php">Back</a>
</body>
</html>