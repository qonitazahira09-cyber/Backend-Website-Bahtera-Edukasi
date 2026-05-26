<?php
session_start();
include 'koneksiKA.php'; 

// 1. Ambil data admin untuk foto profil kecil di navbar pojok kanan atas
$_SESSION['id_admin'] = 1; // Sesuaikan dengan session login milikmu
$id_admin = $_SESSION['id_admin'];
$query_admin = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
$data_admin = mysqli_fetch_assoc($query_admin);

// 2. Ambil data ulasan dari database (diurutkan dari yang paling baru masuk)
$query_ulasan = mysqli_query($koneksi, "SELECT * FROM ulasan ORDER BY tanggal_kirim DESC");

$query = "SELECT * FROM ulasan WHERE 1=1";

// 2. Cek apakah ada filter rating yang dipilih
if (isset($_GET['rating']) && $_GET['rating'] != '') {
    $rating = mysqli_real_escape_string($koneksi, $_GET['rating']);
    // Filter berdasarkan angka bintang (misal kolom di database namanya 'bintang' atau 'rating')
    $query .= " AND rating =" . (int)$rating; 
}

// 3. Cek juga jika ada input pencarian teks (optional, untuk kolom 'Cari konten...')
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = mysqli_real_escape_string($koneksi, $_GET['search']);
    $query .= " AND (nama_user LIKE '%$search%' OR komentar LIKE '%$search%')";
}

// 4. Urutkan berdasarkan ulasan terbaru
$query .= " ORDER BY id_ulasan DESC";

// Eksekusi query
$result = mysqli_query($koneksi, $query);
if (!$result) {
    die("Query error: " . mysqli_error($koneksi) . "<br>Query: " . $query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        /* Reset default browser*/
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding-left: 200px;
            background-color: #EBD7C1;
        }

        header {
            background: #6D2323;
            color: #fff;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            justify-content: flex-end;

        }

        header h1 {
            font-size: 24px;
        }

        header nav ul {
            display: flex;
            list-style: none;
        }

        header ul li {
            margin-left: 20px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        header nav ul li a:hover {
            color: #38bdf8;
        }

        #notification-bell img {
            width: 25px;
            height: 25px;
            vertical-align: middle;
        }

        .profile {
            display: flex;
            align-items: center;
        }

        .profile-pic {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 200px;
            height: 100%;
            background-color: #6D2323;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 100;
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

        /* PERBAIKAN 3: Atur tautan agar memenuhi lebar <li> */
        .sidebar ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #903030;
        }

        .nav_logo {
            padding-bottom: 40px;
            height: auto;
        }

        h1 {
            margin-top: 47px;
            margin-bottom: 20px;
            color: #6D2323;
            font-size: 30px;
        }

        /* Judul Utama "Dasbhoard" */
        h1.page-title {
            font-size: 38px;
            font-weight: bold;
            color: #6D2323;
            margin-bottom: 30px;
        }

         /* ======================== */
        /* == FILTER / DROP DOWNS == */
        /* ======================== */

        .content-wrapper {
            margin: 40px;
        }

        .filter-row {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            align-items: center;

        }

        .filter-row input[type="text"] {
            padding: 18px 15px;
            border: none;
            border-radius: 5px;
            background-color: #6D2323;
            color: white;
            flex: 2; /* Agar kolom pencarian lebih lebar */
        }
        
        .filter-row input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .filter-row select, .filter-row button {
            padding: 18px 15px;
            border: none;
            border-radius: 5px;
            background-color: #6D2323;
            color: white;
            cursor: pointer;
            -webkit-appearance: none; /* Hilangkan default styling untuk Safari */
            -moz-appearance: none; /* Hilangkan default styling untuk Firefox */
            appearance: none; /* Hilangkan default styling */
            flex: 1;
            max-width: 200px;
            text-align: left;
        }

        .filter-row button {
            flex: 0 0 auto; /* Ukuran tetap */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 25px;
        }

        /* Ikon Filter */
        .filter-row button::before {
            content: '▼';
            margin-right: 8px;
            font-size: 10px;
        }
        
        .filter-row button:last-child::before {
            content: '🔍'; /* Ganti ikon jika itu tombol Filter */
            margin-right: 8px;
            font-size: 16px;
        }


        /* ======================== */
        /* == LIST ULASAN == */
        /* ======================== */
        
        .review-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .review-card {
            background-color: #FFF;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .reviewer-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ccc;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .reviewer-info h3 {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .rating-stars {
            color: #FFC107; /* Warna Bintang Kuning */
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .review-source {
            font-size: 12px;
            color: #999;
            margin-top: -3px; /* Penyesuaian jarak */
        }

        .review-text {
            font-size: 14px;
            color: #555;
            margin-bottom: 15px;
        }

        .review-actions {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }
        
        .review-actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #6D2323;
            font-size: 18px;
        }
        
        /* Ikon Bendera (Report) */
        .review-actions .report-icon {
            color: #f00; /* Warna merah untuk bendera */
            font-size: 14px;
        }
    </style>

<body>

    <?php if (isset($_SESSION['sukses_update'])): ?>
        <script>
            alert("<?php echo $_SESSION['sukses_update']; ?>");
        </script>
        <?php unset($_SESSION['sukses_update']); ?>
    <?php endif; ?>

    <header>
        <nav>
            <ul>
                <li>
                    <a href="#" id="notification-bell">
                        <img src="aset/bell.png" alt="Notifikasi">
                    </a>
                </li>
                <div id="notification-dropdown" class="hidden"></div>
                
                <li class="profile">
                    <img src="<?php echo (!empty($data_admin['foto']) && file_exists('aset/' . $data_admin['foto'])) ? 'aset/' . $data_admin['foto'] : 'aset/pp.jfif'; ?>" alt="foto-profile" class="profile-pic" style="width:35px; height:35px; border-radius:50%; object-fit:cover;">
                    <span><?php echo htmlspecialchars($data_admin['nama_lengkap']); ?></span>
                </li>
            </ul>
        </nav>
    </header>

    <nav class="sidebar">
        <div class="sidebarH">
            <a href="#">
                <img src="aset/LogoBahtera.png" alt="Logo Bahtera" class="nav_logo">
            </a>
        </div>
        <ul>
            <li><a href="DCadmin.php"> Dashboard</a></li>
            <li><a href="KBadmin.php"> Konten Budaya</a></li>
            <li><a href="URadmin.php" style="font-weight: bold; background: rgba(255,255,255,0.1);"> Ulasan & Rating</a></li>
            <li><a href="Kadmin.php">Kategori</a></li>
            <li><a href="Padmin.php">Profile</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="content-wrapper">

            <h1 class="page-title">Ulasan & Rating</h1>
            <form action="" method="GET" class="filter-row">
            <input type="text" name="search" placeholder="Cari konten..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <select>
                    <option value="">Semua Konten</option>
                    <option value="konten1">Rumah Gadang</option>
                    <option value="konten2">Batik Jawa</option>
                </select>
                <select name="rating">
        <option value="">Semua Rating</option>
        <option value="5" <?= (isset($_GET['rating']) && $_GET['rating'] == '5') ? 'selected' : '' ?>>5 Bintang</option>
        <option value="4" <?= (isset($_GET['rating']) && $_GET['rating'] == '4') ? 'selected' : '' ?>>4 Bintang</option>
        <option value="3" <?= (isset($_GET['rating']) && $_GET['rating'] == '3') ? 'selected' : '' ?>>3 Bintang</option>
        <option value="2" <?= (isset($_GET['rating']) && $_GET['rating'] == '2') ? 'selected' : '' ?>>2 Bintang</option>
        <option value="1" <?= (isset($_GET['rating']) && $_GET['rating'] == '1') ? 'selected' : '' ?>>1 Bintang</option>
    </select>
                <button type="submit" class="btn-filter"> Filter</button>
    </form>

            <div class="review-list">
    <?php 
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) { 
    ?>
        <div class="review-card">
            <div class="review-header">
                <div class="reviewer-info">
                    <h3><?= htmlspecialchars($row['nama_user']); ?></h3>
                    <div class="rating-stars">
                        <?php for ($i = 1; $i <= 5; $i++) echo ($i <= $row['rating']) ? "⭐" : "☆"; ?>
                    </div>
                    <span class="review-source"><?= htmlspecialchars($row['tanggal_kirim']); ?></span>
                        <span class="review-source">Konten: <?= htmlspecialchars($row['nama_konten']); ?></span>

                </div>
            </div>
            <p class="review-text"><?= htmlspecialchars($row['komentar']); ?></p>
        </div>
    <?php 
        }
    } else {
        echo "<p>Tidak ada ulasan yang sesuai.</p>";
    }
    ?>
</div> </div> 
    </div>

    <script>
        document.getElementById('notification-bell').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('notification-dropdown').classList.toggle('hidden');
        });
    </script>


</body>


</html>