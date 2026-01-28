<?php
session_start();
include "koneksi.php";

// Cek login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != "guru") {
    header("Location: login.php");
    exit;
}

$koneksi->query("UPDATE announcements SET title='$_POST[title]', date='$_POST[date]', content='$_POST[content]' WHERE id=$_POST[id]");
header("Location: dashboard_guru.php");
exit;
?>