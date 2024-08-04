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
    if (!$menu) {
        die("Menu not found.");
    }
} else {
    die("Menu ID is not specified.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($menu['status_menu'] == 'tunda') {
        $nama_menu = $_POST['nama_menu'];
        $harga = $_POST['harga'];
        $update_query = "UPDATE menu SET nama_menu = '$nama_menu', harga = '$harga' WHERE no_menu = '$id'";
    } else {
        $stok = $_POST['stok'];
        $update_query = "UPDATE menu SET stok = '$stok' WHERE no_menu = '$id'";
    }

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
    <title>Edit Menu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Menu</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php if ($menu['status_menu'] == 'tunda') : ?>
                                <div class="form-group">
                                    <label for="nama_menu">Nama Menu</label>
                                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="<?php echo htmlspecialchars($menu['nama_menu']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" value="<?php echo htmlspecialchars($menu['harga']); ?>" required>
                                </div>
                            <?php else : ?>
                                <div class="form-group">
                                    <label for="stok">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok" value="<?php echo htmlspecialchars($menu['stok']); ?>" required>
                                </div>
                            <?php endif; ?>
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
