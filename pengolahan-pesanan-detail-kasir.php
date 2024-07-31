<?php
include 'config.php';

if (isset($_GET['no_pesanan'])) {
    $no_pesanan = $_GET['no_pesanan'];

    $sql = "SELECT m.nama_menu, ip.jumlah, (m.harga * ip.jumlah) as total
            FROM isi_pesanan ip
            JOIN menu m ON ip.no_menu = m.no_menu
            WHERE ip.no_pesanan='$no_pesanan'";

    $result = mysqli_query($db, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-bordered'>";
        echo "<thead>
                <tr>
                    <th class='text-center' style='width: 50%;'>Nama Menu</th>
                    <th class='text-center' style='width: 25%;'>Jumlah</th>
                    <th class='text-center' style='width: 25%;'>Total</th>
                </tr>
              </thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['nama_menu']}</td>
                    <td class='text-center'>{$row['jumlah']}</td>
                    <td class='text-center'>{$row['total']}</td>
                  </tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "Pesanan tidak ditemukan";
    }

    mysqli_close($db);
} else {
    echo "Permintaan tidak valid";
}
?>
