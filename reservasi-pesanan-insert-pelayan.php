<?php
session_start();
include('config.php'); // Menggunakan koneksi database

// Cek apakah form sudah di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $no_meja = $_POST['table_number'];
    $order_date = $_POST['order_date'];
    $order_status = $_POST['order_status'];
    
    // Ambil no_id dari session
    if(isset($_SESSION['login_user'])) {
        $no_id = $_SESSION['login_user'];
    } else {
        // Jika tidak ada sesi login, redirect ke halaman login
        header("Location: login.php");
        exit();
    }
    
    // Set status_pesanan ke "tunggu"
    $status_pesanan = "tunggu";
    
    // Mulai transaksi
    mysqli_begin_transaction($db);

    try {
        // Insert data ke tabel pesanan
        $query = "INSERT INTO pesanan (no_meja, no_id, tanggal, status_pesanan) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "iiss", $no_meja, $no_id, $order_date, $status_pesanan);
        
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Gagal menyimpan data pesanan.');
        }

        // Update status meja
        $updateQuery = "UPDATE meja SET status_meja = ? WHERE no_meja = ?";
        $updateStmt = mysqli_prepare($db, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "si", $order_status, $no_meja);
        
        if (!mysqli_stmt_execute($updateStmt)) {
            throw new Exception('Gagal mengupdate status meja.');
        }

        // Commit transaksi
        mysqli_commit($db);

        // Redirect ke reservasi_success.php
        header("Location: reservasi_success.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaksi jika ada kesalahan
        mysqli_rollback($db);
        
        // Redirect ke reservasi_error.php dengan pesan kesalahan
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: reservasi_error.php");
        exit();
    }

    // Tutup statement
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($updateStmt);
}

// Tutup koneksi
mysqli_close($db);
?>
