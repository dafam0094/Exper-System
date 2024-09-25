<?php
session_start();
include ('db.php');

// Add Diagnosis Rule
if (isset($_POST['add_diagnosis_rule'])) {
    $symptom_id = $_POST['symptom_id'];
    $diagnosis_id = $_POST['diagnosis_id'];
    $rule_description = $_POST['rule_description'];

    if (!empty($symptom_id) && !empty($diagnosis_id) && !empty($rule_description)) {
        $stmt = $conn->prepare("INSERT INTO diagnosis_rules (symptom_id, diagnosis_id, rule_description) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $symptom_id, $diagnosis_id, $rule_description);
        if ($stmt->execute()) {
            $message = "Diagnosis rule added successfully!";
        } else {
            $message = "Error adding diagnosis rule!";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}

// Update Diagnosis Rule
if (isset($_POST['update_diagnosis_rule'])) {
    $rule_id = $_POST['rule_id'];
    $symptom_id = $_POST['symptom_id'];
    $diagnosis_id = $_POST['diagnosis_id'];
    $rule_description = $_POST['rule_description'];

    if (!empty($symptom_id) && !empty($diagnosis_id) && !empty($rule_description)) {
        $stmt = $conn->prepare("UPDATE diagnosis_rules SET symptom_id=?, diagnosis_id=?, rule_description=? WHERE id=?");
        $stmt->bind_param("iisi", $symptom_id, $diagnosis_id, $rule_description, $rule_id);
        if ($stmt->execute()) {
            $message = "Diagnosis rule updated successfully!";
        } else {
            $message = "Error updating diagnosis rule!";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}

// Delete Diagnosis Rule
if (isset($_GET['delete'])) {
    $rule_id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM diagnosis_rules WHERE id=?");
    $stmt->bind_param("i", $rule_id);
    if ($stmt->execute()) {
        $message = "Diagnosis rule deleted successfully!";
    } else {
        $message = "Error deleting diagnosis rule!";
    }
}

// Fetch All Symptoms
$symptoms_sql = "SELECT * FROM symptoms";
$symptoms_result = $conn->query($symptoms_sql);

// Fetch All Diagnoses
$diagnoses_sql = "SELECT * FROM diagnoses";
$diagnoses_result = $conn->query($diagnoses_sql);

// Fetch All Diagnosis Rules
$rules_sql = "SELECT diagnosis_rules.*, symptoms.symptom_description, diagnoses.diagnosis_description 
              FROM diagnosis_rules 
              JOIN symptoms ON diagnosis_rules.symptom_id = symptoms.id
              JOIN diagnoses ON diagnosis_rules.diagnosis_id = diagnoses.id";
$rules_result = $conn->query($rules_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Diagnosis Rules</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Manage Diagnosis Rules</h2>

    <!-- Add Back Button -->
    <a href="admin_dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

    <!-- Display messages -->
    <?php if (isset($message)): ?>
        <div class="alert alert-info" role="alert"><?= $message; ?></div>
    <?php endif; ?>

    <!-- Add Diagnosis Rule Form -->
    <form method="post" action="manage_diagnosis_rules.php" class="mb-4">
        <div class="mb-3">
            <label for="symptom_id" class="form-label">Select Symptom:</label>
            <select name="symptom_id" id="symptom_id" class="form-select" required>
                <option value="">--Select Symptom--</option>
                <?php while ($symptom = $symptoms_result->fetch_assoc()): ?>
                    <option value="<?= $symptom['id']; ?>"><?= $symptom['symptom_description']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="diagnosis_id" class="form-label">Select Diagnosis:</label>
            <select name="diagnosis_id" id="diagnosis_id" class="form-select" required>
                <option value="">--Select Diagnosis--</option>
                <?php while ($diagnosis = $diagnoses_result->fetch_assoc()): ?>
                    <option value="<?= $diagnosis['id']; ?>"><?= $diagnosis['diagnosis_description']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="rule_description" class="form-label">Rule Description:</label>
            <input type="text" name="rule_description" id="rule_description" class="form-control" placeholder="Enter rule description" required>
        </div>

        <input type="submit" name="add_diagnosis_rule" value="Add Diagnosis Rule" class="btn btn-primary">
    </form>

    <!-- Diagnosis Rules Table -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Symptom</th>
                <th>Diagnosis</th>
                <th>Rule Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($rules_result->num_rows > 0): ?>
                <?php while ($rule = $rules_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $rule['id']; ?></td>
                        <td><?= $rule['symptom_description']; ?></td>
                        <td><?= $rule['diagnosis_description']; ?></td>
                        <td><?= $rule['rule_description']; ?></td>
                        <td>
                            <form method="post" action="manage_diagnosis_rules.php" class="d-inline">
                                <input type="hidden" name="rule_id" value="<?= $rule['id']; ?>">
                                <select name="symptom_id" class="form-select d-inline w-25" required>
                                    <?php
                                    $symptoms_result->data_seek(0); // Reset pointer for re-use
                                    while ($symptom = $symptoms_result->fetch_assoc()): ?>
                                        <option value="<?= $symptom['id']; ?>" <?= $symptom['id'] == $rule['symptom_id'] ? 'selected' : ''; ?>>
                                            <?= $symptom['symptom_description']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <select name="diagnosis_id" class="form-select d-inline w-25" required>
                                    <?php
                                    $diagnoses_result->data_seek(0); // Reset pointer for re-use
                                    while ($diagnosis = $diagnoses_result->fetch_assoc()): ?>
                                        <option value="<?= $diagnosis['id']; ?>" <?= $diagnosis['id'] == $rule['diagnosis_id'] ? 'selected' : ''; ?>>
                                            <?= $diagnosis['diagnosis_description']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                                <input type="text" name="rule_description" class="form-control d-inline w-50" value="<?= $rule['rule_description']; ?>">
                                <input type="submit" name="update_diagnosis_rule" value="Update" class="btn btn-success">
                            </form>

                            <a href="manage_diagnosis_rules.php?delete=<?= $rule['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this rule?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No diagnosis rules found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
  
</div>

<!-- Include Bootstrap JS (Optional, for advanced features) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
