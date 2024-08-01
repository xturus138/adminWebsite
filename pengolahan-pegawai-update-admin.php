<?php
// Include database connection
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $id = mysqli_real_escape_string($db, $_POST['id']);
    $nama = mysqli_real_escape_string($db, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($db, $_POST['no_telp']);
    $jabatan = mysqli_real_escape_string($db, $_POST['jabatan']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Update query
    $query = "UPDATE pegawai SET 
              nama = '$nama', 
              no_telp = '$no_telp', 
              jabatan = '$jabatan', 
              password = '$password' 
              WHERE no_id = $id";

    if (mysqli_query($db, $query)) {
        // Redirect to pengolahan-pegawai-admin.php upon successful update
        header("Location: pengolahan-pegawai-admin.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($db);
    }
}

// Close connection
mysqli_close($db);
?>
