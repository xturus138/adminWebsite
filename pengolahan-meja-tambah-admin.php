<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kapasitas = $_POST['kapasitas'];
    $status_meja = "kosong"; // Default value

    $query = "INSERT INTO meja (status_meja, kapasitas) VALUES ('$status_meja', '$kapasitas')";
    if (mysqli_query($db, $query)) {
        header("Location: pengolahan-meja-admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>
