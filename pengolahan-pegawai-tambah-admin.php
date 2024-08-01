<?php
// Include database connection
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $nama = mysqli_real_escape_string($db, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($db, $_POST['no_telp']);
    $jabatan = mysqli_real_escape_string($db, $_POST['jabatan']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // Insert query
    $query = "INSERT INTO pegawai (nama, no_telp, jabatan, password) VALUES ('$nama', '$no_telp', '$jabatan', '$password')";

    if (mysqli_query($db, $query)) {
        // Redirect to pengolahan-pegawai-admin.php upon successful insertion
        header("Location: pengolahan-pegawai-admin.php");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }
}

// Close connection
mysqli_close($db);
?>
