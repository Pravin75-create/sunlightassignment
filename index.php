<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - CRUD App</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(120deg, #2A5C8B 0%, #6EC6CA 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            background: #fff;
            margin-top: 4rem;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(42, 92, 139, 0.15);
            padding: 2.5rem 2rem 2rem 2rem;
            width: 95vw;
            max-width: 800px;
            animation: fadeIn 1s;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        .top-bar h1 {
            color: #2A5C8B;
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }
        .btn, button {
            background: #2A5C8B;
            color: #fff;
            padding: 0.5rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
            margin-left: 0.5rem;
        }
        .btn.logout {
            background: #ff6b6b;
        }
        .btn:hover, button:hover {
            background: #174060;
        }
        .btn.logout:hover {
            background: #c0392b;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
            background: transparent;
        }
        th, td {
            padding: 0.9rem 1rem;
            background: #f5f9fc;
            border-radius: 8px;
            text-align: left;
            font-size: 1rem;
        }
        th {
            background: #e3edf7;
            color: #2A5C8B;
            font-weight: 700;
            border-bottom: 2px solid #b0bec5;
        }
        td.actions a {
            margin-right: 0.7rem;
            color: #2A5C8B;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        td.actions a:last-child {
            margin-right: 0;
            color: #ff6b6b;
        }
        td.actions a:hover {
            text-decoration: underline;
        }
        @media (max-width: 600px) {
            .container {
                padding: 1rem 0.3rem;
            }
            th, td {
                padding: 0.6rem 0.4rem;
                font-size: 0.95rem;
            }
            .top-bar h1 {
                font-size: 1.3rem;
            }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-30px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <h1>Welcome, <?= htmlspecialchars($_SESSION['user']) ?></h1>
            <div>
                <a href="create.php" class="btn">+ Add New Item</a>
                <a href="logout.php" class="btn logout">Logout</a>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="min-width:110px;">Actions</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM items");
                if ($result && $result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td class="actions">
                        <a href="update.php?id=<?= $row['id'] ?>">Edit</a>
                        <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this item?');">Delete</a>
                    </td>
                </tr>
                <?php
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="4" style="text-align:center; color:#b0bec5;">No items found.</td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
