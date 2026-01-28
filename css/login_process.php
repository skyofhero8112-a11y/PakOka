<?php
session_start();
include "koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST ['role'];

$check = $koneksi->query("SELECT * FROM users WHERE username='$username' AND role='$role'");
if ($check->num_rows == 0) {
    die("Akun tidak ditemukan!");
}
$user = $check->fetch_assoc();
if ($user['password'] !=$password) {
    die("Password salah!");
}

if ($role == "guru") {
    $_SESSION['temp_user'] = $user;
    header("Location: verify_code.php");
    exit();
}
$_SESSION['user'] = $user;
header("location: dashboard_siswa.php");
?>