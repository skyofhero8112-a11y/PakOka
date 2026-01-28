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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #3da0f8ff 0%, #00f2fe 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .register-container {
            background: white; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden; max-width: 450px; width: 100%;
            animation: slideUp 0.5s ease-out;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .register-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 40px 30px; text-align: center; color: white;
        }
        .register-header img {
            width: 120px; height: 120px; margin-bottom: 15px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .register-header h2 { margin: 0 0 5px 0; font-size: 28px; font-weight: 600; }
        .register-header p { margin: 0; font-size: 14px; opacity: 0.9; }
        .register-body { padding: 40px 35px; }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; font-size: 14px; }
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #4facfe; font-size: 16px; z-index: 10; }
        .form-control, .form-select {
            width: 100%; padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0; border-radius: 10px;
            font-size: 15px; transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            outline: none; border-color: #4facfe; box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }
        .btn-register {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none; border-radius: 10px; color: white;
            font-size: 16px; font-weight: 600; cursor: pointer;
            transition: all 0.3s ease; margin-top: 10px;
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4); }
        .login-link { text-align: center; margin-top: 25px; padding-top: 25px; border-top: 1px solid #e0e0e0; }
        .login-link a { color: #4facfe; text-decoration: none; font-weight: 600; }
        .login-link a:hover { color: #1e3c72; text-decoration: underline; }

        /* --- LOGIKA TAMPILAN JURUSAN & KODE GURU --- */
        #guruCode, #siswaJurusan {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transition: all 0.4s ease;
            margin-bottom: 0;
        }
        
        /* Class ini ditambahkan lewat JS jika elemen harus muncul */
        .show-field {
            max-height: 170px !important;
            opacity: 1 !important;
            margin-bottom: 25px !important;
        }

        .info-box {
            background: #e3f2fd; border-left: 4px solid #4facfe;
            padding: 12px 15px; border-radius: 8px; margin-bottom: 20px;
            font-size: 13px; color: #1e3c72;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <img src="logo_skensa.png" alt="Logo SMK Negeri 1 Denpasar">
            <h2>Daftar Akun Baru</h2>
            <p>SMK Negeri 1 Denpasar</p>
        </div>
        
        <div class="register-body">
            <form action="register_process.php" method="POST">
                
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" class="form-control" id="username" 
                        name="username" placeholder="Masukkan nama pengguna" 
                        value="<?= $_SESSION['old']['username'] ?? '' ?>" required>
                    </div>
                </div>

                <?php if (isset($_SESSION['error_username'])): ?>
                    <div class="alert alert-danger py-2 fs-6">
                        <?= $_SESSION['error_username']; ?>
                    </div>
                    <?php unset($_SESSION['error_username']); endif; ?>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="form-control" id="password" 
                        name="password" placeholder="Masukkan kata sandi" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Daftar Sebagai</label>
                    <div class="input-group">
                        <i class="fas fa-user-tag"></i>
                        <select class="form-select" id="role" name="role">
                            <option value="siswa" <?= (($_SESSION['old']['role'] ?? '')=='siswa')?'selected':'' ?> >Siswa</option>
                            <option value="guru" <?= (($_SESSION['old']['role'] ?? '')=='guru')?'selected':'' ?> >Guru</option>
                        </select>
                    </div>
                </div>

                <div id="siswaJurusan">
                    <div class="form-group">
                        <label for="jurusan">Pilih Jurusan</label>
                        <div class="input-group">
                            <i class="fas fa-graduation-cap"></i>
                            <select class="form-select" name="jurusan" id="jurusan">
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="RPL" <?= (($_SESSION['old']['jurusan'] ?? '')=='RPL')?'selected':'' ?>>RPL (Rekayasa Perangkat Lunak)</option>
                                <option value="TKJ" <?= (($_SESSION['old']['jurusan'] ?? '')=='TKJ')?'selected':'' ?>>TKJ (Teknik Komputer Jaringan)</option>
                                <option value="MM" <?= (($_SESSION['old']['jurusan'] ?? '')=='MM')?'selected':'' ?>>Multimedia</option>
                                <option value="AK" <?= (($_SESSION['old']['jurusan'] ?? '')=='AK')?'selected':'' ?>>Akuntansi</option>
                            </select>
                        </div>
                    </div>
                    <?php if (isset($_SESSION['error_jurusan'])): ?>
                        <div class="alert alert-danger py-2 fs-6 mb-3">
                            <?= $_SESSION['error_jurusan']; ?>
                        </div>
                        <?php unset($_SESSION['error_jurusan']); ?>
                    <?php endif; ?>
                </div>

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
                                   value="<?= $_SESSION['old']['register_code'] ?? '' ?>" placeholder="Masukkan kode registrasi">
                        </div>
                    </div>
                    <?php if (isset($_SESSION['error_kode'])): ?>
                        <div class="alert alert-danger py-2 fs-6 mb-3">
                            <?= $_SESSION['error_kode']; ?>
                        </div>
                        <?php unset($_SESSION['error_kode']); ?>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>

                <div class="login-link">
                    <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Ambil elemen
        const roleSelect = document.getElementById("role");
        const guruBox = document.getElementById("guruCode");
        const siswaBox = document.getElementById("siswaJurusan");

        // Fungsi untuk mengatur tampilan berdasarkan pilihan
        function toggleFields() {
            if (roleSelect.value === "guru") {
                // Jika Guru: Tampilkan Kode Guru, Sembunyikan Jurusan
                guruBox.classList.add("show-field");
                siswaBox.classList.remove("show-field");
            } else {
                // Jika Siswa: Tampilkan Jurusan, Sembunyikan Kode Guru
                guruBox.classList.remove("show-field");
                siswaBox.classList.add("show-field");
            }
        }

        // Jalankan saat halaman pertama kali dimuat (agar posisi form benar)
        toggleFields();

        // Jalankan setiap kali user mengubah dropdown role
        roleSelect.addEventListener("change", toggleFields);
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>