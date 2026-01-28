<?php
session_start();
include "koneksi.php";

// Cek Login Guru
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "guru") {
    header("Location: login.php");
    exit;
}

// Ambil Data dari Form
$title    = $_POST['title'];
$content  = $_POST['content'];
$date     = $_POST['date'];
$kategori = $_POST['kategori']; // Menangkap data jurusan dari dropdown

// Validasi sederhana
if(empty($title) || empty($content) || empty($date) || empty($kategori)){
    // Bisa tambahkan session error disini jika mau
    header("Location: tambah_pengumuman.php");
    exit;
}

// Query Insert (Dengan Prepared Statement agar aman)
$stmt = $koneksi->prepare("INSERT INTO announcements (title, content, date, kategori) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $content, $date, $kategori);

if ($stmt->execute()) {
    // Berhasil
    header("Location: dashboard_guru.php"); // Kembalikan ke dashboard
} else {
    // Gagal
    echo "Error: " . $stmt->error;
}

$stmt->close();
$koneksi->close();
?>