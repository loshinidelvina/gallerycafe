<?php
session_start();
include '../db_connection.php';

// Fetch all items for selection
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO preorders (user_id, item_id, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $item_id, $quantity);
    
    if ($stmt->execute()) {
        echo "Preorder created successfully!";
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
    <title>Create Preorder</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h1>Create Preorder</h1>
    <form method="POST">
        <label for="item_id">Select Item:</label>
        <select name="item_id" id="item_id" required>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['item_name']); ?> - $<?= number_format($row['price'], 2); ?></option>
            <?php endwhile; ?>
        </select>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" required>

        <button type="submit">Create Preorder</button>
    </form>
</body>
</html>
