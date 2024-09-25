<?php
session_start();
include ('db.php');

$message = '';

// User Registration
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate input
    if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            // Hash password for security
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Check if username or email already exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                // Insert new user into the database
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $email, $hashed_password);
                
                if ($stmt->execute()) {
                    $message = "Registration successful!";
                } else {
                    $message = "Error during registration!";
                }
            } else {
                $message = "Username or email already exists!";
            }
        } else {
            $message = "Passwords do not match!";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>

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
        .registration-container {
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

<div class="registration-container">
    <h2>Register User</h2>

    <!-- Display messages -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info" role="alert"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form method="post" action="register_user.php">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
        </div>

        <input type="submit" value="Register" class="btn btn-primary">
    </form>

    <p class="mt-3">Already have an account? <a href="user_login.php">Login here</a></p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
