<?php
include('config.php');

// Start a session to store error messages
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_number = strtolower($_POST['table_number']);
    $order_status = strtolower($_POST['order_status']);
    $employee_id = '12345678'; // Assume a static employee ID for this example

    // Calculate the total amount
    $total = 0;

    // Create a new order
    $insertOrderQuery = "INSERT INTO pesanan (no_meja, no_id, total, tanggal, status_pesanan) VALUES (?, ?, ?, NOW(), 'tunggu')";
    $stmt = mysqli_prepare($db, $insertOrderQuery);
    mysqli_stmt_bind_param($stmt, 'sss', $table_number, $employee_id, $total);

    if (mysqli_stmt_execute($stmt)) {
        $order_id = mysqli_insert_id($db); // Get the last inserted order ID

        // Insert each menu item into isi_pesanan
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'jumlah_') === 0 && $value > 0) {
                $menu_id = str_replace('jumlah_', '', $key);
                $quantity = (int)$value;
                $total += calculateMenuTotal($db, $menu_id, $quantity);

                $insertItemQuery = "INSERT INTO isi_pesanan (no_menu, no_pesanan, jumlah) VALUES (?, ?, ?)";
                $itemStmt = mysqli_prepare($db, $insertItemQuery);
                mysqli_stmt_bind_param($itemStmt, 'sss', $menu_id, $order_id, $quantity);
                mysqli_stmt_execute($itemStmt);
            }
        }

        // Update the total in the pesanan table
        $updateTotalQuery = "UPDATE pesanan SET total = ? WHERE no_pesanan = ?";
        $updateStmt = mysqli_prepare($db, $updateTotalQuery);
        mysqli_stmt_bind_param($updateStmt, 'ss', $total, $order_id);
        mysqli_stmt_execute($updateStmt);

        // Optionally, update the table status if necessary
        $updateTableQuery = "UPDATE meja SET status_meja = ? WHERE no_meja = ?";
        $updateTableStmt = mysqli_prepare($db, $updateTableQuery);
        mysqli_stmt_bind_param($updateTableStmt, 'ss', $order_status, $table_number);
        mysqli_stmt_execute($updateTableStmt);

        // Redirect or display a success message
        $_SESSION['success'] = "Order successfully submitted!";
        header('Location: order_success.php');
        exit();
    } else {
        $_SESSION['error'] = "Failed to submit order.";
        header('Location: order_success.php');
        exit();
    }
}

function calculateMenuTotal($db, $menu_id, $quantity) {
    $query = "SELECT harga FROM menu WHERE no_menu = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, 's', $menu_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $price);
    mysqli_stmt_fetch($stmt);
    return $price * $quantity;
}
?>