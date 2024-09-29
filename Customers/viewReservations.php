<?php
session_start();
include '../db_connection.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM reservations WHERE user_id = ?";
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
    <title>Your Reservations</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Your Reservations</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Table Number</th>
            <th>Reservation Date</th>
            <th>Reservation Time</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']); ?></td>
                <td><?= htmlspecialchars($row['table_number']); ?></td>
                <td><?= htmlspecialchars($row['reservation_date']); ?></td>
                <td><?= htmlspecialchars($row['reservation_time']); ?></td>
                <td><?= htmlspecialchars($row['status']); ?></td>
                <td><?= htmlspecialchars($row['date']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
