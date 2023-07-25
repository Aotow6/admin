<?php
// Memulai sesi
session_start();

// Definisikan $error_message dan $success_message dengan nilai kosong
$error_message = "";
$success_message = "";

// Memeriksa jika form registrasi telah dikirim
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    require_once "config.php";

    // Mendapatkan nilai dari form registrasi
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Mengamankan query dengan prepared statement
    $query = "INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connect, $query);
    $is_admin = 0; // Nilai default untuk is_admin (tidak admin)
    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $password, $is_admin);
    if (mysqli_stmt_execute($stmt)) {
        // Jika registrasi berhasil, simpan pesan sukses di session
        $_SESSION['success_message'] = "Registrasi berhasil. Silakan login dengan akun Anda.";
        // Redirect ke halaman login
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Registrasi gagal. Silakan coba lagi.";
    }

    // Menutup koneksi database
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
?>


<!-- Kode HTML seperti sebelumnya -->


<!DOCTYPE html>
<html>
<head>
    <title>Sistem Registrasi</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sistem Registrasi</h2>
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" value="Register">
            </div>
        </form>
        <p class="text-center">Sudah punya akun? <a href="login.php">Login sekarang</a></p>
    </div>
</body>
</html>
