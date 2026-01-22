<?php
// Konfigurasi Database
$host     = "localhost";
$username = "root";
$password = "myredi";
$database = "tiket_db";

// Membuat Koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek Koneksi
if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// Opsional: Set character set ke utf8 agar mendukung simbol mata uang/karakter khusus
mysqli_set_charset($conn, "utf8");
?>