<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];
$is_admin = $_POST['is_admin'];

$login = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password' AND is_admin='$is_admin'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);

    $_SESSION['username'] = $username;
    $_SESSION['is_admin'] = $is_admin;

    if ($is_admin == "1") {
        header("location: dashboard_admin.php");
    } else if ($is_admin == "0") {
        header("location: index.php");
    }
} else {
    header("location: index.php?pesan=gagal");
}
?>