<?php
session_start();
include 'koneksiKA.php';

//if (!isset($_SESSION['id_admin'])) {
    //header("Location: ../loginadmin(FIX_MAULANA)/page-loginAdmin.php");
    //exit;
//}

$_SESSION['id_admin']=1;

$id_admin = $_SESSION ['id_admin'];

$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data admin tidak ditemukan di database. Pastikan data dummy sudah diisi.";
    exit;
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
            margin-top: 10px;
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

        /* --- KONTEN UTAMA PROFILE (Baru) --- */
        .content-wrapper {
            padding: 40px;
            background-color: #EBD7C1; 
        }

        .page-title {
            font-size: 38px;
            font-weight: bold;
            color: #6D2323;
            margin-bottom: 30px;
        }

        .profile-container {
            display: grid;
            /* Layout: 350px (kiri) | sisanya (kanan) */
            grid-template-columns: 350px 1fr; 
            gap: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        /* BAGIAN KIRI: INFO PROFIL ADMIN */
        .info-card {
            text-align: center;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 15px auto;
            border: 4px solid #f0f0f0;
            box-shadow: 0 0 0 2px #6D2323; 
        }

        .admin-name {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .admin-email {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .super-admin-tag {
            display: inline-block;
            background-color: #EBD7C1; 
            color: #6D2323; 
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            text-align: left;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #333;
        }
        
        .stat-label {
            font-weight: 600;
            color: #666;
        }

        /* BAGIAN KANAN: FORM EDIT & PASSWORD */
        .form-title {
            font-size: 20px;
            font-weight: 600;
            color: #6D2323;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .form-input, .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: #6D2323;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .input-readonly {
            background-color: #f8f8f8;
            color: #666;
            cursor: default;
        }

        .photo-upload-group {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .current-photo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
        }

        .btn-change-photo {
            background-color: #6D2323;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-change-photo:hover {
            background-color: #903030;
        }

        .btn-primary, .btn-secondary {
            background-color: #6D2323;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        .btn-secondary {
            margin-top: 15px;
        }
        
        .btn-primary:hover, .btn-secondary:hover {
            background-color: #903030;
        }

    </style>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="#" id="notification-bell">
                        <img src="aset/bell.png" alt="Notifikasi">
                    </a></li>
                <div id="notification-dropdown" class="hidden">
                </div>
                <li class="profile">
                    <img src="<?php echo (!empty($data['foto']) && file_exists('aset/' . $data['foto'])) 
    ? 'aset/' . $data['foto'] 
    : 'https://placehold.co/30x30/cccccc/333333?text=P'; ?>" 
    alt="foto-profile" class="profile-pic">
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
            <li><a href="DCadmin.php"> Dashboard</a></li>
            <li><a href="KBadmin.php"> Konten Budaya</a></li>
            <li><a href="URadmin.php"> Ulasan & Rating</a></li>
            <li><a href="Kadmin.php">Kategori</a></li>
            <li><a href="Padmin.php">Profile</a></li>
        </ul>
    </nav>

   <div class="content-wrapper">
        <h1 class="page-title">Profil Admin</h1>

        <div class="profile-container">
            
            <!-- Kolom Kiri: Profil Admin Statis -->
            <div class="col-left">
                <div class="card info-card">
                    
                    <!-- Gambar Profil -->
                    <div class="profile-avatar-wrapper" style="text-align: center; margin-bottom: 20px;">
    <img 
        src="<?php echo (!empty($data['foto']) && file_exists('aset/' . $data['foto'])) ? 'aset/' . $data['foto'] : 'https://placehold.co/120x120/cccccc/333333?text=P'; ?>" 
        alt="Foto Admin Besar" 
        class="main-profile-photo"
        style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #fff; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);"
    >
</div>
                    
                    <h2 class="admin-name"><?php echo htmlspecialchars($data['nama_lengkap']); ?></h2>
                    <p class="admin-email"><?php echo htmlspecialchars($data['email']); ?></p>
                    <span class="super-admin-tag">Super Admin</span>

                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-label">Bergabung</span>
                            <span>Jan 2024</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Konten Dibuat</span>
                            <span>156</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Terakhir Login</span>
                            <span>2 jam lalu</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Edit dan Ganti Password -->
            <div class="col-right">
    
    <form action="proses_profile.php" method="POST" enctype="multipart/form-data">
        
        <div class="card edit-profile-section">
            <div class="form-title">Edit Profil</div>

            <?php if (isset($_SESSION["sukses_update"])): ?>
                <script>
                    alert("<?php echo $_SESSION['sukses_update']; ?>");
                </script>
                <?php 
                unset($_SESSION['sukses_update']); 
                ?>
            <?php endif; ?>

            <div class="form-group">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-input" value="<?php echo $data['nama_lengkap']; ?>">
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input input-readonly" value="<?php echo $data['email']; ?>" readonly>
            </div>
            
            <div class="form-group">
                <label for="bio" class="form-label">Bio</label>
                <textarea id="bio" name="bio" class="form-textarea"><?php echo $data['bio']; ?></textarea>
            </div>

            <div class="form-group">
    <label class="form-label">Foto Profil</label>
    <div class="photo-upload-group" style="display: flex; align-items: center; gap: 15px;">
        
        <img 
            src="<?php echo (!empty($data['foto']) && file_exists('aset/' . $data['foto'])) ? 'aset/' . $data['foto'] : 'https://placehold.co/60x60/cccccc/333333?text=P'; ?>" 
            alt="Foto Profil Admin" 
            id="avatar_preview"
            class="current-photo"
            style="width: 60px; height: 60px; border-radius: 12px; object-fit: cover;"
        >
        
        <button type="button" class="btn-change-photo" onclick="pemicuUpload()">Ganti Foto</button>
        
        <input type="file" id="foto_asli" name="foto_profil" accept="image/*" style="display: none;" onchange="intipGambar(this)">
    </div>
</div>
        
        <div class="card password-section">
            <div class="form-title">Ganti Password</div>

            <div class="form-group">
                <label for="password_saat_ini" class="form-label">Password Saat Ini</label>
                <input type="password" id="password_saat_ini" name="password_saat_ini" class="form-input" placeholder="Kosongkan jika tidak ingin diubah">
            </div>
            
            <div class="form-group">
                <label for="password_baru" class="form-label">Password Baru</label>
                <input type="password" id="password_baru" name="password_baru" class="form-input" placeholder="Kosongkan jika tidak ingin diubah">
            </div>
            
            <div class="form-group">
                <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" id="konfirmasi_password" name="konfirmasi_password" class="form-input" placeholder="Kosongkan jika tidak ingin diubah">
            </div>

            <button class="btn-primary" type="submit" name="simpan" style="margin-top: 20px; width: 100%;">Simpan Perubahan Profil & Password</button>
        </div>

    </form> </div>

</body>
<script>
    document.getElementById('notification-bell').addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah browser scroll ke atas
        document.getElementById('notification-dropdown').classList.toggle('hidden');
    });
    
    function pemicuUpload() {
    // Memaksa klik masuk ke input file rahasia kita
    document.getElementById('foto_asli').click();
}

function intipGambar(input) {
    // Fitur keren tambahan: Mengubah gambar profil langsung di layar saat admin memilih file baru
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar_preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

</script>

</html>