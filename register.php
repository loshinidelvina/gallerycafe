<?php
// Include the database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Registration process
    $reg_username = $_POST['reg_username'];
    $reg_email = $_POST['reg_email'];
    $reg_password = password_hash($_POST['reg_password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, user_type) VALUES ('$reg_username', '$reg_email', '$reg_password', 'customer')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful! You can now log in.";
        // Optionally redirect to the login page after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST">
        <input type="text" name="reg_username" placeholder="Username" required>
        <input type="email" name="reg_email" placeholder="Email" required>
        <input type="password" name="reg_password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
