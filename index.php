<?php
// Include database connection file
include 'db_connection.php';  // Make sure to create a separate db_connection.php file

// Fetch items based on country
$items = [];
if (isset($_POST['country'])) {
    $selected_country = $_POST['country'];
    $sql = "SELECT * FROM items WHERE country = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selected_country);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to The Gallery Café</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- Link to the CSS file -->
</head>
<body>
    <header>
        <h1>Welcome to The Gallery Café</h1>
        <p>Select your country to view available items:</p>
    </header>

    <!-- Country Selection Form --> 
    <form method="POST" action="index.php">
        <label for="country">Select Country:</label>
        <select name="country" id="country" required>
            <option value="" disabled selected>Select a country</option>
            <option value="Sri Lanka">Sri Lanka</option>
            <option value="Italy">Italy</option>
            <option value="USA">USA</option>
            <option value="Australia">Australia</option>
            <!-- Add more countries as needed -->
        </select>
        <button type="submit">View Items</button>
    </form>

    <hr>

    <!-- Display Items by Selected Country -->
    <?php if (!empty($items)): ?>
        <h2>Items available in <?= htmlspecialchars($selected_country); ?>:</h2>
        <div class="item-list">
            <?php foreach ($items as $item): ?>
                <div class="item">
                    <strong><?= htmlspecialchars($item['item_name']); ?></strong><br>
                    <img src="<?= htmlspecialchars($item['image_path']); ?>" alt="<?= htmlspecialchars($item['item_name']); ?>"><br>
                    Description: <?= htmlspecialchars($item['description']); ?><br>
                    Price: $<?= number_format($item['price'], 2); ?><br>
                    Country: <?= htmlspecialchars($item['country']); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (isset($selected_country)): ?>
        <p>No items found for the selected country.</p>
    <?php endif; ?>

    <hr>

    <footer>
        <p>&copy; 2024 The Gallery Café. All rights reserved.</p>
    </footer>
</body>
</html>
        