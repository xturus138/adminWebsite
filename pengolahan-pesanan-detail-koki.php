<?php
include 'config.php';

if (isset($_GET['no_pesanan'])) {
    $no_pesanan = $_GET['no_pesanan'];
    
    // Query to aggregate menu items and their quantities
    $query = "
    SELECT 
        menu.nama_menu, SUM(isi_pesanan.jumlah) AS total_jumlah
    FROM 
        isi_pesanan 
    JOIN 
        menu 
    ON 
        isi_pesanan.no_menu = menu.no_menu 
    WHERE 
        isi_pesanan.no_pesanan = '$no_pesanan'
    GROUP BY 
        menu.nama_menu";
    
    $result = mysqli_query($db, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                </tr>
              </thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nama_menu']) . "</td>";
            echo "<td>" . htmlspecialchars($row['total_jumlah']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Tidak ada daftar pesanan pada order ini.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
