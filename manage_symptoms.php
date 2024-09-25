<?php
session_start();
include ('db.php');

// Add Symptom
if (isset($_POST['add_symptom'])) {
    $symptom_description = $_POST['symptom_description'];

    if (!empty($symptom_description)) {
        $stmt = $conn->prepare("INSERT INTO symptoms (symptom_description) VALUES (?)");
        $stmt->bind_param("s", $symptom_description);
        if ($stmt->execute()) {
            $message = "Symptom added successfully!";
        } else {
            $message = "Error adding symptom!";
        }
    } else {
        $message = "Please fill in the symptom description.";
    }
}

// Update Symptom
if (isset($_POST['update_symptom'])) {
    $symptom_id = $_POST['symptom_id'];
    $symptom_description = $_POST['symptom_description'];

    if (!empty($symptom_description)) {
        $stmt = $conn->prepare("UPDATE symptoms SET symptom_description=? WHERE id=?");
        $stmt->bind_param("si", $symptom_description, $symptom_id);
        if ($stmt->execute()) {
            $message = "Symptom updated successfully!";
        } else {
            $message = "Error updating symptom!";
        }
    } else {
        $message = "Please fill in the symptom description.";
    }
}

// Delete Symptom
if (isset($_GET['delete'])) {
    $symptom_id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM symptoms WHERE id=?");
    $stmt->bind_param("i", $symptom_id);
    if ($stmt->execute()) {
        $message = "Symptom deleted successfully!";
    } else {
        $message = "Error deleting symptom!";
    }
}

// Fetch All Symptoms
$sql = "SELECT * FROM symptoms";
$symptoms_result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Symptoms</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        table {
            margin-top: 20px;
        }

        .message {
            color: green;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .table-container {
            margin-top: 30px;
        }

        .btn-space {
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="text-center">Manage Symptoms</h2>

         <!-- Back to Dashboard Button -->
         <a href="admin_dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>

        <!-- Display messages -->
        <?php if (isset($message)): ?>
            <p class="message"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Add Symptom Form -->
        <form method="post" action="manage_symptoms.php">
            <div class="mb-3">
                <label for="symptom_description" class="form-label">Add New Symptom:</label>
                <input type="text" class="form-control" name="symptom_description" id="symptom_description" placeholder="Enter symptom" required>
            </div>
            <button type="submit" name="add_symptom" class="btn btn-primary">Add Symptom</button>
        </form>
    </div>

    <!-- Symptoms Table -->
    <div class="table-container">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Symptom Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($symptoms_result->num_rows > 0): ?>
                    <?php while($symptom = $symptoms_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($symptom['id']); ?></td>
                            <td><?= htmlspecialchars($symptom['symptom_description']); ?></td>
                            <td>
                                <!-- Update Symptom Form -->
                                <form method="post" action="manage_symptoms.php" style="display:inline;">
                                    <input type="hidden" name="symptom_id" value="<?= $symptom['id']; ?>">
                                    <input type="text" name="symptom_description" class="form-control d-inline w-50" value="<?= htmlspecialchars($symptom['symptom_description']); ?>">
                                    <button type="submit" name="update_symptom" class="btn btn-success btn-space">Update</button>
                                </form>
                                <!-- Delete Symptom Link -->
                                <a href="manage_symptoms.php?delete=<?= $symptom['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this symptom?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center">No symptoms found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
