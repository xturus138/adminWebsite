<?php
include 'config.php'; // Include database connection

if (isset($_GET['id']) && isset($_GET['status'])) {
    $no_pesanan = intval($_GET['id']); // Get the id from the URL
    $status = mysqli_real_escape_string($db, $_GET['status']); // Get the new status from the URL

    // Update the status to the new value
    $query = "UPDATE pesanan SET status = '$status' WHERE no_pesanan = $no_pesanan";
    $result = mysqli_query($db, $query);

    if ($result) {
        // Redirect back to the table page with a success message
        header("Location: pengolahan-pesanan-koki.php?message=Status updated successfully");
    } else {
        // Redirect back with an error message
        header("Location: pengolahan-pesanan-koki.php?message=Error updating status");
    }
} else {
    // Redirect back with an error message if no id or status is set
    header("Location: pengolahan-pesanan-koki.php?message=Invalid request");
}
?>
