<?php
// 1. Hubungkan ke file koneksi databasemu
// Sesuaikan nama file koneksi jika berbeda, misalnya 'koneksi.php' atau '../config.php'
include "koneksiKA.php"; 

if (isset($_POST['simpan_konten'])) {
    // 2. Ambil data dari form dan amankan dari SQL Injection
    $judul         = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $id_kategori   = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $provinsi      = mysqli_real_escape_string($koneksi, $_POST['provinsi']);
    $deskripsi     = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $status_konten = mysqli_real_escape_string($koneksi, $_POST['status_konten']);

    // 3. Proses Upload Gambar
    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_gambar  = $_FILES['gambar']['tmp_name'];
    
    // Tentukan folder tujuan penyimpanan gambar (pastikan folder 'aset' sudah ada)
    $folder_tujuan = "asetKB/" . $nama_gambar;

    // Pindahkan file gambar dari temporary folder ke folder aset proyekmu
    if (move_uploaded_file($tmp_gambar, $folder_tujuan)) {
        
        // 4. Jalankan Query INSERT ke database jika gambar berhasil diupload
        // Sesuaikan 'konten_budaya' dengan nama tabel aslimu di database
        $query_tambah = "INSERT INTO konten_budaya (judul, id_kategori, provinsi, deskripsi, gambar, status_konten) 
                         VALUES ('$judul', '$id_kategori', '$provinsi', '$deskripsi', '$nama_gambar', '$status_konten')";

        if (mysqli_query($koneksi, $query_tambah)) {
            // Jika berhasil, munculkan alert dan langsung arahkan kembali ke halaman utama tabel konten
            echo "<script>
                    alert('Konten Budaya baru berhasil ditambahkan!');
                    window.location.href='KBadmin.php';
                  </script>";
        } else {
            // Jika query database gagal
            echo "<script>alert('Gagal menyimpan data ke database: " . mysqli_error($koneksi) . "');</script>";
        }

    } else {
        // Jika proses upload file ke folder gagal
        echo "<script>alert('Gagal mengupload gambar. Pastikan folder aset sudah tersedia.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Konten Budaya - Bahtera Budaya</title>
    <!-- Masukkan link CSS menumu di sini atau gunakan style bawaan -->
    <style>
        /* CSS Tambahan Khusus Form */
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            max-width: 700px;
            margin: 20px auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #495057;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }
        .btn-row {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }
        .btn-submit {
            background-color: #802424; /* Sesuaikan warna tema Bahtera Budaya */
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-kembali {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Taruh Kodingan Header & Sidebar Kamu di Sini -->

    <div class="content-wrapper" style="padding: 20px;">
        <h1 class="page-title" style="text-align: center;">Tambah Konten Budaya Baru</h1>

        <div class="form-container">
            <!-- PENTING: Gunakan enctype="multipart/form-data" karena ada input file/gambar -->
            <form method="POST" action="" enctype="multipart/form-data">
                
                <!-- 1. Input Judul Konten -->
                <div class="form-group">
                    <label for="judul">Judul Konten</label>
                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Contoh: Rumah Gadang / Tari Saman" required>
                </div>

                <!-- 2. Dropdown Kategori (Dinamis dari Database Kategori) -->
                <div class="form-group">
                    <label for="id_kategori">Kategori</label>
                    <select id="id_kategori" name="id_kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        // Memanggil koneksi databasemu (sesuaikan nama filenya)
                        // include "koneksi.php";
                        
                        // Menampilkan kategori secara dinamis dari database hasil kerjaan kemarin
                        $query_kat = mysqli_query($koneksi, "SELECT * FROM kategori");
                        while($kat = mysqli_fetch_assoc($query_kat)) {
                            echo "<option value='".$kat['id_kategori']."'>".$kat['nama_kategori']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- 3. Input Provinsi -->
                <div class="form-group">
                    <label for="provinsi">Provinsi Asal</label>
                    <input type="text" id="provinsi" name="provinsi" class="form-control" placeholder="Contoh: Sumatera Barat" required>
                </div>

                <!-- 4. Input Deskripsi -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi Lengkap Budaya</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" placeholder="Tuliskan sejarah, keunikan, atau detail budaya di sini..." required></textarea>
                </div>

                <!-- 5. Input Upload Gambar -->
                <div class="form-group">
                    <label for="gambar">Foto / Gambar Konten</label>
                    <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*" required>
                </div>

                <!-- 6. Pilihan Status -->
                <div class="form-group">
                    <label for="status_konten">Status Publikasi</label>
                    <select id="status_konten" name="status_konten" class="form-control">
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                </div>

                <!-- Tombol Aksi -->
                <div class="btn-row">
                    <button type="submit" name="simpan_konten" class="btn-submit">Simpan Konten</button>
                    <a href="KBadmin.php" class="btn-kembali">Kembali</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>