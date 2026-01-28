<?php
$koneksi = new mysqli("localhost", "root", "", "announcement_center");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error); 
    //Hentikan program dan tampilkan pesan error
    //connect_error = penjelasan kenapa database tidak bisa terkoneksi
}
?>
