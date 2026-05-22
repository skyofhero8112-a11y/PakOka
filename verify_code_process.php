<?php
session_start();
include "koneksi.php";

$secret = $_POST['secret'];
$s = $koneksi->query("SELECT secret_code FROM settings WHERE id=1")->fetch_assoc();

if ($secret != $s['secret_code']) {
    die("Kode rahasia salah!");
}

$_SESSION['user'] = $_SESSION['temp_user'];
unset($_SESSION['temp_user']);
header("Location: dashboard_guru.php");
?>