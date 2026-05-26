<?php
session_start();
include 'koneksiKA.php';

// Proteksi halaman admin
if (!isset($_SESSION['admin'])) {
    header("Location: ../loginadmin(FIX_MAULANA)/page-loginAdmin.php");
    exit;
}

// ==========================================
// 1. PROSES TAMBAH KATEGORI (CREATE)
// ==========================================
if (isset($_POST['tambah_kategori'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    if (!empty($nama_kategori)) {
        $query_tambah = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
        if (mysqli_query($koneksi, $query_tambah)) {
            echo "<script>alert('Kategori berhasil ditambahkan!'); window.location='Kadmin.php';</script>";
        } else {
            echo "<script>alert('Gagal menambah kategori: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}

// ==========================================
// 2. PROSES HAPUS KATEGORI (DELETE)
// ==========================================
if (isset($_GET['hapus'])) {
    $id_hapus = (int) $_GET['hapus']; // cast ke int buat keamanan
    $query_hapus = "DELETE FROM kategori WHERE id_kategori = '$id_hapus'";
    if (mysqli_query($koneksi, $query_hapus)) {
        echo "<script>alert('Kategori berhasil dihapus!'); window.location='Kadmin.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus kategori: " . mysqli_error($koneksi) . "');</script>";
    }
}

// ==========================================
// 3. PROSES AMBIL DATA KATEGORI (READ)
// ==========================================
$query_tampil = "SELECT * FROM kategori ORDER BY id_kategori DESC";
$result_kategori = mysqli_query($koneksi, $query_tampil);

//update
// LOGIKA TAMBAH KATEGORI (Milikmu yang sudah jalan)
if (isset($_POST['tambah_kategori'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    // ... query INSERT milikmu ...
}

// LOGIKA EDIT KATEGORI (Tambahkan ini)
if (isset($_POST['edit_kategori'])) {
    $id_kategori = mysqli_real_escape_string($koneksi, $_POST['id_kategori']);
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    
    $query_update = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = '$id_kategori'";
    
    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>alert('Kategori berhasil diperbarui!'); window.location='Kadmin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui kategori: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori - Bahtera Budaya</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #EBD7C1;
            transition: padding-left 0.3s ease;
        }

        /* Header */
        header {
            background: #6D2323;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
            height: 70px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0;
            margin-right: 15px;
            background: transparent;
            border: none;
            -webkit-appearance: none;
            appearance: none;
        }

        .hamburger:focus {
            outline: none;
            box-shadow: none;
        }

        .hamburger svg {
            display: block;
            width: 24px;
            height: 24px;
            color: #fff;
        }

        header h1 {
            font-size: 20px;
        }

        header nav ul {
            display: flex;
            list-style: none;
            align-items: center;
        }

        header ul li {
            margin-left: 15px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        #notification-bell img {
            width: 22px;
            height: 22px;
            vertical-align: middle;
        }

        .profile {
            display: flex;
            align-items: center;
        }

        .profile-pic {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            margin-right: 8px;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 180px;
            height: 100%;
            background-color: #6D2323;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 100;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            display: block !important;
            margin-bottom: 5px;
        }

        .sidebar ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 12px;
            transition: background-color 0.3s;
            font-size: 14px;
            border-radius: 4px;
        }

        .sidebar ul li a:hover {
            background-color: #903030;
        }

        .nav_logo {
            padding-bottom: 30px;
            height: auto;
            max-width: 100%;
        }

        /* Main Content */
        .main-content {
            padding: 20px;
            margin-left: 180px;
            transition: margin-left 0.3s ease;
        }

        .content-wrapper {
            padding: 30px;
        }

        .page-title {
            font-size: 32px;
            font-weight: bold;
            color: #6D2323;
            margin-bottom: 25px;
        }

        /* Form Tambah Kategori */
        .form-section {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .form-section h3 {
            margin-bottom: 15px;
            color: #6D2323;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .form-group input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            width: 100%;
            max-width: 400px;
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #6D2323;
        }

        .btn-simpan {
            background-color: #6D2323;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
            padding: 12px 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-simpan:hover {
            background-color: #903030;
            transform: translateY(-2px);
        }

        /* Grid Kategori */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }

        .category-card {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 160px;
        }

        .category-icon-wrapper {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            background-color: #FFF3F3;
            color: #E74C3C;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .category-card h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
            padding-right: 50px; /* biar tidak ketutup tombol aksi */
        }

        .category-card p {
            font-size: 13px;
            color: #666;
            flex-grow: 1;
        }

        .card-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 5px;
        }

        .card-actions button,
        .card-actions a {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 16px;
            transition: color 0.2s;
            padding: 5px;
            border-radius: 4px;
            text-decoration: none;
        }

        .card-actions button:hover,
        .card-actions a:hover {
            background-color: #F5F5F5;
        }

        /* Pesan kosong */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 15px;
            grid-column: 1 / -1;
        }

        /* Overlay mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 98;
            display: none;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar { width: 160px; }
            .main-content { margin-left: 160px; }
        }

        @media (max-width: 768px) {
            .hamburger { display: flex; }
            .sidebar { width: 220px; transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .content-wrapper { padding: 15px; }
            .page-title { font-size: 24px; }
            .category-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 480px) {
            header { padding: 10px 12px; height: 55px; }
            header h1 { font-size: 16px; }
            .profile span { display: none; }
            .content-wrapper { padding: 10px; }
        }
    </style>
</head>

<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <header>
        <div class="header-left">
            <button class="hamburger" id="hamburger">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17h14M5 12h14M5 7h14"/>
                </svg>
            </button>
            <h1>Bahtera Budaya</h1>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="#" id="notification-bell">
                        <img src="aset/bell.png" alt="Notifikasi">
                    </a>
                </li>
                <li class="profile">
                    <img src="aset/pp.jfif" alt="foto-profile" class="profile-pic">
                    <span>Admin</span>
                </li>
            </ul>
        </nav>
    </header>

    <nav class="sidebar" id="sidebar">
        <div class="sidebarH">
            <a href="#">
                <img src="aset/LogoBahtera.png" alt="Logo Bahtera" class="nav_logo">
            </a>
        </div>
        <ul>
            <li><a href="DCadmin.php">Dashboard</a></li>
            <li><a href="KBadmin.php">Konten Budaya</a></li>
            <li><a href="URadmin.php">Ulasan & Rating</a></li>
            <li><a href="Kadmin.php">Kategori</a></li>
            <li><a href="Padmin.php">Profile</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="content-wrapper">

            <h1 class="page-title">Manajemen Kategori</h1>

            <!-- Form Dinamis Tambah / Edit Kategori -->
            <div class="form-section">
                <h3 id="form-title">Tambah Kategori Baru</h3>
                <form method="POST" action="">
                    <!-- Input Tersembunyi untuk menampung ID saat Mode Edit -->
                    <input type="hidden" id="id_kategori" name="id_kategori" value="">

                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input
                            type="text"
                            id="nama_kategori"
                            name="nama_kategori"
                            placeholder="Contoh: Alat Musik Daerah"
                            required
                        >
                    </div>
                    <button type="submit" id="btn-submit" name="tambah_kategori" class="btn-simpan">
                        + Simpan Kategori
                    </button>
                    <button type="button" id="btn-batal" class="btn-batal" style="display: none; background-color: #6c757d; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; margin-left: 10px;" onclick="resetForm()">
                        Batal
                    </button>
                </form>
            </div>

            <!-- Grid Kartu Kategori dari Database -->
            <div class="category-grid">
                <?php if (mysqli_num_rows($result_kategori) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result_kategori)): 
                        
                        // LOGIKA PENENTUAN IKON BERDASARKAN NAMA KATEGORI
                        $nama_kat_cek = strtolower(trim($row['nama_kategori']));
                        $icon = "📂"; 

                        if (strpos($nama_kat_cek, 'makanan') !== false || strpos($nama_kat_cek, 'kuliner') !== false) {
                            $icon = "🍽️";
                        } elseif (strpos($nama_kat_cek, 'tari') !== false) {
                            $icon = "💃";
                        } elseif (strpos($nama_kat_cek, 'pakaian') !== false || strpos($nama_kat_cek, 'baju') !== false) {
                            $icon = "👕";
                        } elseif (strpos($nama_kat_cek, 'rumah') !== false) {
                            $icon = "🏠";
                        } elseif (strpos($nama_kat_cek, 'musik') !== false || strpos($nama_kat_cek, 'alat musik') !== false) {
                            $icon = "🎵";
                        }
                    ?>
                        <div class="category-card">
                            <div class="category-icon-wrapper"><?php echo $icon; ?></div>
                            <h3><?php echo htmlspecialchars($row['nama_kategori']); ?></h3>
                            <p>Manajemen data konten pelestarian budaya untuk kategori ini.</p>
                            <div class="card-actions">
                                <!-- Mengubah trigger alert menjadi pemanggilan fungsi JavaScript editCategory() -->
                                <button type="button" title="Edit" onclick="editCategory('<?php echo $row['id_kategori']; ?>', '<?php echo htmlspecialchars($row['nama_kategori'], ENT_QUOTES); ?>')">✏️</button>
                                <a
                                    href="Kadmin.php?hapus=<?php echo $row['id_kategori']; ?>"
                                    title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus kategori \'<?php echo htmlspecialchars($row['nama_kategori']); ?>\'?')"
                                >🗑️</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        Belum ada kategori. Tambahkan kategori baru di atas.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        hamburger.addEventListener('click', function () {
            sidebar.classList.toggle('active');
            sidebarOverlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        });

        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('active');
            sidebarOverlay.style.display = 'none';
        });

        document.getElementById('notification-bell').addEventListener('click', function (e) {
            e.preventDefault();
        });

        // Fungsi untuk mengubah Form menjadi Mode Edit
        function editCategory(id, nama) {
            document.getElementById('form-title').innerText = "Edit Kategori";
            document.getElementById('id_kategori').value = id;
            document.getElementById('nama_kategori').value = nama;
            
            const btnSubmit = document.getElementById('btn-submit');
            btnSubmit.name = "edit_kategori"; // Mengubah name POST agar dibaca sebagai proses edit di PHP
            btnSubmit.innerText = "💾 Update Kategori";
            
            // Tampilkan tombol batal
            document.getElementById('btn-batal').style.display = "inline-block";
            
            // Scroll otomatis ke bagian form agar admin langsung tahu formnya berubah
            document.querySelector('.form-section').scrollIntoView({ behavior: 'smooth' });
        }

        // Fungsi untuk mengembalikan Form ke Mode Tambah (Default)
        function resetForm() {
            document.getElementById('form-title').innerText = "Tambah Kategori Baru";
            document.getElementById('id_kategori').value = "";
            document.getElementById('nama_kategori').value = "";
            
            const btnSubmit = document.getElementById('btn-submit');
            btnSubmit.name = "tambah_kategori";
            btnSubmit.innerText = "+ Simpan Kategori";
            
            // Sembunyikan kembali tombol batal
            document.getElementById('btn-batal').style.display = "none";
        }
    </script>

</body>
</html>