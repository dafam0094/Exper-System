<?php
// admin_registration.php

// Include your database connection here
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing

    // Check if the username or email already exists
    $sql_check = "SELECT * FROM admin WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username or email already exists!";
    } else {
        // Insert the new admin into the database
        $sql_insert = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param('sss', $username, $email, $password);

        if ($stmt->execute()) {
            echo "Admin registered successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #0073e6;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            margin-top: 20px;
            background-color: #0073e6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #005bb5;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Registration</h2>
    <form action="admin_registration.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Register Admin</button>
    </form>
</div>

</body>
</html>
