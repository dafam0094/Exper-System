<?php
// Use the correct path to your database connection file
require_once __DIR__ . '/db.php'; // Adjust this path as needed

// Fetch symptoms from the database
$query = "SELECT id, symptom_description FROM symptoms";
$result = $conn->query($query);
$symptoms = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $symptoms[] = $row;
    }
}

// Handle form submission if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $symptom_id = $_POST['symptom_id'];
    $additional_info = $_POST['additional_info'];

    // Prepare the SQL statement for inserting the report into the database
    $stmt = $conn->prepare("INSERT INTO reports (symptom_id, additional_info) VALUES (?, ?)");

    // Check if prepare() was successful
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind the parameters and execute the statement
    $stmt->bind_param("is", $symptom_id, $additional_info);

    // Execute and check for errors
    if ($stmt->execute()) {
        echo "<script>
                alert('Report submitted successfully!');
                window.location.href = 'user_dashboard.php'; // Redirect after successful submit
              </script>";
    } else {
        echo "<script>alert('Error submitting report: " . $stmt->error . "');</script>";
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report a Problem</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="text-center">Report a Problem</h2>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">

                            <div class="mb-3">
                                <label for="symptom" class="form-label">Select Symptom</label>
                                <select id="symptom" name="symptom_id" class="form-select" required>
                                    <option value="">Choose a symptom</option>
                                    <?php foreach ($symptoms as $symptom): ?>
                                        <option value="<?= $symptom['id'] ?>"><?= htmlspecialchars($symptom['symptom_description']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="additional_info" class="form-label">Additional Information</label>
                                <textarea id="additional_info" name="additional_info" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-2">Submit</button>
                        </form>
                        <!-- Back Button -->
                        <a href="javascript:history.back()" class="btn btn-secondary w-100">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for interactivity like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
