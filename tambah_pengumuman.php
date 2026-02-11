<?php
session_start();
include "koneksi.php";

// Cek Login Guru
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Buat Pengumuman - Admin Guru</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; min-height: 100vh; padding: 40px 20px; }
        .container-main { max-width: 850px; margin: 0 auto; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: white; overflow: hidden; }
        .card-header-custom { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 25px; color: white; border-bottom: none; }
        .form-label { font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 8px; }
        .input-group-text { background-color: #f8f9fa; border: 1px solid #ced4da; border-right: none; color: #1e3c72; border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        .form-control, .form-select { border: 1px solid #ced4da; padding: 12px 15px; border-top-right-radius: 10px; border-bottom-right-radius: 10px; font-size: 15px; }
        .form-control:focus, .form-select:focus { box-shadow: none; border-color: #4facfe; }
        .btn-submit { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 600; width: 100%; transition: transform 0.2s; }
        .btn-submit:hover { transform: translateY(-2px); color: white; box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3); }
        .btn-back { color: #6c757d; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container-main">
    <a href="dashboard_guru.php" class="btn-back"><i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard</a>

    <div class="card card-custom">
        <div class="card-header-custom">
            <h4 class="mb-1"><i class="fas fa-edit me-2"></i>Buat Pengumuman Baru</h4>
            <p class="mb-0 small opacity-75">Isi formulir di bawah untuk membagikan informasi kepada siswa.</p>
        </div>
        <div class="card-body p-4 p-md-5">
            
            <form action="add_process.php" method="POST" enctype="multipart/form-data">
                
                <div class="mb-4">
                    <label class="form-label">Judul Pengumuman</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-heading"></i></span>
                        <input type="text" name="title" class="form-control" placeholder="Masukan judul yang menarik..." required>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label">Tanggal Terbit</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                            <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Target Jurusan</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                            <select name="kategori" class="form-select" required style="border-left: none;">
                                <option value="Umum" selected>Semua Jurusan (Umum)</option>
                                <option value="RPL">RPL (Rekayasa Perangkat Lunak)</option>
                                <option value="TKJ">TKJ (Teknik Komputer Jaringan)</option>
                                <option value="MM">Multimedia</option>
                                <option value="AK">Akuntansi</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Isi Pengumuman</label>
                    <textarea name="content" class="form-control" rows="6" placeholder="Tuliskan detail informasi lengkap disini..." style="border-left: 1px solid #ced4da; border-radius: 10px;" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Lampiran Dokumen (PDF/Gambar)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-paperclip"></i></span>
                        <input type="file" name="file_lampiran" class="form-control" style="border-left: none;">
                    </div>
                    <div class="form-text small text-muted">Opsional. Biarkan kosong jika tidak ada lampiran.</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-light text-muted border" style="border-radius: 10px;">Reset</button>
                    <button type="submit" name="submit" class="btn-submit">
                        <i class="fas fa-paper-plane me-2"></i>Publikasikan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>