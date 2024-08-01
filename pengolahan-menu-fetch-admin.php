<?php
include 'config.php';

$query = "SELECT * FROM menu";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['no_menu']}</td>";
        echo "<td>{$row['status_menu']}</td>";
        echo "<td>{$row['nama_menu']}</td>";
        echo "<td>{$row['harga']}</td>";
        echo "<td>
                <a href='pengolahan-menu-edit-admin.php?id={$row['no_menu']}' class='btn btn-warning btn-sm'>Edit</a>
                <a href='pengolahan-menu-delete-admin.php?id={$row['no_menu']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No data found</td></tr>";
}
?>
