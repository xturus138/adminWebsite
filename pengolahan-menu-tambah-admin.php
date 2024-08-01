<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $status_menu = "setuju"; // Default value

    // Insert new menu record
    $query = "INSERT INTO menu (status_menu, nama_menu, harga) VALUES ('$status_menu', '$nama_menu', '$harga')";
    if (mysqli_query($db, $query)) {
        header("Location: pengolahan-menu-admin.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($db) . "</div>";
    }
}
?>
