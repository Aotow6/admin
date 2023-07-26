<?php
// logout.php

// mengaktifkan session php
session_start();

// Memeriksa jika form logout telah dikirim
if (isset($_POST['logout'])) {
    // menghapus semua session
    session_destroy();

    // mengalihkan halaman kembali ke halaman login atau halaman lain yang sesuai
    header("location: login.php");
    exit();
}
?>
