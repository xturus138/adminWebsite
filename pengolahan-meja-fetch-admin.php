<?php
include 'config.php';

$query = "SELECT * FROM meja";
$result = mysqli_query($db, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['no_meja']}</td>";
        echo "<td>{$row['status_meja']}</td>";
        echo "<td>{$row['kapasitas']}</td>";
        echo "<td>
                <a href='pengolahan-meja-edit-admin.php?id={$row['no_meja']}' class='btn btn-warning btn-sm'>Edit</a>
                <a href='pengolahan-meja-delete-admin.php?id={$row['no_meja']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No data found</td></tr>";
}
?>
