<?php
session_start();
if(session_destroy()) {
    // Menghapus cookie sesi
    setcookie("login_user", "", time() - 3600, "/");
    
    // Mengatur headers untuk mencegah caching
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    // Redirect ke halaman login
    header("Location: index.html");
    exit();
}
?>
