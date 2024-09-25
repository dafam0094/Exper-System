<?php
session_start();

// Check if the admin is logged in, if not, redirect to the login page
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include('db.php'); // Include the database connection

// Handle adding a new diagnosis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_diagnosis'])) {
    $diagnosis_description = $_POST['diagnosis_description'];
    if (!empty($diagnosis_description)) {
        $sql = "INSERT INTO diagnoses (diagnosis_description) VALUES ('$diagnosis_description')";
        if ($conn->query($sql) === TRUE) {
            $success_message = "Diagnosis added successfully!";
        } else {
            $error_message = "Error adding diagnosis: " . $conn->error;
        }
    } else {
        $error_message = "Diagnosis description cannot be empty.";
    }
}

// Handle deleting a diagnosis
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM diagnoses WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Diagnosis deleted successfully!";
    } else {
        $error_message = "Error deleting diagnosis: " . $conn->error;
    }
}

// Fetch diagnoses
$sql = "SELECT * FROM diagnoses";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Diagnoses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            margin: 20px auto;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0073e6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #0073e6;
            color: white;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 70%;
        }
        input[type="submit"] {
            padding: 10px 15px;
            background-color: #0073e6;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #005bb5;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Diagnoses</h1>

  <!-- Add Back Button -->
  <a href="admin_dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>
    <!-- Display Success or Error Messages -->
    <?php if (isset($success_message)): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <p class="error"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Add Diagnosis Form -->
    <form method="POST" action="manage_diagnoses.php">
        <input type="text" name="diagnosis_description" placeholder="Enter Diagnosis Description" required>
        <input type="submit" name="add_diagnosis" value="Add Diagnosis">
    </form>

    <!-- Diagnoses Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Diagnosis Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['diagnosis_description']; ?></td>
                        <td>
                            <a href="edit_diagnosis.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="manage_diagnoses.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this diagnosis?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No diagnoses found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
