<?php
session_start();
include "koneksi.php";

// Cek login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "guru") {
    header("Location: login.php");
    exit;
}

$koneksi->query("DELETE FROM announcements where id=$_GET[id]");
header("location: dashboard_guru.php");
exit;
?>