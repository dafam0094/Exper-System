<?php
session_start();

// Check if the admin is logged in, if not, redirect to the login page
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Include database connection if needed
include ('db.php'); // Optional if you need to pull any data from the database

// Get the current admin username from the session
$admin_username = $_SESSION['admin'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS for Styling -->
    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #0073e6;
            color: white;
            padding: 15px 0;
            text-align: center;
            border-bottom: 2px solid #005bb5;
        }
        .container {
            margin: 20px auto;
            max-width: 800px;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0073e6;
        }
        a {
            text-decoration: none;
            color: #0073e6;
            font-weight: bold;
        }
        .logout {
            margin-top: 20px;
            display: inline-block;
            background-color: #ff4d4d;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        .logout:hover {
            background-color: #ff3333;
        }
        .dashboard-link {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Welcome to Admin Dashboard</h1>
</div>

<div class="container">
    <h2>Hello, <?php echo htmlspecialchars($admin_username); ?>!</h2>
    <p>Welcome to your admin dashboard. Here, you can manage users, view reports, and perform other administrative tasks.</p>

    <!-- Add dashboard functionalities -->
    <ul class="list-unstyled">
        <li class="dashboard-link"><a href="manage_users.php" class="btn btn-outline-primary btn-block">Manage Users</a></li>
        <li class="dashboard-link"><a href="manage_diagnosis_rules.php" class="btn btn-outline-primary btn-block">Manage Diagnosis Rules</a></li>
        <li class="dashboard-link"><a href="manage_diagnoses.php" class="btn btn-outline-primary btn-block">Manage Diagnoses</a></li>
        <li class="dashboard-link"><a href="manage_symptoms.php" class="btn btn-outline-primary btn-block">Manage Symptoms</a></li>
        <li class="dashboard-link"><a href="manage_report.php" class="btn btn-outline-primary btn-block">Manage Reports</a></li>
        <!-- Add more links as per your project requirements -->
    </ul>

    <!-- Logout Button -->
    <form method="post" action="logout.php">
        <button class="logout" type="submit">Logout</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
