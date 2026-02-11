<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Ekskul SMKN 1 Denpasar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .hero-section {
    background: linear-gradient(135deg, #1e4572 0%, #003366 100%);
    color: white;
    padding: 100px 0;
    min-height: 60vh;
    display: flex;
    align-items: center;
    }
    
    .hero-content {
        text-align: center;
        width: 100%;
    }
    
    .hero-section h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }
    
    .hero-section h2 {
        font-size: 2rem;
        margin-bottom: 1.5rem;
        font-weight: 500;
    }
    
    .hero-section .lead {
        font-size: 1.25rem;
        margin-bottom: 2.5rem;
        opacity: 0.95;
    }
    .navbar-nav .nav-link {
        font-size: 1.1rem;
        margin-right: 2rem;
    }
    .hero-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .feature-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 15px;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
    }
    
    .feature-card i {
        font-size: 3rem;
    }
    .navbar-brand img {
    width: 70px;
    height: 70px;
    margin-right: 12px;
    animation: bounce 2s infinite;
    }
    .navbar-brand {
        display: flex;
        align-items: center;
        font-weight: 500;
        font-size: 1rem;
    }
    
    
    /* Responsive */
    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2.5rem;
        }
        
        .hero-section h2 {
            font-size: 1.5rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .hero-buttons .btn {
            width: 80%;
            max-width: 300px;
        }
    }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img src="logo_skensa.png" alt="SMKN 1 Denpasar Logo"> SMKN 1 Denpasar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">  Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2" href="register.php">Daftar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">SISTEM INFORMASI SEKOLAH</h1>
            <h2 class="h3 mb-4">SMKN 1 Denpasar</h2>
            <p class="lead mb-5">Kelola dan pantau kegiatan ekstrakurikuler dan informasi sekolah</p>
            <a href="register.php" class="btn btn-light btn-lg me-3"><i class="fas fa-user-plus"></i> Daftar Sekarang</a>
            <a href="login.php" class="btn btn-outline-light btn-lg"><i class="fas fa-sign-in-alt"></i> Login</a>
        </div>
    </section>

    <!-- Features -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fitur Unggulan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 text-center p-4 border-0 shadow">
                        <div class="card-body">
                            <i class="fas fa-clipboard-list fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Pendaftaran Online</h5>
                            <p class="card-text">Daftar ekskul favorit dengan mudah dan cepat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 text-center p-4 border-0 shadow">
                        <div class="card-body">
                            <i class="fas fa-trophy fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Catat Prestasi</h5>
                            <p class="card-text">Dokumentasikan setiap prestasi yang diraih</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 text-center p-4 border-0 shadow">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Dashboard Laporan</h5>
                            <p class="card-text">Pantau statistik dan perkembangan ekskul</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4">
        <p class="mb-0">&copy; 2024 SMKN 1 Denpasar. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
