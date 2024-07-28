<?php
session_start();
include('config.php'); // Contains the database connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $no_id = $_POST['no_id'];
    $password = $_POST['password'];

    // Check database for credentials
    $sql = "SELECT no_id FROM pegawai WHERE no_id = '$no_id' and password = '$password'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    // If result matched $no_id and $password, table row must be 1 row
    if ($count == 1) {
        $_SESSION['login_user'] = $no_id;
        header("location: index.html");
    } else {
        echo "Your Login ID or Password is invalid";
    }
}
?>
