<?php
$host = "localhost"; // Hostname
$user = "root"; // Username phpMyAdmin
$password = ""; // Kosong jika default
$database = "company_db";

$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>