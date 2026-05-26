<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "logind"; // <--- PASTIKAN ini sama persis dengan nama database kamu di phpMyAdmin

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>