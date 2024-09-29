<?php
session_start();
include '../db_connection.php';

// Fetch items for preorder
$items = [];
$sql = "SELECT * FROM items"; // Fetch all items
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}

// Handle preorder submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'], $_POST['quantity'])) {
    $user_id = $_SESSION['user_id'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    
    // Insert preorder into the database
    $sql = "INSERT INTO preorders (user_id, item_id, quantity, status) VALUES (?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $user_id, $item_id, $quantity);
    
    if ($stmt->execute()) {
        echo "<p>Preorder created successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="../others/style.css">
</head>
<body>
    <h1>Customer Dashboard</h1>
    
    <nav>
        <ul>
            <li><a href="customerDashboard.php">Home</a></li>
            <li><a href="viewPreorders.php">View Preorders</a></li>
            <li><a href="createReservation.php">Create Reservation</a></li>
            <li><a href="viewReservations.php">View Reservations</a></li>
        </ul>
    </nav>
    
    <h2>Available Items for Preorder</h2>
    <div class="item-list">
        <?php if (!empty($items)): ?>
            <ul>
                <?php foreach ($items as $item): ?>
                    <li>
                        <strong><?= htmlspecialchars($item['item_name']); ?></strong><br>
                        <img src="<?= htmlspecialchars($item['image_path']); ?>" alt="<?= htmlspecialchars($item['item_name']); ?>" width="200"><br>
                        Description: <?= htmlspecialchars($item['description']); ?><br>
                        Price: $<?= number_format($item['price'], 2); ?><br>
                        <form action="customerDashboard.php" method="POST"> <!-- Ensure this points to the correct dashboard -->
                            <input type="hidden" name="item_id" value="<?= $item['id']; ?>">
                            <input type="number" name="quantity" min="1" placeholder="Quantity" required>
                            <button type="submit">Preorder</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No items available for preorder.</p>
        <?php endif; ?>
    </div>
</body>
</html>
