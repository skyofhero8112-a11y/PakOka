<?php
session_start();
include "koneksi.php";

$error_username = "";
$error_password = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $check = $koneksi->query("SELECT * FROM users WHERE username='$username' AND role='$role'");

    if ($check->num_rows == 0) {
        $error_username = "Akun tidak ditemukan";
    } else {
        $user = $check->fetch_assoc();

        if ($user['password'] != $password) {
            $error_password = "Kata sandi salah";
        } else {
            if ($role == "guru") {
                $_SESSION['temp_user'] = $user;
                header("Location: verify_code.php");
                exit();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Login - Sistem Pengumuman Sekolah</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(to left, #4f9cf4, #2b6cb0);
            align-items: center;
            justify-content: center; /* konten berada di tengah */
            padding: 20px;
            position: relative;
        }

        /* overlay gelap agar teks lebih terbaca */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }

        .login-panel {
            position: relative;
            z-index: 1;
            background: white;
            border-radius: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            max-width: 440px;
            width: 100%;
            padding: 45px 40px;
            animation: fadeInLeft 0.6s ease-out;
            margin-left: 5%;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Logo di dalam panel, posisi absolute di kanan atas */
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
        font-size: 36px;
        font-weight: 600;
        color: #1e2a3a;
        line-height: 1.2;
        margin-bottom: 30px;
        }
        h2 span {
        display: inline-block;
        position: relative;
        z-index: 1;
        margin-bottom: 30px;
        }
        h2 span::before {
        content: '';
        position: absolute;
        top: -45px;
        left: -40px;
        width: 440px;
        height: 150px;
        background: rgba(79, 156, 244, 0.3);
        border-radius: 10% 8% 90% 40%;
        z-index: -1;
        transform: translate(10deg, -20px);
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
            letter-spacing: 0.3px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group i {
            position: absolute;
            left: 16px;
            color: #a0aec0;
            font-size: 16px;
            transition: color 0.2s;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            font-size: 15px;
            background: #f7fafc;
            transition: all 0.2s;
            color: #1e2a3a;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: #4f9cf4;
            background: white;
            box-shadow: 0 0 0 3px rgba(79, 156, 244, 0.15);
        }

        .form-control:focus + i, .form-select:focus + i {
            color: #4f9cf4;
        }

        /* styling checkbox dan link lupa password */
        .row-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 18px 0 25px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #4f9cf4;
            cursor: pointer;
        }

        .remember label {
            color: #4a5568;
            font-size: 15px;
            font-weight: 400;
            cursor: pointer;
        }

        .forgot-link {
            color: #4f9cf4;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #2b6cb0;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #4f9cf4, #2b6cb0);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 17px;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(43, 108, 176, 0.3);
            margin-bottom: 25px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(43, 108, 176, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .footer-text {
            text-align: center;
            color: #a0aec0;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        .text-danger {
            background-color: #fed7d7;
            color: #c53030;
            font-size: 14px;
            margin-top: 8px;
            padding: 10px 14px;
            border-left: 4px solid #f56565;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: fadeIn 0.2s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 15px;
            color: #4a5568;
        }

        .register-link a {
            color: #4f9cf4;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* menyesuaikan ikon pada select */
        .input-group .form-select {
            padding-left: 48px;
        }

        @media (max-width: 600px) {
            .login-panel {
                margin-left: 0;
                padding: 35px 25px;
            }
            h2 {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-panel">
        <h2>
            <span>Login!</span>
            <img src="logo_skensa.png" alt="Logo Skensa" class="logo-skensa">
        </h2>

        <form action="" method="POST">
            <!-- Email (menggunakan field username) -->
            <div class="form-group">
                <label for="username">NickName</label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="text" class="form-control" id="username" name="username"
                        placeholder="Enter Your NickName"
                        value="<?= htmlspecialchars($username ?? '') ?>" required>
                </div>
                <?php if (!empty($error_username)): ?>
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= $error_username ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter Your Password"
                        value="<?= htmlspecialchars($password ?? '') ?>" required>
                </div>
                <?php if (!empty($error_password)): ?>
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= $error_password ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Dropdown Role (tetap dipertahankan) -->
            <div class="form-group">
                <label for="role">Login Sebagai</label>
                <div class="input-group">
                    <i class="fas fa-user-tag"></i>
                    <select class="form-select" id="role" name="role">
                        <option value="siswa" <?= (isset($role) && $role == 'siswa') ? 'selected' : '' ?>>Siswa</option>
                        <option value="guru" <?= (isset($role) && $role == 'guru') ? 'selected' : '' ?>>Guru</option>
                    </select>
                </div>
            </div>

            <!-- Tombol Login -->
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> Log In
            </button>

            <!-- Footer tamai.in -->
            <div class="footer-text">SMKN 1 DENPASAR</div>

            <!-- Link ke halaman register -->
            <div class="register-link">
                <p>Tidak punya akun? <a href="register.php">Daftar Disini</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>