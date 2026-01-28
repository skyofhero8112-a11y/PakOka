<?php 
session_start(); //Untuk mengaktifkan sesi. Sesi = tempat menyimpan data user (sementara) di server.
include "koneksi.php";

//$_SESSION adalah sebuah variabel superglobal, tetapi ISINYA adalah array asosiatif.
//jenis array yang menyimpan data dalam bentuk pasangan "kunci => nilai" 
$error = "";
if (!isset($_SESSION['temp_user'])) { //Kalau user belum login sebagai guru, tetapi langsung buka verify_code.php → tendang ke login.php.
    header("Location: login.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Kalau form verifikasi kode rahasia sudah di-submit
    $secret = $_POST['secret'];
    $s = $koneksi->query("SELECT secret_code FROM settings WHERE id=1")->fetch_assoc(); //mengambil kode rahasia dari database

    if ($secret != $s['secret_code']) {
        $_SESSION['error'] = "Kode rahasia salah!";
        header("Location: verify_code.php");
        exit;
    }

    $_SESSION['user'] = $_SESSION['temp_user'];
    unset($_SESSION['temp_user']); //Hapus data user sementara setelah verifikasi berhasil
    header("Location: dashboard_guru.php");
    exit;
}

?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Verifikasi Kode - Sistem Pengumuman Sekolah</title>
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

        .verify-container {
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

        .verify-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }

        .verify-header img {
            width: 120px;
            height: 120px;
            margin-bottom: 15px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .verify-header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .verify-header p {
            margin: 0;
            font-size: 13px;
            opacity: 0.9;
        }

        .verify-body {
            padding: 40px 35px;
        }

        .info-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #856404;
        }

        .info-box i {
            margin-right: 10px;
            color: #ffc107;
            font-size: 18px;
        }

        .info-box strong {
            display: block;
            margin-bottom: 5px;
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

        .btn-verify {
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

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4);
        }

        .btn-verify:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .verify-container {
                margin: 10px;
            }
            
            .verify-header {
                padding: 30px 20px;
            }
            
            .verify-body {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="verify-header">
            <img src="logo_skensa.png" alt="Logo SMK Negeri 1 Denpasar">
            <h2>Verifikasi Kode Rahasia Guru</h2>
            <p>SMK Negeri 1 Denpasar</p>
        </div>
        
        <div class="verify-body">
            <div class="info-box">
                <i class="fas fa-shield-alt"></i>
                <strong>Verifikasi Keamanan</strong>
                Masukkan kode rahasia yang diberikan oleh admin untuk melanjutkan registrasi sebagai guru.
            </div>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="secret">Kode Rahasia</label>
                    <div class="input-group">
                        <i class="fas fa-key"></i>
                        <input type="password" class="form-control" id="secret" name="secret" placeholder="Masukkan kode rahasia" required>
                    </div>
                </div>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['error']; ?>
                    </div>
                <?php unset($_SESSION['error']); endif; ?> <!--Hapus pesan error setelah ditampilkan-->

                <button type="submit" class="btn-verify">
                    <i class="fas fa-check-circle"></i> Verifikasi Sekarang
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>