<?php
session_start();
include('config.php'); // Contains the database connection code

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_number = $_POST['table_number'];
    $order_status = $_POST['order_status'];
    $order_date = $_POST['order_date'];
    $no_id = $_SESSION['login_user']; // Get logged-in user ID from session

    // Fetch the total from isi_pesanan
    $query_total = "SELECT SUM(jumlah) as total FROM isi_pesanan WHERE no_pesanan IN (SELECT no_pesanan FROM pesanan WHERE no_meja = '$table_number' AND status_pesanan != 'kosong')";
    $result_total = mysqli_query($db, $query_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $total = $row_total['total'];

    // Fetch the current status of the table
    $query_status = "SELECT status_meja FROM meja WHERE no_meja = '$table_number'";
    $result_status = mysqli_query($db, $query_status);
    $row_status = mysqli_fetch_assoc($result_status);
    $current_status = $row_status['status_meja'];

    if ($current_status != 'kosong') {
        // Insert new order if the table is not empty
        $query_insert = "INSERT INTO pesanan (no_meja, no_id, total, tanggal, status_pesanan) VALUES ('$table_number', '$no_id', '$total', '$order_date', '$order_status')";
        if (mysqli_query($db, $query_insert)) {
            // Update the table status
            $query_update_table = "UPDATE meja SET status_meja='$order_status' WHERE no_meja='$table_number'";
            if (mysqli_query($db, $query_update_table)) {
                header("Location: reservasi_success.php");
                exit();
            } else {
                echo "Error: " . $query_update_table . "<br>" . mysqli_error($db);
            }
        } else {
            echo "Error: " . $query_insert . "<br>" . mysqli_error($db);
        }
    } else {
        // Update existing order details without changing no_pesanan
        $query_update = "UPDATE pesanan SET no_meja='$table_number', no_id='$no_id', total='$total', tanggal='$order_date', status_pesanan='$order_status' WHERE no_meja='$table_number'";
        if (mysqli_query($db, $query_update)) {
            // Update the table status
            $query_update_table = "UPDATE meja SET status_meja='$order_status' WHERE no_meja='$table_number'";
            if (mysqli_query($db, $query_update_table)) {
                header("Location: reservasi_success.php");
                exit();
            } else {
                echo "Error: " . $query_update_table . "<br>" . mysqli_error($db);
            }
        } else {
            echo "Error: " . $query_update . "<br>" . mysqli_error($db);
        }
    }
}
?>
