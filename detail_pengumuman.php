<?php 
session_start();
include "koneksi.php";

// Cek Login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Query ambil data
$stmt = $koneksi->prepare("SELECT * FROM announcements WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<div style='text-align:center; padding:50px;'>Data tidak ditemukan. <a href='dashboard_siswa.php'>Kembali</a></div>";
    exit;
}
?>

<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <title><?= htmlspecialchars($data['title']) ?></title>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #eaebed;
            margin: 0;
        }

        /* 1. HEADER MEWAH */
        .header-bg {
            background: linear-gradient(135deg, #c0c7cc 0%, #c0c7cc 100%); /* Warna Premium Deep Navy */
            height: 320px;
            padding-top: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Pattern halus di header (Opsional agar tidak polos) */
        .header-bg::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
        }

        .btn-back:hover {
            background: white;
            color: #1e3c72;
            transform: translateY(-2px);
        }

        /* 2. KARTU UTAMA */
        .content-container {
            margin-top: -200px; /* Efek Overlap */
            padding-bottom: 60px;
        }

        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08); /* Bayangan Lembut */
            padding: 50px;
            border: none;
            position: relative;
        }

        /* Badge Kategori */
        .badge-kategori {
            background: #eef2ff;
            color: #4f46e5;
            font-size: 12px;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            margin-bottom: 20px;
        }

        /* Judul & Meta */
        h1.title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 15px;
            line-height: 1.3;
        }

        .meta-info {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 14px;
            color: #64748b;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        .meta-info i { color: #4f46e5; margin-right: 6px; }

        .content-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #475569;
            text-align: justify;
        }

        /* 3. DESAIN LAMPIRAN FILE (Premium Box) */
        .file-attachment {
            margin-top: 40px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .file-attachment:hover {
            border-color: #4f46e5;
            background: #fff;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.1);
            transform: translateY(-2px);
        }

        .file-icon-box {
            width: 50px; height: 50px;
            background: #e0e7ff;
            color: #4f46e5;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
        }

        .file-details h6 { margin: 0; font-weight: 600; color: #1e293b; }
        .file-details span { font-size: 12px; color: #64748b; }

        .btn-download-icon {
            margin-left: auto;
            color: #4f46e5;
            font-size: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-bg { height: 260px; }
            .content-container { margin-top: -100px; }
            .main-card { padding: 30px; }
            h1.title { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

    <div class="header-bg">
        <div class="container">
            <a href="dashboard_siswa.php" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="container content-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-card">
                    
                    <span class="badge-kategori">
                        <?= htmlspecialchars($data['kategori'] ?? 'UMUM') ?>
                    </span>

                    <h1 class="title"><?= htmlspecialchars($data['title']) ?></h1>

                    <div class="meta-info">
                        <div><i class="far fa-calendar-alt"></i> <?= date('d F Y', strtotime($data['date'])) ?></div>
                        <div><i class="far fa-user"></i> Admin Sekolah</div>
                    </div>

                    <div class="content-body">
                        <?= nl2br($data['content']) ?>
                    </div>

                    <?php if (!empty($data['file_path'])) : ?>
                        <a href="uploads/<?= $data['file_path'] ?>" class="text-decoration-none" download>
                            <div class="file-attachment">
                                <div class="file-icon-box">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="file-details">
                                    <h6>Lampiran Dokumen</h6>
                                    <span>Klik untuk mengunduh file</span>
                                </div>
                                <div class="btn-download-icon">
                                    <i class="fas fa-cloud-download-alt"></i>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>