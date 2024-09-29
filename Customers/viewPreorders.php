<?php
session_start();
include '../db_connection.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT p.id, i.item_name, p.quantity, p.status, p.date 
        FROM preorders p 
        JOIN items i ON p.item_id = i.id 
        WHERE p.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Preorders</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Your Preorders</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']); ?></td>
                <td><?= htmlspecialchars($row['item_name']); ?></td>
                <td><?= htmlspecialchars($row['quantity']); ?></td>
                <td><?= htmlspecialchars($row['status']); ?></td>
                <td><?= htmlspecialchars($row['date']); ?></td>
                <td>
                    <a href="editPreorder.php?id=<?= $row['id']; ?>">Edit</a>
                    <a href="deletePreorder.php?id=<?= $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
