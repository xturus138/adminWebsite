<?php
// Include database connection
include 'config.php';

// Query to fetch data from 'pegawai' table
$query = "SELECT * FROM pegawai";
$result = mysqli_query($db, $query);

// Check if query executed successfully
if (!$result) {
    die('Query failed: ' . mysqli_error($db));
}

// Fetch data and display in table rows
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['no_id'] . "</td>";
    echo "<td>" . $row['nama'] . "</td>";
    echo "<td>" . $row['no_telp'] . "</td>";
    echo "<td>" . $row['jabatan'] . "</td>";
    echo "<td>" . $row['password'] . "</td>";
    echo '<td><a href="pengolahan-pegawai-edit-admin.php?id=' . $row['no_id'] . '" class="btn btn-warning btn-sm">Edit</a></td>';
    echo "</tr>";
}

// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($db);
?>
