<?php
// Ganti konfigurasi sesuai server Anda
$host = "localhost";
$user = "root";
$pass = ""; // Jika ada password MySQL, isi di sini
$db   = "food_dss";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>