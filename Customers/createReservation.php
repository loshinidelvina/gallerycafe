<?php
session_start();
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $table_number = $_POST['table_number'];
    $reservation_date = $_POST['reservation_date'];
    $reservation_time = $_POST['reservation_time'];

    $sql = "INSERT INTO reservations (user_id, table_number, reservation_date, reservation_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $user_id, $table_number, $reservation_date, $reservation_time);
    
    if ($stmt->execute()) {
        echo "Reservation created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Reservation</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Create Reservation</h1>
    <form method="POST">
        <input type="number" name="table_number" placeholder="Table Number" required>
        
        <label for="reservation_date">Reservation Date:</label>
        <input type="date" name="reservation_date" required>
        
        <label for="reservation_time">Reservation Time:</label>
        <input type="time" name="reservation_time" required>
        
        <button type="submit">Create Reservation</button>
    </form>
</body>
</html>
