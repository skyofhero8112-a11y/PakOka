<?php
session_start();
include "koneksi.php";

// Cek sesi login guru
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "guru") {
    header("Location: login.php");
    exit; 
}

$data = $koneksi->query("SELECT * FROM announcements ORDER BY date DESC, id DESC");
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Dashboard Guru - Sistem Pengumuman</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f6;
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* Navbar & Header Style - Sama seperti sebelumnya */
        .navbar-custom { background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 11px 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .navbar-brand { color: white !important; font-weight: 600; font-size: 20px; }
        .navbar-brand img { width: 50px; height: 50px; margin-right: 10px; }
        .btn-logout { background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3); padding: 8px 20px; border-radius: 8px; text-decoration: none; transition: 0.3s; }
        .btn-logout:hover { background: rgba(255,255,255,0.3); transform: translateY(-2px); }

        .container-main { max-width: 1200px; margin: 0 auto; padding: 20px; }

        .header-section {
            background: white; padding: 30px; border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;
            margin-bottom: 30px; border-left: 5px solid #4facfe;
        }
        .header-info h2 { color: #1e3c72; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 10px; }
        .btn-add {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white;
            padding: 12px 25px; border-radius: 10px; text-decoration: none; font-weight: 600;
            display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(30, 60, 114, 0.3);
        }
        .btn-add:hover { transform: translateY(-3px); color: white; box-shadow: 0 8px 20px rgba(30, 60, 114, 0.4); }

        /* Card Style Terbaru */
        .announcement-card {
            background: white; border-radius: 15px; overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: transform 0.3s;
            height: 100%; display: flex; flex-direction: column; position: relative;
        }
        .announcement-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        
        .card-img-top { width: 100%; height: 160px; object-fit: cover; background-color: #eee; }
        
        .badge-kategori {
            position: absolute; top: 15px; right: 15px;
            background: rgba(30, 60, 114, 0.95); color: white;
            padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: bold;
            text-transform: uppercase; letter-spacing: 0.5px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .announcement-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
        
        .meta-date { font-size: 12px; color: #6c757d; margin-bottom: 8px; display: flex; align-items: center; gap: 5px; }
        .meta-date i { color: #4facfe; }

        .card-title { color: #1e3c72; font-size: 18px; font-weight: 700; margin-bottom: 10px; line-height: 1.4; }
        .card-text { font-size: 14px; color: #555; margin-bottom: 20px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex: 1; }

        .action-buttons { display: flex; gap: 10px; border-top: 1px solid #eee; padding-top: 15px; }
        .btn-action { flex: 1; text-align: center; padding: 8px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; transition: 0.2s; }
        .btn-edit { background: #e3f2fd; color: #1e3c72; }
        .btn-edit:hover { background: #bbdefb; }
        .btn-delete { background: #ffebee; color: #c62828; }
        .btn-delete:hover { background: #ffcdd2; }

        .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 15px; width: 100%; grid-column: 1/-1; }
        .empty-state i { font-size: 50px; color: #ddd; margin-bottom: 20px; }
    </style>
</head>
<body>
    <nav class="navbar-custom">
        <div class="container-main" style="padding: 0;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="navbar-brand d-flex align-items-center">
                    <img src="logo_skensa.png" alt="Logo">
                    SMK Negeri 1 Denpasar
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white small d-none d-md-block">Halo, Guru</span>
                    <a href="index.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-main">
        <div class="header-section">
            <div class="header-info">
                <h2><i class="fas fa-chalkboard-teacher"></i> Dashboard Guru</h2>
                <p class="text-muted m-0 small">Kelola informasi sekolah dan jurusan</p>
            </div>
            <a href="tambah_pengumuman.php" class="btn-add">
                <i class="fas fa-plus-circle"></i> Tambah Pengumuman
            </a>
        </div>

        <div class="row g-4">
            <?php 
            $count = 0;
            if ($data->num_rows > 0) {
                while($row = $data->fetch_assoc()) { 
                    $count++;
                    $tgl = date('d M Y', strtotime($row['date']));
                    // Kategori (default Umum jika kosong)
                    $kategori = !empty($row['kategori']) ? $row['kategori'] : 'Umum';
                    // Gambar Placeholder
                    $gambar = "https://placehold.co/600x400/1e3c72/ffffff?text=" . urlencode($row['title']);
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="announcement-card">
                    <div style="position: relative;">
                        <img src="<?= $gambar ?>" class="card-img-top" alt="Cover">
                        <span class="badge-kategori"><?= htmlspecialchars($kategori) ?></span>
                    </div>
                    
                    <div class="announcement-body">
                        <div class="meta-date">
                            <i class="far fa-calendar-alt"></i> <?= $tgl ?>
                        </div>
                        <h3 class="card-title"><?= htmlspecialchars($row['title']) ?></h3>
                        <div class="card-text">
                            <?= strip_tags($row['content']) ?>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn-action btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn-action btn-delete" onclick="return confirm('Hapus pengumuman ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                } 
            } else { 
            ?>
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h3>Belum Ada Pengumuman</h3>
                <p>Silakan buat pengumuman baru untuk siswa.</p>
                <a href="tambah_pengumuman.php" class="btn-add mt-3">
                    <i class="fas fa-plus-circle"></i> Buat Sekarang
                </a>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 