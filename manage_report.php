<?php
// Use the correct path to your database connection file
require_once __DIR__ . '/db.php'; // Adjust the path if needed

// Fetch all reports from the database
$query = "
    SELECT r.id, s.symptom_description, r.additional_info, r.created_at
    FROM reports r
    JOIN symptoms s ON r.symptom_id = s.id
    ORDER BY r.created_at DESC
";

$result = $conn->query($query);
if ($result === false) {
    die('Error fetching reports: ' . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reports</title>
    
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .table-container {
            margin-top: 50px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #343a40;
            color: #fff;
        }
        .no-reports {
            text-align: center;
            font-style: italic;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="table-container">
        <h2 class="text-center">Manage Reports</h2>

        <!-- Back to Dashboard Button -->
        <a href="admin_dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Symptom</th>
                    <th>Additional Information</th>
                    <th>Date Submitted</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['symptom_description']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['additional_info']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='no-reports'>No reports found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
