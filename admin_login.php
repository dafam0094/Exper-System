<?php
session_start();
include ('db.php'); // Ensure this file contains your database connection

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the password against the stored hashed password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set the session
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $message = "Invalid login credentials!";
        }
    } else {
        $message = "Invalid login credentials!";
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for Styling -->
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            font-size: 1.75rem;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
        .form-control {
            border-radius: 4px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
        }
        .alert {
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>

    <!-- Display Error Message -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="admin_login.php">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>

        <input type="submit" value="Login" class="btn btn-primary">
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
