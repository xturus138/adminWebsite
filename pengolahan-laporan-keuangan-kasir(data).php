<?php
include 'config.php'; 

// Mendapatkan tanggal mulai dan akhir dari form
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

if ($start_date && $end_date) {
    // Query untuk mengambil data berdasarkan tanggal
    $sql = "SELECT p.tanggal, p.total as total_penjualan, SUM(ip.jumlah) as jumlah_pesanan 
            FROM pesanan p
            JOIN isi_pesanan ip ON p.no_pesanan = ip.no_pesanan
            WHERE p.tanggal BETWEEN '$start_date' AND '$end_date' 
            AND p.status_pesanan = 'sudah dibayar'
            GROUP BY p.tanggal";
    $result = $db->query($sql);

    $tanggal = [];
    $total_penjualan = [];
    $jumlah_pesanan = [];

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tanggal[] = $row['tanggal'];
            $total_penjualan[] = $row['total_penjualan'];
            $jumlah_pesanan[] = $row['jumlah_pesanan'];
        }
    } else {
        echo "Hasil tidak ditemukan";
    }
} else {
    echo "Silakan pilih rentang tanggal.";
}

$db->close();
?>