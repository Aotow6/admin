    <?php
    // Memulai sesi
    session_start();

    // Definisikan $error_message dan $success_message dengan nilai kosong
    $error_message = "";
    $success_message = "";

    // Definiskan variabel untuk menyimpan nilai input yang sudah dimasukkan dengan default kosong
    $username_value = "";
    $email_value = "";
    $nama_lengkap_value = "";
    $NIP_value = "";
    $NUPTK_value = "";
    $gelar_value = "";
    $tanggal_lahir_value = "";
    $tempat_lahir_value = "";
    $jenjang_ngajar_value = "";
    $NPSN_sekolah_value = "";
    $Nama_sekolah_value = "";


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

                // Validasi input guru
                if (strlen($nama_lengkap) < 6) {
                    $error_message = "Nama Lengkap Guru harus terdiri dari minimal 6 karakter.";
                } elseif (strlen($NIP) !== 18) {
                    $error_message = "NIP harus terdiri dari tepat 18 karakter.";
                } elseif (strlen($NUPTK) !== 16) {
                    $error_message = "NUPTK harus terdiri dari tepat 16 karakter.";
                } elseif (empty($tanggal_lahir)) {
                    $error_message = "Tanggal Lahir harus diisi.";
                } elseif (empty($tempat_lahir)) {
                    $error_message = "Tempat Lahir harus diisi.";
                } elseif (strlen($NPSN_sekolah) !== 8) {
                    $error_message = "NPSN Sekolah harus terdiri dari tepat 8 karakter.";
                } else {
                    // Semua input guru valid, simpan ke dalam tabel data_guru
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
                }
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
        $nama_lengkap_value = $nama_lengkap;
        $NIP_value = $NIP;
        $NUPTK_value = $NUPTK;
        $gelar_value = $gelar;
        $tanggal_lahir_value = $tanggal_lahir;
        $tempat_lahir_value = $tempat_lahir;
        $jenjang_ngajar_value = $jenjang_ngajar;
        $NPSN_sekolah_value = $NPSN_sekolah;
        $Nama_sekolah_value = $Nama_sekolah;

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
            input[type="password"],
            input[type="email"] {
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

            .text-center {
                text-align: center;
            }
            input[type="date"] {
                width: 95%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                /* Add custom arrow */
                background-image: url('img/calendar-icon.png'); /* Update the path here */
                background-size: 20px 20px;
                background-position: right center;
                background-repeat: no-repeat;
                cursor: pointer;
            }
            select {
                width: 101%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            /* Optional: Add hover and focus styles for date input */
            input[type="date"]:hover, input[type="date"]:focus {
                border-color: #007bff;
            }
            .form-select {
                appearance: none; /* Remove default arrow on Chrome/Safari */
                -webkit-appearance: none; /* Remove default arrow on Firefox */
                background-image: url('img/dropdown-icon.png'); /* Add custom arrow */
                background-size: 15px;
                background-position: right 10px center;
                background-repeat: no-repeat;
                cursor: pointer;
            }

            /* Optional: Add hover and focus styles for select element */
            .form-select:hover, 
            .form-select:focus {
                border-color: #007bff;
            }

            /* Optional: Style selected option in dropdown */
            .form-select option:checked {
                background-color: #007bff;
                color: #fff;
            }
        </style>
    </head>
    <body>

    <h2>Registrasi</h2>
        <div class="container">
            
            
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
                    <input type="password" id="password" name="password"   required>
                </div>

                <!-- Input untuk data guru -->
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap Guru:</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="<?php echo $nama_lengkap_value; ?>" required>
                </div>

                <div class="form-group">
                    <label for="NIP">NIP:</label>
                    <input type="text" id="NIP" name="NIP" value="<?php echo $NIP_value; ?>" required>
                </div>

                <div class="form-group">
                    <label for="NUPTK">NUPTK:</label>
                    <input type="text" id="NUPTK" name="NUPTK" value="<?php echo $NUPTK_value; ?>" required>
                </div>

                <div class="form-group">
                    <label for="gelar">Gelar:</label>
                    <input type="text" id="gelar" name="gelar" value="<?php echo $gelar_value; ?>" required>
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo $tanggal_lahir_value; ?>" required>
                </div>

                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir:</label>
                    <input type="text" id="tempat_lahir" name="tempat_lahir" value="<?php echo $tempat_lahir_value; ?>" required>
                </div>

                <div class="form-group">
                    <label for="jenjang_ngajar">Jenjang Mengajar: <br> </label>
                    <select class="form-select" aria-label="Default select example" id="jenjang_ngajar" name="jenjang_ngajar" required>
                        <option selected>Pilih Jenjang</option>
                        <option value="SMA" <?php if ($jenjang_ngajar_value === "SMA") echo "selected"; ?>>SMA</option>
                        <option value="SMK" <?php if ($jenjang_ngajar_value === "SMK") echo "selected"; ?>>SMK</option>
                        <option value="SLB" <?php if ($jenjang_ngajar_value === "SLB") echo "selected"; ?>>SLB</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="NPSN_sekolah">NPSN Sekolah:</label>
                    <input type="text" id="NPSN_sekolah" name="NPSN_sekolah" value="<?php echo $NPSN_sekolah_value; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Nama_sekolah">Nama Sekolah:</label>
                    <input type="text" id="Nama_sekolah" name="Nama_sekolah" value="<?php echo $Nama_sekolah_value; ?>" required>
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
