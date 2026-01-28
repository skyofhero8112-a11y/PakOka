<?php 
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
// Ambil input jurusan, jika tidak ada (misal guru), isi default '-'
$jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '-'; 
$register_code = $_POST['register_code'] ?? "";

// Simpan data lama untuk dikembalikan ke form jika gagal
$_SESSION['old'] = [
    "username" => $username, 
    "role" => $role, 
    "register_code" => $register_code,
    "jurusan" => $jurusan // Tambahkan ini agar pilihan jurusan tidak hilang saat error
];

// --- VALIDASI TAMBAHAN ---

// 1. Cek Duplikat Username
$check = $koneksi->query("SELECT * FROM users WHERE username='$username'");
if ($check->num_rows > 0) {
    $_SESSION['error_username'] = "Username sudah digunakan!";
    header("Location: register.php");
    exit;
}

// 2. Validasi Khusus Guru (Kode Register)
$s = $koneksi->query("SELECT register_code FROM settings WHERE id=1")->fetch_assoc();
if ($role == "guru" && $register_code != $s['register_code']) {
    $_SESSION['error_kode'] = "Kode register guru salah!";
    header("Location: register.php");
    exit;
}

// 3. Validasi Khusus Siswa (Wajib Pilih Jurusan)
if ($role == "siswa" && (empty($jurusan) || $jurusan == "-")) {
    $_SESSION['error_jurusan'] = "Siswa wajib memilih jurusan!";
    header("Location: register.php");
    exit;
}

// Jika role adalah guru, paksa jurusan menjadi 'Umum' atau '-' agar rapi
if ($role == "guru") {
    $jurusan = "Umum";
}

// --- SIMPAN KE DATABASE ---
// Tambahkan kolom 'jurusan' ke dalam query INSERT
$query = "INSERT INTO users (username, password, role, jurusan) VALUES ('$username', '$password', '$role', '$jurusan')";

if ($koneksi->query($query)) {
    unset($_SESSION['old']);
    $_SESSION['success'] = "Register berhasil! Silakan login.";
    header("Location: login.php");
    exit;
} else {
    // Jika query gagal (jarang terjadi, tapi untuk jaga-jaga)
    $_SESSION['error_general'] = "Terjadi kesalahan sistem: " . $koneksi->error;
    header("Location: register.php");
    exit;
}
?>
