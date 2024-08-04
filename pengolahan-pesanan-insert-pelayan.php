<?php
include('config.php');
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_number = strtolower($_POST['table_number']);
    
    // Get the employee id from the session
    if (isset($_SESSION['login_user'])) {
        $employee_id = $_SESSION['login_user'];
    } else {
        // Handle the error if no_id is not set
        $_SESSION['error'] = "Employee ID not found. Please log in.";
        header('Location: login_form.php'); // Redirect to login page
        exit();
    }

    // Calculate the total amount
    $total = 0;

    // Check if any menu item is selected
    $orderIsEmpty = true;

    // Iterate over POST data to check if there is any non-zero quantity
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'jumlah_') === 0 && $value > 0) {
            $orderIsEmpty = false;
            break;
        }
    }

    if ($orderIsEmpty) {
        $_SESSION['error'] = "No menu items selected. Please select at least one menu item.";
        header('Location: pengolahan-pesanan-pelayan.php');
        exit();
    }

    // Check the current status of the table
    $checkTableStatusQuery = "SELECT status_meja FROM meja WHERE no_meja = ?";
    $checkTableStatusStmt = mysqli_prepare($db, $checkTableStatusQuery);
    mysqli_stmt_bind_param($checkTableStatusStmt, 's', $table_number);
    mysqli_stmt_execute($checkTableStatusStmt);
    mysqli_stmt_bind_result($checkTableStatusStmt, $current_status);
    mysqli_stmt_fetch($checkTableStatusStmt);
    mysqli_stmt_close($checkTableStatusStmt);

    // If the table status is "kosong", create a new order
    if ($current_status === "kosong") {
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

                    // Reduce the stock in the menu table
                    $updateStockQuery = "UPDATE menu SET stok = stok - ? WHERE no_menu = ?";
                    $updateStockStmt = mysqli_prepare($db, $updateStockQuery);
                    mysqli_stmt_bind_param($updateStockStmt, 'is', $quantity, $menu_id);
                    mysqli_stmt_execute($updateStockStmt);

                    $insertItemQuery = "INSERT INTO isi_pesanan (no_menu, no_pesanan, jumlah) VALUES (?, ?, ?)";
                    $itemStmt = mysqli_prepare($db, $insertItemQuery);
                    mysqli_stmt_bind_param($itemStmt, 'sss', $menu_id, $order_id, $quantity);
                    mysqli_stmt_execute($itemStmt);
                }
            }

            // Calculate the total from isi_pesanan and menu
            $total = calculateOrderTotal($db, $order_id);

            // Update the total in the pesanan table
            $updateTotalQuery = "UPDATE pesanan SET total = ? WHERE no_pesanan = ?";
            $updateStmt = mysqli_prepare($db, $updateTotalQuery);
            mysqli_stmt_bind_param($updateStmt, 'ss', $total, $order_id);
            mysqli_stmt_execute($updateStmt);

            // Update the table status to "dine in"
            $updateTableQuery = "UPDATE meja SET status_meja = 'dine in' WHERE no_meja = ?";
            $updateTableStmt = mysqli_prepare($db, $updateTableQuery);
            mysqli_stmt_bind_param($updateTableStmt, 's', $table_number);
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
    } else {
        // If the table status is not "kosong", check if there is an existing order for the table with status_pesanan not 'sudah dibayar'
        $getOrderIdQuery = "SELECT no_pesanan FROM pesanan WHERE no_meja = ? AND status_pesanan != 'sudah dibayar'";
        $getOrderIdStmt = mysqli_prepare($db, $getOrderIdQuery);
        mysqli_stmt_bind_param($getOrderIdStmt, 's', $table_number);
        mysqli_stmt_execute($getOrderIdStmt);
        mysqli_stmt_bind_result($getOrderIdStmt, $order_id);
        mysqli_stmt_fetch($getOrderIdStmt);
        mysqli_stmt_close($getOrderIdStmt);

        if ($order_id) {
            // Insert each menu item into isi_pesanan
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'jumlah_') === 0 && $value > 0) {
                    $menu_id = str_replace('jumlah_', '', $key);
                    $quantity = (int)$value;

                    // Reduce the stock in the menu table
                    $updateStockQuery = "UPDATE menu SET stok = stok - ? WHERE no_menu = ?";
                    $updateStockStmt = mysqli_prepare($db, $updateStockQuery);
                    mysqli_stmt_bind_param($updateStockStmt, 'is', $quantity, $menu_id);
                    mysqli_stmt_execute($updateStockStmt);

                    $insertItemQuery = "INSERT INTO isi_pesanan (no_menu, no_pesanan, jumlah) VALUES (?, ?, ?)";
                    $itemStmt = mysqli_prepare($db, $insertItemQuery);
                    mysqli_stmt_bind_param($itemStmt, 'sss', $menu_id, $order_id, $quantity);
                    mysqli_stmt_execute($itemStmt);
                }
            }

            // Calculate the total from isi_pesanan and menu
            $total = calculateOrderTotal($db, $order_id);

            // Update the total in the pesanan table
            $updateTotalQuery = "UPDATE pesanan SET total = ?, tanggal = NOW() WHERE no_pesanan = ?";
            $updateStmt = mysqli_prepare($db, $updateTotalQuery);
            mysqli_stmt_bind_param($updateStmt, 'ss', $total, $order_id);
            mysqli_stmt_execute($updateStmt);

            // Update the table status to "dine in"
            $updateTableQuery = "UPDATE meja SET status_meja = 'dine in' WHERE no_meja = ?";
            $updateTableStmt = mysqli_prepare($db, $updateTableQuery);
            mysqli_stmt_bind_param($updateTableStmt, 's', $table_number);
            mysqli_stmt_execute($updateTableStmt);

            // Redirect or display a success message
            $_SESSION['success'] = "Order successfully updated!";
            header('Location: order_success.php');
            exit();
        } else {
            // If no existing order found or status is "sudah dibayar", create a new order
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

                        // Reduce the stock in the menu table
                        $updateStockQuery = "UPDATE menu SET stok = stok - ? WHERE no_menu = ?";
                        $updateStockStmt = mysqli_prepare($db, $updateStockQuery);
                        mysqli_stmt_bind_param($updateStockStmt, 'is', $quantity, $menu_id);
                        mysqli_stmt_execute($updateStockStmt);

                        $insertItemQuery = "INSERT INTO isi_pesanan (no_menu, no_pesanan, jumlah) VALUES (?, ?, ?)";
                        $itemStmt = mysqli_prepare($db, $insertItemQuery);
                        mysqli_stmt_bind_param($itemStmt, 'sss', $menu_id, $order_id, $quantity);
                        mysqli_stmt_execute($itemStmt);
                    }
                }

                // Calculate the total from isi_pesanan and menu
                $total = calculateOrderTotal($db, $order_id);

                // Update the total in the pesanan table
                $updateTotalQuery = "UPDATE pesanan SET total = ? WHERE no_pesanan = ?";
                $updateStmt = mysqli_prepare($db, $updateTotalQuery);
                mysqli_stmt_bind_param($updateStmt, 'ss', $total, $order_id);
                mysqli_stmt_execute($updateStmt);

                // Update the table status to "dine in"
                $updateTableQuery = "UPDATE meja SET status_meja = 'dine in' WHERE no_meja = ?";
                $updateTableStmt = mysqli_prepare($db, $updateTableQuery);
                mysqli_stmt_bind_param($updateTableStmt, 's', $table_number);
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
    }
}

// Function to calculate the total amount of an order
function calculateOrderTotal($db, $order_id) {
    $totalQuery = "SELECT SUM(ip.jumlah * m.harga) AS total FROM isi_pesanan ip JOIN menu m ON ip.no_menu = m.no_menu WHERE ip.no_pesanan = ?";
    $totalStmt = mysqli_prepare($db, $totalQuery);
    mysqli_stmt_bind_param($totalStmt, 's', $order_id);
    mysqli_stmt_execute($totalStmt);
    mysqli_stmt_bind_result($totalStmt, $total);
    mysqli_stmt_fetch($totalStmt);
    mysqli_stmt_close($totalStmt);
    return $total;
}
?>
