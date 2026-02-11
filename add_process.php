<?php
session_start();
include "koneksi.php";

// 1. Cek Login Guru
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "guru") {
    header("Location: login.php");
    exit;
}

// 2. Ambil Data dari Form
$title    = $_POST['title'];
$content  = $_POST['content'];
$date     = $_POST['date'];
$kategori = $_POST['kategori'];
$file_db  = null; // Default null jika tidak ada file

// 3. Validasi sederhana
if(empty($title) || empty($content) || empty($date) || empty($kategori)){
    header("Location: tambah_pengumuman.php");
    exit;
}

// 4. Logika Upload File
if (!empty($_FILES['file_lampiran']['name'])) {
    $folder = "uploads/";
    
    // Buat folder jika belum ada
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // Ambil ekstensi dan buat nama unik agar tidak bentrok
    $ekstensi  = pathinfo($_FILES['file_lampiran']['name'], PATHINFO_EXTENSION);
    $nama_baru = time() . "_" . preg_replace("/[^a-zA-Z0-9]/", "_", $title) . "." . $ekstensi;
    $tmp_file  = $_FILES['file_lampiran']['tmp_name'];

    // Pindahkan file dari temp ke folder uploads
    if (move_uploaded_file($tmp_file, $folder . $nama_baru)) {
        $file_db = $nama_baru; // Nama inilah yang masuk ke database
    }
}

// 5. Query Insert (Gunakan Prepared Statement agar aman)
// Pastikan tabel kamu punya kolom 'file_path' atau sesuaikan namanya
$stmt = $koneksi->prepare("INSERT INTO announcements (title, content, date, kategori, file_path) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $title, $content, $date, $kategori, $file_db);

if ($stmt->execute()) {
    // Berhasil, arahkan ke dashboard dengan notifikasi (opsional)
    header("Location: dashboard_guru.php?status=sukses");
} else {
    // Gagal
    echo "Gagal menyimpan data: " . $stmt->error;
}

$stmt->close();
$koneksi->close();
?>