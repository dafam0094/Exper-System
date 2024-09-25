<?php
session_start();
include('db.php');

$message = '';

// User Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set session variable
            $_SESSION['user'] = $username;
            header("Location: user_dashboard.php"); // Redirect to user dashboard
            exit();
        } else {
            $message = "Invalid password!";
        }
    } else {
        $message = "User does not exist!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for styling -->
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 400px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #343a40;
        }
        .form-label {
            font-weight: 500;
        }
        .form-control {
            border-radius: 5px;
            box-shadow: none;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            font-size: 1rem;
        }
        .alert {
            font-size: 0.9rem;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        .mt-3 a {
            color: #007bff;
            text-decoration: none;
        }
        .mt-3 a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">User Login</h2>

    <!-- Display messages -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="post" action="user_login.php">
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

    <p class="mt-3 text-center">Don't have an account? <a href="register_user.php">Register here</a></p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
