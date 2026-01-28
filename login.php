<?php
session_start(); //menyimpan data pengguna
include "koneksi.php"; //Memanggil file koneksi tadi supaya bisa akses database.

$error_username = "";
$error_password = "";

//Cek apakah user menekan tombol Login
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //jika request methodnya post maka jalankan kode di bawah
    $username = $_POST['username']; //variabel username menyimpan data dari array $_POST yang memiliki kunci (key) bernama 'username'
    $password = $_POST['password']; 
    $role = $_POST['role'];

    $check = $koneksi->query("SELECT * FROM users WHERE username='$username' AND role='$role'");

    if ($check->num_rows == 0) { //jumlah baris (hasil) yang dikembalikan oleh kueri database adalah nol 
        $error_username = "Akun tidak ditemukan";
    } else {
        $user = $check->fetch_assoc(); //fetch_assoc(): mengambil data user dari hasil query dalam bentuk array asosiatif

        if ($user['password'] != $password) {
            $error_password = "Kata sandi salah";
        } else {
            // Login berhasil
            if ($role == "guru") {
                $_SESSION['temp_user'] = $user; //$user berasal dari hasil query database, lalu disimpan di temp_user 
                //$_SESSION: Ini adalah variabel superglobal bawaan PHP yang digunakan untuk menyimpan data sesi. 
                //tempt_user :simpan data user sementara sebelum verifikasi dua langkah
                header("Location: verify_code.php"); 
                exit(); //Menghentikan eksekusi skrip setelah pengalihan
            }
            $_SESSION['user'] = $user;
            header("location: dashboard_siswa.php");
            exit();
        }
    }
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Login - Sistem Pengumuman Sekolah</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #3da0f8ff 0%, #00f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .login-header img {
            width: 120px;
            height: 120px;
            margin-bottom: 15px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }


        .login-header h2 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .login-body {
            padding: 40px 35px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #4facfe;
            font-size: 16px;
        }

        .text-danger {
            background-color: #ffe0e0; /* merah muda lembut */
            color: #b10000;           /* text merah tajam tapi soft */
            font-size: 15px;
            margin-top: 6px;
            display: block;
            padding: 17px 10px;
            border-left: 4px solid #ff4d4d;
            border-radius: 5px;
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-3px); }
            to   { opacity: 1; transform: translateY(0); }
        }


        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .form-select {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background-color: white;
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }

        .register-link p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }

        .register-link a {
            color: #4facfe;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link a:hover {
            color: #1e3c72;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                margin: 10px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
            
            .login-body {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="logo_skensa.png" alt="Logo SMK Negeri 1 Denpasar">
            <h2>Sistem Pengumuman</h2>
            <p>SMK Negeri 1 Denpasar</p>
        </div>
        
        <div class="login-body">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="username" 
                            name="username" placeholder="Masukkan nama pengguna"
                            value="<?= htmlspecialchars($username ?? "") ?>" required>
                            <!--Kalau user salah login, form tidak dikosongkan. Username tetap muncul agar user tidak harus mengetik ulang.
                            htmlspecialchars() mengubah beberapa karakter yang telah ditentukan sebelumnya menjadi entitas HTML.-->
                    </div>

                    <?php if (!empty($error_username)): ?> <!--Jika $error_username ada isinya → tampilkan pesan error bertanda merah di bawah input.-->
                        <small class="text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <?= $error_username ?>
                        </small>
                    <?php endif; ?> <!--berfungsi untuk menutup pernyataan if, elseif, dan else yang dibuka dengan sintaks alternatif (menggunakan titik dua).-->
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" 
                            name="password" placeholder="Masukkan kata sandi"
                            value="<?= htmlspecialchars($password ?? "") ?>" required>
                    </div>

                    <?php if (!empty($error_password)): ?>
                        <small class="text-danger">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <?= $error_password ?>
                        </small>
                    <?php endif; ?>
                </div>


                <div class="form-group">
                    <label for="role">Masuk Sebagai</label>
                    <div class="input-group">
                        <i class="fas fa-user-tag"></i>
                        <select class="form-select" id="role" name="role">
                            <option value="siswa" <?= (isset($role) && $role=='siswa') ? 'selected' : '' ?>>Siswa</option> <!--Jika kondisi benar → tampilkan "selected". Jika kondisi salah → tampilkan "" (kosong)-->
                            <option value="guru" <?= (isset($role) && $role=='guru') ? 'selected' : '' ?>>Guru</option>
                            <!--isset untuk memeriksa apakah sebuah variabel sudah dideklarasikan (dibuat) dan tidak bernilai NULL--->
                            <!--Kalau ditambahkan: </option selected> Maka option itu akan otomatis terpilih--->
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>

                <div class="register-link">
                    <p>Belum punya akun? <a href="register.php">Daftar disini</a></p>
                </div>
            </form>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
