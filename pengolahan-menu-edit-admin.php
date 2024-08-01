<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing data
    $query = "SELECT * FROM menu WHERE no_menu = '$id'";
    $result = mysqli_query($db, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $nama_menu = $data['nama_menu'];
        $harga = $data['harga'];
    } else {
        echo "<div class='alert alert-danger'>Menu not found!</div>";
        exit;
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];

    // Update menu record
    $query = "UPDATE menu SET nama_menu = '$nama_menu', harga = '$harga' WHERE no_menu = '$id'";
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-success'>Menu updated successfully!</div>";
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
    <title>Edit Menu</title>
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
                <h5 class="card-title">Edit Menu</h5>
            </div>
            <div class="card-body">
                <form action="edit-menu.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                    <div class="form-group">
                        <label for="nama_menu">Nama Menu</label>
                        <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="<?php echo htmlspecialchars($nama_menu); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($harga); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Menu</button>
                    <a href="pengolahan-menu-admin.php" class="btn btn-secondary">Kembali</a>
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
