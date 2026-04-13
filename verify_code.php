<?php 
session_start();
include "koneksi.php";

// Proteksi halaman
if (!isset($_SESSION['temp_user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $secret = $_POST['secret'];
    // Ambil kode rahasia dari database
    $stmt = $koneksi->prepare("SELECT secret_code FROM settings WHERE id=1");
    $stmt->execute();
    $result = $stmt->get_result();
    $s = $result->fetch_assoc();

    if ($secret != $s['secret_code']) {
        $_SESSION['error'] = "Kode rahasia salah!";
        header("Location: verify_code.php");
        exit;
    }

    $_SESSION['user'] = $_SESSION['temp_user'];
    unset($_SESSION['temp_user']); 
    header("Location: dashboard_guru.php");
    exit;
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Verifikasi - Sistem Pengumuman Sekolah</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: linear-gradient(to left, #4f9cf4, #2b6cb0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }
        .register-panel {
            position: relative;
            z-index: 1;
            background: white;
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            max-width: 440px;
            width: 100%;
            padding: 45px 40px;
            animation: fadeInLeft 0.6s ease-out;
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .logo-skensa {
            position: absolute;
            top: 35px;
            right: 40px;
            width: 70px;
            height: 70px;
            animation: float 3s ease-in-out infinite;
            z-index: 10;
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0); }
        }
        
        h2 {
            font-size: 32px;
            font-weight: 600;
            color: #1e2a3a;
            line-height: 1.2;
            margin-bottom: 75px;
        }
        h2 span {
            display: inline-block;
            position: relative;
            z-index: 1;
        }   
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #4f9cf4;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 13px;
            color: #1e3c72;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-group {
            margin-bottom: 22px;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: #2d3748;
            font-weight: 500;
            font-size: 14px;
        }
        .input-group {
            position: relative;
        }
        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
            z-index: 10;
        }
        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            font-size: 15px;
            background: #f7fafc;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: #4f9cf4;
            background: white;
            box-shadow: 0 0 0 3px rgba(79,156,244,0.15);
        }
        .btn-register {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #4f9cf4, #2b6cb0);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(43,108,176,0.3);
            margin-top: 10px;
        }
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(43,108,176,0.4);
        }
        /* alert error */
        .alert-danger {
            background-color: #fed7d7;
            color: #c53030;
            font-size: 14px;
            padding: 10px 14px;
            border: none;
            border-left: 4px solid #f56565;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }
        .footer-text {
            text-align: center;
            color: #a0aec0;
            font-size: 14px;
            margin-top: 25px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="register-panel">
        <h2>
            <span>Verifikasi</span>
            <img src="logo_skensa.png" alt="Logo Skensa" class="logo-skensa">
        </h2>

        <div class="info-box">
            <i class="fas fa-shield-alt"></i>
            <div>
                <strong>Keamanan Guru:</strong> Masukkan kode rahasia admin untuk menyelesaikan pendaftaran.
            </div>
        </div>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="secret">Kode Rahasia</label>
                <div class="input-group">
                    <i class="fas fa-key"></i>
                    <input type="password" class="form-control" id="secret" name="secret" 
                           placeholder="Masukkan kode rahasia" required autofocus>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-check-circle"></i> Verifikasi Sekarang
            </button>
        </form>

        <div class="footer-text">SMKN 1 DENPASAR</div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>