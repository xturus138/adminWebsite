<?php
// Connect to the database
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_number = $_POST['table_number'];
    $order_status = $_POST['order_status'];

    // Update the status of the selected table
    $update_query = "UPDATE meja SET status_meja = '$order_status' WHERE no_meja = '$table_number'";
    if (mysqli_query($db, $update_query)) {
        echo "Status meja berhasil diubah.";
    } else {
        echo "Error: " . mysqli_error($db);
    }

    // Save the order details (this part is just an example, you might want to adjust it according to your actual database schema)
    // $order_query = "INSERT INTO orders (table_number, nasi_goreng, mie_goreng, sate_ayam, teh_manis, kopi, jus_jeruk) VALUES ('$table_number', '$nasi_goreng', '$mie_goreng', '$sate_ayam', '$teh_manis', '$kopi', '$jus_jeruk')";
    // if (mysqli_query($db, $order_query)) {
    //     echo "Pesanan berhasil dicatat.";
    // } else {
    //     echo "Error: " . mysqli_error($db);
    // }
}
header("Location: order_success.html");
exit();

mysqli_close($db);
?>
