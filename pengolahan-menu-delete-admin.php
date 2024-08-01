<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete menu record
    $query = "DELETE FROM menu WHERE no_menu = '$id'";
    if (mysqli_query($db, $query)) {
        echo "<div class='alert alert-success'>Menu deleted successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($db) . "</div>";
    }

    // Redirect back to the menu admin page
    header("Location: pengolahan-menu-admin.php");
    exit();
}
?>
