<?php
include 'config.php';

if (isset($_POST['no_pesanan']) && isset($_POST['status'])) {
    $no_pesanan = $_POST['no_pesanan'];
    $status = $_POST['status'];

    // Update the status of the order
    $sql = "UPDATE pesanan SET status_pesanan='$status' WHERE no_pesanan='$no_pesanan'";

    if (mysqli_query($db, $sql)) {
        // If the status is 'sudah dibayar', update the status_meja to 'kosong'
        if ($status == 'sudah dibayar') {
            $sql_update_meja = "UPDATE meja m
                                JOIN pesanan p ON m.no_meja = p.no_meja
                                SET m.status_meja = 'kosong'
                                WHERE p.no_pesanan = '$no_pesanan'";
            mysqli_query($db, $sql_update_meja);
        }
        echo "Berhasil diperbarui";
    } else {
        echo "Gagal diperbarui: " . mysqli_error($db);
    }

    mysqli_close($db);
}
?>