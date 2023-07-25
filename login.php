<?php
// Memulai sesi
session_start();




// Memeriksa jika form login telah dikirim
if (isset($_POST['username']) && isset($_POST['password'])) {
    require_once "config.php";

    // Mendapatkan nilai dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Melakukan query untuk mendapatkan data pengguna
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Memeriksa kesesuaian password
        if ($password == $row['password']) {
            // Menyimpan data pengguna ke sesi
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['is_admin'] = $row['is_admin'];

            // Mengecek level pengguna dan mengarahkan ke halaman yang sesuai
            if ($_SESSION['is_admin'] === '0') {
                header("Location: dashboard_user.php");
            } elseif ($_SESSION['is_admin'] === '1') {
                header("Location: dashboard_admin.php");
            }
        } else {
            $error_message = "Password yang Anda masukkan salah.";
        }
    } else {
        $error_message = "Username tidak ditemukan.";
    }

    // Menutup koneksi database
    mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistem Login</title>
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
        input[type="password"] {
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Sistem Login</h2>
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" value="Login">
            </div>
        </form>
    </div>
</body>
</html>