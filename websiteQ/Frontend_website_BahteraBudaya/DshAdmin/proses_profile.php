<?php
session_start();
include 'koneksiKA.php'; 

if (isset($_POST['simpan'])) {
    
    $id_admin = $_SESSION['id_admin'];
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $bio = mysqli_real_escape_string($koneksi, $_POST['bio']); 
    
    $password_baru = isset($_POST['password_baru']) ? $_POST['password_baru'] : '';

    // --- PROSES OLAH DATA FOTO PROFIL ---
    $nama_foto_baru = ""; 
    
    if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] === 0) {
        $file_name = $_FILES['foto_profil']['name'];
        $file_tmp  = $_FILES['foto_profil']['tmp_name'];
        
        $ekstensi_valid = ['jpg', 'jpeg', 'png'];
        $ekstensi_file  = explode('.', $file_name);
        $ekstensi_file  = strtolower(end($ekstensi_file));
        
        if (in_array($ekstensi_file, $ekstensi_valid)) {
            // Unikkan nama gambar agar tidak saling menimpa
            $nama_foto_baru = uniqid() . '_' . $file_name;
            
            // JALUR AMAN: Cek apakah folder 'aset' sudah ada, jika belum buat otomatis
            if (!is_dir('aset')) {
                mkdir('aset', 0777, true);
            }
            
            // Pindahkan file gambar asli ke folder 'aset'
            move_uploaded_file($file_tmp, 'aset/' . $nama_foto_baru);
        }
    }
    // ------------------------------------

    // Menyusun pondasi Query Update
    if (!empty($password_baru)) {
        $password_hashed = password_hash($password_baru, PASSWORD_DEFAULT);
        
        $query = "UPDATE admin SET 
                    nama_lengkap = '$nama_lengkap', 
                    email = '$email', 
                    bio = '$bio',
                    password = '$password_hashed'";
    } else {
        $query = "UPDATE admin SET 
                    nama_lengkap = '$nama_lengkap', 
                    email = '$email',
                    bio = '$bio'";
    }

    // Sambungkan kolom foto ke query jika admin mengganti gambar
    if (!empty($nama_foto_baru)) {
        $query .= ", foto = '$nama_foto_baru'";
    }

    // Selesaikan query dengan pengunci ID
    $query .= " WHERE id_admin = '$id_admin'";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['sukses_update'] = "Profil berhasil diperbarui!";
        header("Location: Padmin.php");
        exit;
    } else {
        echo "Gagal memperbarui profil: " . mysqli_error($koneksi);
        exit;
    }
}
?>