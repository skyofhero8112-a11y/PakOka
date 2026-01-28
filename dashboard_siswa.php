<?php 
session_start();
include "koneksi.php";

// 1. Cek Login Siswa
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "siswa") {
    header("Location: login.php");
    exit;
}

// 2. LOGIKA PENCARIAN & FILTER (SINKRON)
// Ambil data dari URL (jika ada)
$keyword  = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$tanggal  = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

// Query Dasar (WHERE 1=1 adalah trik agar mudah menyambung AND)
$sql = "SELECT * FROM announcements WHERE 1=1";
$params = [];
$types = "";

// Jika user mengetik kata kunci
if (!empty($keyword)) {
    $sql .= " AND (title LIKE ? OR content LIKE ?)";
    $paramKeyword = "%" . $keyword . "%";
    $params[] = $paramKeyword;
    $params[] = $paramKeyword;
    $types .= "ss";
}

// Jika user memilih Kategori/Jurusan
if (!empty($kategori)) {
    $sql .= " AND kategori = ?";
    $params[] = $kategori;
    $types .= "s";
}

// Jika user memilih Tanggal
if (!empty($tanggal)) {
    $sql .= " AND date = ?";
    $params[] = $tanggal;
    $types .= "s";
}

$sql .= " ORDER BY date DESC, id DESC"; // Urutkan dari tanggal terbaru

// Eksekusi Query dengan Aman (Prepared Statement)
$stmt = $koneksi->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Dashboard Siswa - Sistem Pengumuman</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            min-height: 100vh;
            padding-bottom: 40px;
        }

        /* NAVBAR */
        .navbar-custom {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 11px 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand { color: white !important; font-weight: 600; font-size: 20px; }
        .navbar-brand img { width: 75px; height: 75px; margin-right: 10px; }
        .btn-logout {
            background: rgba(255, 255, 255, 0.2); color: white;
            border: 1px solid rgba(255, 255, 255, 0.3); padding: 8px 20px;
            border-radius: 8px; font-size: 14px; text-decoration: none; transition: 0.3s;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.3); transform: translateY(-2px); }

        .container-main { max-width: 1200px; margin: 0 auto; padding: 30px 20px; }
        .page-title { text-align: center; color: #0a1f44; font-weight: 700; font-size: 32px; margin-bottom: 30px; }

        /* FILTER CARD */
        .filter-card {
            background: white; padding: 25px; border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 30px;
        }
        .btn-search {
            background-color: #1e3c72; color: white; border: none;
            border-radius: 8px; padding: 10px 20px; width: 100%; font-weight: 600;
        }
        .btn-search:hover { background-color: #162d55; }
        
        /* CARD BERITA */
        .news-card {
            background: #fff; border: none; border-radius: 12px;
            overflow: hidden; height: 100%; display: flex; flex-direction: column;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s;
        }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        
        .card-img-wrapper {
            height: 180px; background: #e9ecef; position: relative;
        }
        .card-img-top { width: 100%; height: 100%; object-fit: cover; }
        
        .badge-kategori {
            position: absolute; top: 15px; right: 15px;
            background: rgba(30, 60, 114, 0.9); color: white;
            padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: bold;
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        .card-body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
        .meta-date { font-size: 13px; color: #6c757d; margin-bottom: 10px; }
        .meta-date i { color: #4facfe; margin-right: 5px; }
        
        .news-title {
            color: #0a1f44; font-size: 18px; font-weight: 700; line-height: 1.4; margin-bottom: 10px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .news-content {
            font-size: 14px; color: #666; margin-bottom: 15px;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        }
        
        /* Empty State */
        .empty-state { text-align: center; padding: 60px 20px; grid-column: 1/-1; }
        .empty-state i { font-size: 50px; color: #ddd; margin-bottom: 15px; }
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
                <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container-main">
        <h2 class="page-title">Berita & Pengumuman</h2>

        <div class="filter-card">
            <form action="" method="GET">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label small text-muted">Cari Judul/Isi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            <input type="text" name="keyword" class="form-control" placeholder="Masukan kata kunci..." value="<?= htmlspecialchars($keyword) ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small text-muted">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Umum" <?= $kategori == 'Umum' ? 'selected' : '' ?>>Umum</option>
                            <option value="RPL" <?= $kategori == 'RPL' ? 'selected' : '' ?>>RPL</option>
                            <option value="TKJ" <?= $kategori == 'TKJ' ? 'selected' : '' ?>>TKJ</option>
                            <option value="MM" <?= $kategori == 'MM' ? 'selected' : '' ?>>Multimedia</option>
                            <option value="AK" <?= $kategori == 'AK' ? 'selected' : '' ?>>Akuntansi</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label small text-muted">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= htmlspecialchars($tanggal) ?>">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn-search">Filter Data</button>
                    </div>
                </div>
                
                <?php if(!empty($keyword) || !empty($kategori) || !empty($tanggal)) : ?>
                    <div class="mt-3 text-center">
                        <a href="dashboard_siswa.php" class="text-decoration-none text-muted small">
                            <i class="fas fa-undo"></i> Reset Filter
                        </a>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <div class="row g-4">
            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
                    // Format Tanggal Indonesia
                    $tgl = date('d F Y', strtotime($row['date']));
                    
                    // Gambar Placeholder (Karena belum ada kolom gambar di DB)
                    // Jika nanti mau nambah kolom gambar, ganti baris ini.
                    $gambar = "https://placehold.co/600x400/1e3c72/ffffff?text=" . urlencode(substr($row['title'], 0, 20));
                    
                    // Cek Kategori (Default 'Umum' jika kosong)
                    $cat = !empty($row['kategori']) ? $row['kategori'] : 'Umum';
            ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="news-card">
                    <div class="card-img-wrapper">
                        <img src="<?= $gambar ?>" class="card-img-top" alt="News">
                        <span class="badge-kategori"><?= htmlspecialchars($cat) ?></span>
                    </div>
                    <div class="card-body">
                        <div class="meta-date">
                            <i class="far fa-calendar-alt"></i> <?= $tgl ?>
                        </div>
                        <h3 class="news-title"><?= htmlspecialchars($row['title']) ?></h3>
                        <div class="news-content">
                            <?= substr(strip_tags($row['content']), 0, 100) ?>...
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                } 
            } else { 
            ?>
            <div class="empty-state">
                <i class="fas fa-search-minus"></i>
                <h3>Data Tidak Ditemukan</h3>
                <p class="text-muted">Tidak ada pengumuman yang sesuai dengan filter pencarian Anda.</p>
            </div>
            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>