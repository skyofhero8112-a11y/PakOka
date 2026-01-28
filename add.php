<?php
session_start();
include "koneksi.php";

// Cek apakah user sudah login dan role guru
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "guru") {
    header("Location: login.php");
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
    <title>Tambah Pengumuman - Sistem Pengumuman Sekolah</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 30px 20px;
        }

        .container-main {
            max-width: 800px;
            margin: 0 auto;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #1e3c72;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            color: #4facfe;
            transform: translateX(-5px);
        }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
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

        .form-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .form-header h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .form-header p {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .form-body {
            padding: 40px 35px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        textarea.form-control {
            min-height: 150px;
            resize: vertical;
        }

        input[type="date"].form-control {
            padding: 12px 15px;
        }

        .btn-submit {
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 172, 254, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .info-box {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #2e7d32;
        }

        .info-box i {
            margin-right: 8px;
            color: #4caf50;
        }

        @media (max-width: 768px) {
            .form-body {
                padding: 30px 25px;
            }

            .form-header h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container-main">
        <a href="dashboard_guru.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>

        <div class="form-container">
            <div class="form-header">
                <h2>
                    <i class="fas fa-plus-circle"></i>
                    Tambah Pengumuman Baru
                </h2>
                <p>Buat pengumuman untuk siswa</p>
            </div>

            <div class="form-body">
                <div class="info-box">
                    <i class="fas fa-lightbulb"></i>
                    <strong>Tips:</strong> Pastikan judul singkat dan jelas, isi pengumuman lengkap dan mudah dipahami
                </div>

                <form action="add_process.php" method="POST">
                    <div class="form-group">
                        <label for="title">
                            <i class="fas fa-heading"></i> Judul Pengumuman
                        </label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Contoh: Libur Semester Genap 2024" required>
                    </div>

                    <div class="form-group">
                        <label for="date">
                            <i class="fas fa-calendar-alt"></i> Tanggal
                        </label>
                        <input type="date" class="form-control" id="date" name="date" 
                        value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="content">
                            <i class="fas fa-align-left"></i> Isi Pengumuman
                        </label>
                        <textarea class="form-control" id="content" name="content" placeholder="Tulis detail pengumuman di sini..." required></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Simpan Pengumuman
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>