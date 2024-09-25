<?php
session_start();

// Check if the admin is logged in, if not, redirect to the login page
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include('db.php'); // Include the database connection

// Fetch reports (this example assumes a table named 'reports' exists with relevant fields)
$sql = "SELECT * FROM reports ORDER BY report_date DESC";
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    // Output the error if the query failed
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <style>
        /* Add your CSS styling here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
    </style>
</head>
<body>

<div class="container">
    <h1>System Reports</h1>

    <!-- Reports Table -->
    <table>
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Report Type</th>
                <th>Details</th>
                <th>Report Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display reports if there are any results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['report_type'] . "</td>";
                    echo "<td>" . $row['details'] . "</td>";
                    echo "<td>" . $row['report_date'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No reports found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
