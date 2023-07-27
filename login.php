<?php
// Memulai sesi
session_start();

// Definisikan $error_message dan $success_message dengan nilai kosong
$error_message = "";
$success_message = "";

// Inisialisasi variabel $username dengan nilai kosong
$username = "";

// Memeriksa jika form login telah dikirim
// Memeriksa apakah ada pesan sukses yang disimpan di session
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    // Hapus pesan sukses dari session agar hanya ditampilkan satu kali
    unset($_SESSION['success_message']);
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    require_once "config.php";

    // Mendapatkan nilai dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengamankan query dengan prepared statement
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Memeriksa kesesuaian password
        if ($password == $row['password']) {
            // Menyimpan data pengguna ke sesi
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_admin'] = $row['is_admin'];

            // Simpan juga nama pengguna ke sesi
            $_SESSION['user_name'] = $row['username'];

            // Mengecek level pengguna dan mengarahkan ke halaman yang sesuai
            if ($_SESSION['is_admin'] == '0') {
                header("Location: index.php");
                exit();
            } elseif ($_SESSION['is_admin'] == '1') {
                header("Location: dashboard_admin.php");
                exit();
            }
        } else {
            $error_message = "Login Eror.";
        }
    } else {
        $error_message = "Login Eror.";
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
    <title>Login</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            position: relative; /* Diperlukan untuk menentukan posisi pseudo-element */
            z-index: 1; /* Pastikan konten halaman berada di atas latar belakang */
                
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('img/latar_bkg1.jpg'); /* Ganti 'latar_bkg.jpg' dengan path dan nama file gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            filter: blur(2px); /* Efek blur pada latar belakang */
            z-index: -1; /* Pastikan pseudo-element berada di belakang konten halaman */
        }

            .container {
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f7f9fa;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                color: #212529;
                
            }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #fff;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 95%;
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
        .success-message {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h2>Sistem Login</h2>

    <div class="container">
        <?php if (isset($error_message)) { ?>
    <p class="error-message"><?php echo $error_message; ?></p>
<?php } ?>
<?php if (isset($success_message)) { ?>
    <p class="success-message"><?php echo $success_message; ?></p>
<?php } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"  required >
            </div>

            <div class="form-group">
                <input type="submit" name="submit" value="Login">
            </div>
        </form>
        <p class="text-center">Belum punya akun? <a href="register.php">Bikin sekarang</a></p>
    </div>
</body>
</html>
