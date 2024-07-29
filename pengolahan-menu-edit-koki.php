<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM menu WHERE no_menu = '$id'";
    $result = mysqli_query($db, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($db));
    }

    $menu = mysqli_fetch_assoc($result);
} else {
    die("Menu ID is not specified.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stok = $_POST['stok'];
    $update_query = "UPDATE menu SET stok = '$stok' WHERE no_menu = '$id'";

    if (mysqli_query($db, $update_query)) {
        header("Location: pengolahan-menu-koki.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Stok Menu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Stok Menu</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" value="<?php echo htmlspecialchars($menu['stok']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="pengolahan-menu-koki.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
