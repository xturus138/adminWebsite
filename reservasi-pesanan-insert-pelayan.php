<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table_number = $_POST['table_number'];
    $order_status = $_POST['order_status'];
    $order_date = $_POST['order_date'];
    $no_id = $_SESSION['login_user'];  // Get the logged-in user ID

    // Update table status regardless of the order status
    $update_table_status_query = "UPDATE meja SET status_meja='tunggu' WHERE no_meja='$table_number'";
    mysqli_query($db, $update_table_status_query);

    if ($order_status != 'kosong') {
        // Calculate total from isi_pesanan
        $total_query = "SELECT SUM(jumlah) AS total FROM isi_pesanan WHERE no_pesanan IN (SELECT no_pesanan FROM pesanan WHERE no_meja = '$table_number')";
        $total_result = mysqli_query($db, $total_query);
        $total_row = mysqli_fetch_assoc($total_result);
        $total = $total_row['total'] ? $total_row['total'] : 0;

        // Check if there's an existing order for the table with a non-kosong status
        $order_query = "SELECT no_pesanan FROM pesanan WHERE no_meja='$table_number' AND status_pesanan != 'kosong'";
        $order_result = mysqli_query($db, $order_query);
        $order_row = mysqli_fetch_assoc($order_result);

        if ($order_row) {
            // Update existing order
            $no_pesanan = $order_row['no_pesanan'];
            $update_order_query = "UPDATE pesanan SET no_id='$no_id', total='$total', tanggal='$order_date', status_pesanan='$order_status' WHERE no_pesanan='$no_pesanan'";
            mysqli_query($db, $update_order_query);
        } else {
            // Insert new order
            $insert_order_query = "INSERT INTO pesanan (no_meja, no_id, total, tanggal, status_pesanan) VALUES ('$table_number', '$no_id', '$total', '$order_date', '$order_status')";
            mysqli_query($db, $insert_order_query);
        }
    }

    // Redirect to reservation success page
    header("Location: reservasi_success.php");
    exit();
}
?>
