<?php
include "koneksiKA.php";

if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM konten_budaya WHERE id_konten = $id");
    header("Location: KBadmin.php");
    exit();
}

$query = "SELECT konten_budaya.*, kategori.nama_kategori 
          FROM konten_budaya 
          JOIN kategori ON konten_budaya.id_kategori = kategori.id_kategori 
          ORDER BY konten_budaya.id_konten DESC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Konten Budaya</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

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
            justify-content: flex-end;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 200;
        }

        header nav ul { display: flex; list-style: none; }
        header ul li { margin-left: 20px; }
        header nav ul li a { color: #fff; text-decoration: none; transition: 0.3s; }
        header nav ul li a:hover { color: #38bdf8; }

        #notification-bell img { width: 25px; height: 25px; vertical-align: middle; }

        .profile { display: flex; align-items: center; }
        .profile-pic { width: 30px; height: 30px; border-radius: 50%; margin-right: 10px; }

        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 200px; height: 100%;
            background-color: #6D2323;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 100;
        }

        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar ul li { display: block; margin-bottom: 5px; }
        .sidebar ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: background-color 0.3s;
        }
        .sidebar ul li a:hover { background-color: #903030; }

        .nav_logo { padding-bottom: 40px; height: auto; width: 100%; }

        h1 { margin-top: 47px; margin-bottom: 20px; color: #6D2323; font-size: 30px; }
        h1.page-title { font-size: 38px; font-weight: bold; color: #6D2323; margin-bottom: 30px; }

        .content-wrappert {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin: 10px 40px 40px 40px;
        }

        .page-title { margin-right: auto; }

        .header-action { margin-bottom: 30px; }

        .add-content-btn {
            background-color: #6D2323;
            color: white;
            padding: 10px 20px;
            margin-top: 100px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }
        .add-content-btn:hover { background-color: #903030; }

        .filter-bar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #6D2323;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            gap: 10px;
        }

        .filter-group { display: flex; gap: 10px; align-items: center; }

        .search-input {
            background-color: #903030;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            width: 200px;
        }
        .search-input::placeholder { color: rgba(255,255,255,0.7); }

        .filter-dropdown {
            background-color: #903030;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            appearance: none;
        }

        .sort-dropdown { background-color: #6D2323; border: 1px solid #fff; }

        .data-table-container {
            width: 100%;
            background-color: #FFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .data-table-container table { width: 100%; border-collapse: collapse; font-size: 14px; }

        .data-table-container table thead th {
            padding: 12px 10px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-weight: 500;
            color: #333;
        }

        .data-table-container table tbody td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
            display: inline-block;
            text-align: center;
        }
        .badge-status.published { background-color: #d4edda; color: #155724; }
        .badge-status.draft { background-color: #fff3cd; color: #856404; }

        .table-actions { display: flex; gap: 10px; align-items: center; }

        .action-btn {
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.2s;
            display: inline-block;
        }
        .action-btn:hover { transform: scale(1.2); }
    </style>
</head>
<body>

<header>
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

<nav class="sidebar">
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

<div class="content-wrappert">
    <h1 class="page-title">Manajemen Konten Budaya</h1>

    <div class="header-action">
        <a href="tambah_konten.php" class="add-content-btn">+ Tambahkan Konten</a>
    </div>

    <div class="filter-bar">
        <div class="filter-group">
            <input type="text" placeholder="Cari konten..." class="search-input">
        </div>
        <div class="filter-group">
            <select class="filter-dropdown">
                <option>Semua Kategori</option>
                <option>Rumah Adat</option>
                <option>Pakaian Adat</option>
            </select>
            <select class="filter-dropdown">
                <option>Semua Provinsi</option>
                <option>Sumatera Barat</option>
                <option>Jawa Tengah</option>
            </select>
            <select class="filter-dropdown sort-dropdown">
                <option>Urutkan</option>
                <option>Terbaru</option>
                <option>Rating Tertinggi</option>
            </select>
        </div>
    </div>

    <div class="data-table-container">
        <table>
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Provinsi</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?php echo htmlspecialchars($row['judul']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                        <td><?php echo htmlspecialchars($row['provinsi']); ?></td>
                        <td>⭐⭐⭐⭐⭐ 5.0</td>
                        <td>
                            <?php if (strtolower($row['status_konten']) == 'published'): ?>
                                <span class="badge-status published">Published</span>
                            <?php else: ?>
                                <span class="badge-status draft">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="edit_konten.php?id=<?php echo $row['id_konten']; ?>" class="action-btn" title="Edit">📝</a>
                                <a href="KBadmin.php?hapus=<?php echo $row['id_konten']; ?>" class="action-btn" title="Hapus" onclick="return confirm('Yakin ingin menghapus konten \'<?php echo htmlspecialchars($row['judul']); ?>\'?')">🗑️</a>
                                <a href="detail_konten.php?id=<?php echo $row['id_konten']; ?>" class="action-btn" title="Lihat Detail">👁️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 20px; color: #6c757d;">
                            Belum ada konten budaya yang ditambahkan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('notification-bell').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('notification-dropdown').classList.toggle('hidden');
    });
</script>

</body>
</html>