<?php
session_start();
include '../db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $quantity = $_POST['quantity'];
        $sql = "UPDATE preorders SET quantity = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $id);
        
        if ($stmt->execute()) {
            echo "Preorder updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        $sql = "SELECT * FROM preorders WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $preorder = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Preorder</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Edit Preorder</h1>
    <form method="POST">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" value="<?= htmlspecialchars($preorder['quantity']); ?>" min="1" required>
        <button type="submit">Update Preorder</button>
    </form>
</body>
</html>
