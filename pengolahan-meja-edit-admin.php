<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing data
    $query = "SELECT * FROM meja WHERE no_meja = '$id'";
    $result = mysqli_query($db, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $kapasitas = $data['kapasitas'];
    } else {
        echo "<div class='alert alert-danger'>Table not found!</div>";
        exit;
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $kapasitas = $_POST['kapasitas'];

    // Update table record
    $query = "UPDATE meja SET kapasitas = '$kapasitas' WHERE no_meja = '$id'";
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-success'>Table updated successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($db) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Table</h5>
            </div>
            <div class="card-body">
                <form action="pengolahan-meja-edit-admin.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="kapasitas">Kapasitas</label>
                        <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="<?php echo htmlspecialchars($kapasitas); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Meja</button>
                    <a href="pengolahan-meja-admin.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
