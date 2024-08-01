<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete table record
    $query = "DELETE FROM meja WHERE no_meja = '$id'";
    if (mysqli_query($db, $query)) {
        header("Location: pengolahan-meja-admin.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($db);
    }
} else {
    echo "Invalid request!";
}
?>
