<?php
session_start();
include 'koneksiKA.php'; // Pastikan koneksi database-mu sudah benar

// Cek apakah ada ID ulasan yang dikirimkan lewat URL
if (isset($_GET['id'])) {
    // Ambil ID dan amankan dari SQL Injection
    $id_ulasan = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Racik query penghapusan data
    $query = "DELETE FROM ulasan WHERE id_ulasan = '$id_ulasan'";
    
    // Eksekusi query ke MariaDB
    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, titip pesan sukses ke session dan balikkan ke halaman ulasan
        $_SESSION['sukses_update'] = "Ulasan berhasil dihapus!";
        header("Location: URadmin.php");
        exit;
    } else {
        echo "Gagal menghapus ulasan: " . mysqli_error($koneksi);
        exit;
    }
} else {
    // Jika diakses langsung tanpa membawa ID, kembalikan ke halaman utama ulasan
    header("Location: URadmin.php");
    exit;
}
?>