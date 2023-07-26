<?php
// Memulai sesi
session_start();

// Definisikan $error_message dan $success_message dengan nilai kosong
$error_message = "";
$success_message = "";

// Definiskan variabel untuk menyimpan nilai input yang sudah dimasukkan dengan default kosong
$username_value = "";
$email_value = "";

// Memeriksa jika form registrasi telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    require_once "config.php";

    // Mendapatkan nilai dari form registrasi
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi nama dan password
    if (strlen($username) < 6) {
        $error_message = "Nama harus terdiri dari minimal 6 karakter.";
    } elseif (strlen($password) < 5) {
        $error_message = "Password harus terdiri dari minimal 5 karakter.";
    } else {
        // Mengamankan query dengan prepared statement
        $query_user = "INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)";
        $stmt_user = mysqli_prepare($connect, $query_user);
        $is_admin = 0; // Nilai default untuk is_admin (tidak admin)
        mysqli_stmt_bind_param($stmt_user, "sssi", $username, $email, $password, $is_admin);
        
        if (mysqli_stmt_execute($stmt_user)) {
            // Jika registrasi ke tabel users berhasil, dapatkan nilai user_id yang baru saja di-generate
            $user_id = mysqli_insert_id($connect);
            
            // Selanjutnya simpan data guru ke dalam tabel data_guru
            $nama_lengkap = $_POST['nama_lengkap'];
            $NIP = $_POST['NIP'];
            $NUPTK = $_POST['NUPTK'];
            $gelar = $_POST['gelar'];
            $tanggal_lahir = $_POST['tanggal_lahir'];
            $tempat_lahir = $_POST['tempat_lahir'];
            $jenjang_ngajar = $_POST['jenjang_ngajar'];
            $NPSN_sekolah = $_POST['NPSN_sekolah'];
            $Nama_sekolah = $_POST['Nama_sekolah'];

            $query_guru = "INSERT INTO data_guru (user_id, nama_lengkap, NIP, NUPTK, gelar, tanggal_lahir, tempat_lahir, jenjang_ngajar, NPSN_sekolah, Nama_sekolah) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt_guru = mysqli_prepare($connect, $query_guru);
            mysqli_stmt_bind_param($stmt_guru, "isssssssis", $user_id, $nama_lengkap, $NIP, $NUPTK, $gelar, $tanggal_lahir, $tempat_lahir, $jenjang_ngajar, $NPSN_sekolah, $Nama_sekolah);
            
            if (mysqli_stmt_execute($stmt_guru)) {
                // Jika registrasi ke tabel ata_guru berhasil, simpan pesan sukses di session
                $_SESSION['success_message'] = "Registrasi berhasil. Silakan login dengan akun Anda.";
                // Redirect ke halaman login
                header("Location: login.php");
                exit();
            } else {
                $error_message = "Registrasi gagal. Silakan coba lagi.";
            }

            // Menutup statement guru
            mysqli_stmt_close($stmt_guru);
        } else {
            $error_message = "Registrasi gagal. Silakan coba lagi.";
        }

        // Menutup statement user
        mysqli_stmt_close($stmt_user);
        // Menutup koneksi database
        mysqli_close($connect);
    }

    // Simpan nilai input yang sudah dimasukkan untuk kemudian diisi kembali di form
    $username_value = $username;
    $email_value = $email;
}
?>


<!-- Kode HTML seperti sebelumnya -->


<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
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
        <h2>Sistem Registrasi Guru</h2>
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username_value; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email_value; ?>" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"  required>
            </div>

            <!-- Input untuk data guru -->
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap Guru:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required>
            </div>

            <div class="form-group">
                <label for="NIP">NIP:</label>
                <input type="text" id="NIP" name="NIP" required>
            </div>

            <div class="form-group">
                <label for="NUPTK">NUPTK:</label>
                <input type="text" id="NUPTK" name="NUPTK" required>
            </div>

            <div class="form-group">
                <label for="gelar">Gelar:</label>
                <input type="text" id="gelar" name="gelar" required>
            </div>

            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>

            <div class="form-group">
                <label for="tempat_lahir">Tempat Lahir:</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" required>
            </div>

            <div class="form-group">
                <label for="jenjang_ngajar">Jenjang Mengajar:</label>
                <input type="text" id="jenjang_ngajar" name="jenjang_ngajar" required>
            </div>

            <div class="form-group">
                <label for="NPSN_sekolah">NPSN Sekolah:</label>
                <input type="text" id="NPSN_sekolah" name="NPSN_sekolah" required>
            </div>

            <div class="form-group">
                <label for="Nama_sekolah">Nama Sekolah:</label>
                <input type="text" id="Nama_sekolah" name="Nama_sekolah" required>
            </div>
            <!-- End input untuk data guru -->

            <div class="form-group">
                <input type="submit" name="submit" value="Register">
            </div>
        </form>
        <p class="text-center">Sudah punya akun? <a href="login.php">Login sekarang</a></p>
    </div>
</body>
</html>
