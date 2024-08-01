<?php
// Include database connection
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user input for security
    $id = mysqli_real_escape_string($db, $_POST['id']);

    // Delete query
    $query = "DELETE FROM pegawai WHERE no_id = $id";

    if (mysqli_query($db, $query)) {
        // Redirect to pengolahan-pegawai-admin.php upon successful deletion
        header("Location: pengolahan-pegawai-admin.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($db);
    }
}

// Close connection
mysqli_close($db);
?>
