<?php
session_start();
include('db.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: user_login.php"); // Redirect to login if not logged in
    exit();
}

// Get user data
$username = $_SESSION['user'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f4f6f9;
        }
        .dashboard-header {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
        }
        .card {
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .card h3 {
            font-weight: 600;
        }
        .card p {
            font-size: 1rem;
            color: #eee;
        }
        .card a {
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .card a:hover {
            background-color: rgba(255, 255, 255, 0.9);
        }
        .btn-danger {
            background-color: #d9534f;
            border-color: #d9534f;
        }
        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="dashboard-header text-center mb-5">Welcome, <?= htmlspecialchars($user['username']); ?>!</h2>

    <div class="row g-4">
        <!-- Report a Problem Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-primary text-white p-4 shadow">
                <h3 class="h5">Report a Problem</h3>
                <p class="mt-2">Report a new computer issue by selecting symptoms.</p>
                <a href="user_report.php" class="mt-3 d-inline-block btn btn-light text-primary">Report Now</a>
            </div>
        </div>

        <!-- View Diagnoses Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card bg-success text-white p-4 shadow">
                <h3 class="h5">View Diagnoses</h3>
                <p class="mt-2">Check the diagnoses you've received based on reported symptoms.</p>
                <a href="diagnose.php" class="mt-3 d-inline-block btn btn-light text-success">View Diagnoses</a>
            </div>
        </div>

    </div>

    <div class="text-center mt-5">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
