<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $country = $_POST['country'];
    $image = $_FILES['image'];

    // Handle the image upload
    $target_dir = "Uploads/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a valid image
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($image["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            // Insert into database
            $sql = "INSERT INTO items (item_name, description, price, country, image_path) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdss", $item_name, $description, $price, $country, $target_file);

            if ($stmt->execute()) {
                echo "The file ". htmlspecialchars(basename($image["name"])) . " has been uploaded and item added.";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Product</title>
</head>
<body>
    <h1>Upload Product</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="item_name" placeholder="Item Name" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <input type="number" step="0.01" name="price" placeholder="Price" required><br>
        <input type="text" name="country" placeholder="Country" required><br>
        <input type="file" name="image" required><br>
        <button type="submit">Upload Product</button>
    </form>
</body>
</html>
