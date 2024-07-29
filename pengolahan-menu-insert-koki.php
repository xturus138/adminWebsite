<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_menu = mysqli_real_escape_string($db, $_POST['nama_menu']);
    $harga = mysqli_real_escape_string($db, $_POST['harga']);
    $status_menu = "tunda"; // default status
    $stok = 0; // default stock for new menu items

    $sql = "INSERT INTO menu (nama_menu, harga, status_menu, stok) VALUES ('$nama_menu', '$harga', '$status_menu', '$stok')";

    if (mysqli_query($db, $sql)) {
        echo "<script>
                alert('Menu Berhasil Dibuat');
                window.location.href='pengolahan-menu-koki.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $sql . "<br>" . mysqli_error($db) . "');
                window.location.href='pengolahan-menu-koki.php';
              </script>";
    }

    mysqli_close($db);
}
?>
