<?php
include 'config.php';

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Get table number from the form
    $table_number = $_POST['table_number'];

    // Prepare an array to hold the order details
    $order_details = array();
    $total = 0;

    // Loop through the menu items in the form
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'menu_') === 0 && $value > 0) {
            // Extract menu name and quantity
            $menu_name = substr($key, 5); // Remove 'menu_' prefix
            $quantity = $value;

            // Get the price of the menu item from the database
            $sql = "SELECT harga FROM menu WHERE nama_menu = '$menu_name'";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $price = $row['harga'];
                $total += $price * $quantity;

                // Add order detail to the array
                $order_details[] = array(
                    'menu_name' => $menu_name,
                    'quantity' => $quantity,
                    'price' => $price
                );
            }
        }
    }

    // Insert order details into the pesanan table
    if (!empty($order_details)) {
        // Get the current date and time
        $tanggal = date('Y-m-d H:i:s');
        $status = 'tunggu';
        $no_id = 0; // Default value for no_id

        // Insert the main order record
        $sql = "INSERT INTO pesanan (no_meja, no_id, total, tanggal, status)
                VALUES ('$table_number', '$no_id', '$total', '$tanggal', '$status')";
        if ($db->query($sql) === TRUE) {
            $no_pesanan = $db->insert_id; // Get the inserted order ID

            // Optionally, insert detailed items into another table if required
            // foreach ($order_details as $order) {
            //     $menu_name = $order['menu_name'];
            //     $quantity = $order['quantity'];
            //     $price = $order['price'];

            //     $sql = "INSERT INTO pesanan_detail (no_pesanan, nama_menu, jumlah, harga)
            //             VALUES ('$no_pesanan', '$menu_name', '$quantity', '$price')";
            //     $db->query($sql);
            // }
        } else {
            echo "Error: " . $sql . "<br>" . $db->error;
        }
    } else {
        echo "No valid menu items were submitted.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Redirect to a confirmation page
header("Location: order_success.html");
exit();

$db->close();
?>
