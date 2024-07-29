<?php
include 'config.php'; // Ensure this is the correct path to your config.php file

if (isset($_POST['no_pesanan']) && isset($_POST['status'])) {
    $no_pesanan = $_POST['no_pesanan'];
    $status = $_POST['status'];

    // Correct the column name in the update query
    $sql = "UPDATE pesanan SET status_pesanan='$status' WHERE no_pesanan='$no_pesanan'";

    if (mysqli_query($db, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($db);
    }

    mysqli_close($db);
}
?>
