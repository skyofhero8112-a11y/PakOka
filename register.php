<?php
session_start();
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Register - Sistem Pengumuman Sekolah</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: linear-gradient(to left, #4f9cf4, #2b6cb0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center; /* konten di tengah */
            padding: 20px;
            position: relative;
        }
        /* overlay gelap */
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
            margin-left: 5%;
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to { opacity: 1; transform: translateX(0); }
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
        margin-bottom: 75px;
        }
        h2 span {
        display: inline-block;
        position: relative;
        z-index: 1;
        }
        h2 span::before {
        content: '';
        position: absolute;
        top: -45px;
        left: -40px;
        width: 440px;
        height: 150px;
        background: rgba(79, 156, 244, 0.3);
        border-radius: 10% 10% 90% 80%;
        z-index: -1;
        transform: translate(10deg);
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
        }
        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
            transition: color 0.2s;
            z-index: 10;
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
            box-shadow: 0 0 0 3px rgba(79,156,244,0.15);
        }
        .form-control:focus + i, .form-select:focus + i {
            color: #4f9cf4;
        }
        /* checkbox untuk policy */
        .policy-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0 25px;
        }
        .policy-checkbox input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: #4f9cf4;
            cursor: pointer;
        }
        .policy-checkbox label {
            color: #4a5568;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
        }
        .policy-checkbox a {
            color: #4f9cf4;
            text-decoration: none;
            font-weight: 500;
        }
        .policy-checkbox a:hover {
            text-decoration: underline;
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
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(43,108,176,0.3);
            margin-bottom: 25px;
        }
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(43,108,176,0.4);
        }
        .btn-register:active {
            transform: translateY(0);
        }
        .footer-text {
            text-align: center;
            color: #a0aec0;
            font-size: 14px;
            font-weight: 400;
            letter-spacing: 1px;
            margin: 5px 0 15px;
        }
        .login-link {
            text-align: center;
            font-size: 15px;
            color: #4a5568;
        }
        .login-link a {
            color: #4f9cf4;
            font-weight: 600;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }
        /* alert error */
        .text-danger, .alert-danger {
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
        /* field dinamis untuk jurusan & kode guru */
        #guruCode, #siswaJurusan {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: all 0.4s ease;
            margin-bottom: 0;
        }
        .show-field {
            max-height: 170px !important;
            opacity: 1 !important;
            margin-bottom: 22px !important;
        }
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #4f9cf4;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #1e3c72;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        @media (max-width: 600px) {
            .register-panel {
                margin-left: 0;
                padding: 35px 25px;
            }
            h2 { font-size: 30px; }
            h2 span { font-size: 40px; }
        }
    </style>
</head>
<body>
    <div class="register-panel">
        <h2>
            <span>SignUp!</span>
            <img src="logo_skensa.png" alt="Logo Skensa" class="logo-skensa">
        </h2>

        <form action="register_process.php" method="POST">
            <!-- Username -->
            <div class="form-group">
                <label for="username">Enter Your User Name</label>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" class="form-control" id="username" name="username"
                           placeholder="Enter Your User Name"
                           value="<?= htmlspecialchars($_SESSION['old']['username'] ?? '') ?>" required>
                </div>
                <?php if (isset($_SESSION['error_username'])): ?>
                    <div class="text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= $_SESSION['error_username']; unset($_SESSION['error_username']); ?>
                    </div>
                <?php endif; ?>
            </div>


            <!-- Password -->
            <div class="form-group">
                <label for="password">Enter Your Password</label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Enter Your Password" required>
                </div>
            </div>

            <!-- Role (tersembunyi dalam pilihan, tapi tetap ada) -->
            <div class="form-group">
                <label for="role">Daftar Sebagai</label>
                <div class="input-group">
                    <i class="fas fa-user-tag"></i>
                    <select class="form-select" id="role" name="role">
                        <option value="siswa" <?= (($_SESSION['old']['role'] ?? '') == 'siswa') ? 'selected' : '' ?>>Siswa</option>
                        <option value="guru" <?= (($_SESSION['old']['role'] ?? '') == 'guru') ? 'selected' : '' ?>>Guru</option>
                    </select>
                </div>
            </div>

            <!-- Field dinamis untuk siswa (jurusan) -->
            <div id="siswaJurusan">
                <div class="form-group">
                    <label for="jurusan">Pilih Jurusan</label>
                    <div class="input-group">
                        <i class="fas fa-graduation-cap"></i>
                        <select class="form-select" name="jurusan" id="jurusan">
                            <option value="">-- Pilih Jurusan --</option>
                            <option value="RPL" <?= (($_SESSION['old']['jurusan'] ?? '') == 'RPL') ? 'selected' : '' ?>>RPL (Rekayasa Perangkat Lunak)</option>
                            <option value="TKJ" <?= (($_SESSION['old']['jurusan'] ?? '') == 'TKJ') ? 'selected' : '' ?>>TKJ (Teknik Komputer Jaringan)</option>
                            <option value="MM" <?= (($_SESSION['old']['jurusan'] ?? '') == 'MM') ? 'selected' : '' ?>>Multimedia</option>
                            <option value="AK" <?= (($_SESSION['old']['jurusan'] ?? '') == 'AK') ? 'selected' : '' ?>>Akuntansi</option>
                        </select>
                    </div>
                </div>
                <?php if (isset($_SESSION['error_jurusan'])): ?>
                    <div class="text-danger mb-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= $_SESSION['error_jurusan']; unset($_SESSION['error_jurusan']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Field dinamis untuk guru (kode registrasi) -->
            <div id="guruCode">
                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <strong>Khusus Guru:</strong> Masukkan kode registrasi admin.
                </div>
                <div class="form-group">
                    <label for="register_code">Kode Registrasi Guru</label>
                    <div class="input-group">
                        <i class="fas fa-key"></i>
                        <input type="text" class="form-control" id="register_code" name="register_code"
                               value="<?= htmlspecialchars($_SESSION['old']['register_code'] ?? '') ?>"
                               placeholder="Masukkan kode registrasi">
                    </div>
                </div>
                <?php if (isset($_SESSION['error_kode'])): ?>
                    <div class="text-danger mb-3">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= $_SESSION['error_kode']; unset($_SESSION['error_kode']); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tombol Sign Up -->
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </button>

            <!-- Footer tamai.in -->
            <div class="footer-text">SMKN 1 DENPASAR</div>

            <!-- Link ke login -->
            <div class="login-link">
                Sudah punya akun! <a href="login.php">Login</a>
            </div>
        </form>
    </div>

    <script>
        // Toggle field jurusan/kode guru berdasarkan role
        const roleSelect = document.getElementById('role');
        const guruBox = document.getElementById('guruCode');
        const siswaBox = document.getElementById('siswaJurusan');

        function toggleFields() {
            if (roleSelect.value === 'guru') {
                guruBox.classList.add('show-field');
                siswaBox.classList.remove('show-field');
            } else {
                guruBox.classList.remove('show-field');
                siswaBox.classList.add('show-field');
            }
        }

        // Jalankan saat halaman dimuat
        toggleFields();

        // Jalankan saat role berubah
        roleSelect.addEventListener('change', toggleFields);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>