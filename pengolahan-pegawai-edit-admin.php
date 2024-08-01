<?php
// Include database connection
include 'config.php';

// Check if ID parameter exists in URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to fetch specific pegawai data based on ID
    $query = "SELECT * FROM pegawai WHERE no_id = $id";
    $result = mysqli_query($db, $query);

    // Check if query executed successfully
    if ($result) {
        // Fetch data
        $pegawai = mysqli_fetch_assoc($result);
    } else {
        die('Query failed: ' . mysqli_error($db));
    }
} else {
    die('ID not specified');
}

// Close connection
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-back {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="card shadow">
            <div class="card-header form-header">
                <h4 class="m-0 font-weight-bold text-primary">Edit Pegawai</h4>
            </div>
            <div class="card-body">
                <form action="pengolahan-pegawai-update-admin.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $pegawai['no_id']; ?>">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($pegawai['nama']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" class="form-control" name="no_telp" value="<?php echo htmlspecialchars($pegawai['no_telp']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select class="form-control" name="jabatan" required>
                            <option value="koki" <?php echo ($pegawai['jabatan'] == 'koki') ? 'selected' : ''; ?>>Koki</option>
                            <option value="pelayan" <?php echo ($pegawai['jabatan'] == 'pelayan') ? 'selected' : ''; ?>>Pelayan</option>
                            <option value="kasir" <?php echo ($pegawai['jabatan'] == 'kasir') ? 'selected' : ''; ?>>Kasir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($pegawai['password']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
                </form>
                <a href="pengolahan-pegawai-admin.php" class="btn btn-secondary btn-block btn-back">Kembali</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
