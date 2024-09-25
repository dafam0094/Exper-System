<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $symptom_id = $_POST['symptom_id'];
    
    $sql = "SELECT diagnosis_description, rule_description 
            FROM diagnosis_rules 
            JOIN diagnoses ON diagnosis_rules.diagnosis_id = diagnoses.id
            WHERE symptom_id = $symptom_id";
    
    $result = $conn->query($sql);

    echo '<div class="container mt-4">';
    if ($result->num_rows > 0) {
        echo '<div class="alert alert-success">';
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>Diagnosis:</strong> " . $row['diagnosis_description'] . "</p>";
            echo "<p><strong>Rule:</strong> " . $row['rule_description'] . "</p><hr>";
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-warning">No diagnosis found for this symptom.</div>';
    }
    echo '</div>';
}
?>

<!-- HTML Form with Bootstrap Styling -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnose</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h2>Select Symptom for Diagnosis</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="symptom_id" class="form-label">Select Symptom:</label>
                            <select name="symptom_id" class="form-select" required>
                                <option value="">Choose a symptom</option>
                                <?php
                                $sql = "SELECT * FROM symptoms";
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['symptom_description']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Diagnose</button>
                    </form>
                    <!-- Back Button -->
                    <a href="javascript:history.back()" class="btn btn-secondary w-100 mt-2">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (optional for interactivity) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
