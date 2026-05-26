<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Profil Admin - Sistem Manajemen Bahtera">
    <title>Profil Admin - Bahtera</title>
    <style>
        /* =========================================== */
        /* RESET BROWSER DEFAULT */
        /* Menghapus margin dan padding bawaan browser */
        /* =========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* =========================================== */
        /* BODY & LAYOUT UTAMA */
        /* Mengatur font, warna, dan spacing utama halaman */
        /* =========================================== */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding-left: 200px;
            background-color: #EBD7C1;
            transition: padding-left 0.3s ease;
        }

        /* =========================================== */
        /* HEADER NAVIGATION */
        /* Bar navigasi atas dengan notifikasi dan profile */
        /* =========================================== */
        header {
            background: #6D2323;
            color: #fff;
            padding: 20px 50px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        header nav ul {
            display: flex;
            list-style: none;
            align-items: center;
            gap: 20px;
        }

        header ul li {
            margin-left: 0;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
        }

        header nav ul li a:hover {
            color: #38bdf8;
        }

        /* =========================================== */
        /* HAMBURGER MENU BUTTON */
        /* Tombol hamburger untuk mobile (hidden di desktop) */
        /* =========================================== */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0;
            margin-right: auto;
            z-index: 101;
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

        .hamburger span {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 3px 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(8px, 8px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* =========================================== */
        /* NOTIFICATION BELL */
        /* Icon notifikasi di header */
        /* =========================================== */
        #notification-bell img {
            width: 25px;
            height: 25px;
            vertical-align: middle;
        }

        #notification-dropdown {
            position: absolute;
            top: 60px;
            right: 100px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 250px;
            padding: 15px;
            color: #333;
        }

        .hidden {
            display: none;
        }

        /* =========================================== */
        /* PROFILE SECTION */
        /* Menampilkan foto profil dan nama admin */
        /* =========================================== */
        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-pic {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* =========================================== */
        /* SIDEBAR NAVIGATION */
        /* Menu navigasi samping kiri (fixed position) */
        /* =========================================== */
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
            transition: transform 0.3s ease;
            will-change: transform;
            -webkit-overflow-scrolling: touch;
        }

        .sidebarH {
            margin-bottom: 40px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            display: block;
            margin-bottom: 5px;
        }

        .sidebar ul li a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: background-color 0.3s ease;
            border-radius: 4px;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a[aria-current="page"] {
            background-color: #903030;
        }

        .nav_logo {
            width: 100%;
            height: auto;
        }

        /* =========================================== */
        /* OVERLAY untuk Mobile */
        /* Lapisan gelap saat sidebar terbuka di mobile */
        /* =========================================== */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            opacity: 0;
            transition: opacity 0.3s ease;
            will-change: opacity;
            -webkit-tap-highlight-color: transparent;
        }

        .overlay.active {
            display: block;
            opacity: 1;
        }

        /* =========================================== */
        /* CONTENT WRAPPER */
        /* Container utama untuk konten profil */
        /* =========================================== */
        .content-wrapper {
            padding: 40px;
            background-color: #EBD7C1;
            min-height: 100vh;
        }

        .page-title {
            font-size: 38px;
            font-weight: bold;
            color: #6D2323;
            margin-bottom: 30px;
        }

        /* =========================================== */
        /* PROFILE CONTAINER */
        /* Layout grid untuk info profil dan form */
        /* =========================================== */
        .profile-container {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            max-width: 1200px;
            margin: auto;
        }

        /* =========================================== */
        /* CARD COMPONENT */
        /* Komponen card untuk wrapper konten */
        /* =========================================== */
        .card {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        /* =========================================== */
        /* INFO CARD (Kolom Kiri) */
        /* Kartu informasi profil admin */
        /* =========================================== */
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
            word-break: break-word;
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

        /* =========================================== */
        /* STATS GRID */
        /* Grid statistik admin */
        /* =========================================== */
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
            flex-direction: column;
            font-size: 14px;
            color: #333;
        }

        .stat-label {
            font-weight: 600;
            color: #666;
            margin-bottom: 3px;
        }

        /* =========================================== */
        /* FORM SECTION (Kolom Kanan) */
        /* Form edit profil dan ganti password */
        /* =========================================== */
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

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: Arial, sans-serif;
        }

        .form-input:focus,
        .form-textarea:focus {
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
            cursor: not-allowed;
        }

        /* =========================================== */
        /* PHOTO UPLOAD GROUP */
        /* Section untuk ganti foto profil */
        /* =========================================== */
        .photo-upload-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .current-photo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
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

        /* =========================================== */
        /* BUTTONS */
        /* Tombol primary dan secondary */
        /* =========================================== */
        .btn-primary,
        .btn-secondary {
            background-color: #6D2323;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
            width: 100%;
        }

        .btn-secondary {
            margin-top: 15px;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            background-color: #903030;
        }

        /* =========================================== */
        /* RESPONSIVE DESIGN - TABLET (768px - 1024px) */
        /* Layout untuk tablet */
        /* =========================================== */
        @media (max-width: 1024px) {
            body {
                padding-left: 180px;
            }

            .sidebar {
                width: 180px;
            }

            header {
                padding: 15px 30px;
            }

            .content-wrapper {
                padding: 30px;
            }

            .page-title {
                font-size: 32px;
            }

            .profile-container {
                grid-template-columns: 300px 1fr;
                gap: 25px;
            }
        }

        /* =========================================== */
        /* RESPONSIVE DESIGN - MOBILE (max-width: 768px) */
        /* Layout untuk smartphone dengan hamburger menu */
        /* =========================================== */
        @media (max-width: 768px) {
            body {
                padding-left: 0;
            }

            /* Tampilkan hamburger button */
            .hamburger {
                display: flex;
            }

            header {
                padding: 15px 20px;
                justify-content: space-between;
            }

            header nav ul {
                gap: 15px;
            }

            /* Sidebar tersembunyi dan slide dari kiri */
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            /* Profile text disembunyikan di mobile */
            .profile span {
                display: none;
            }

            /* Notification dropdown position */
            #notification-dropdown {
                right: 20px;
                min-width: 200px;
            }

            /* Content wrapper */
            .content-wrapper {
                padding: 20px;
            }

            .page-title {
                font-size: 26px;
                margin-bottom: 20px;
            }

            /* Profile container - stack vertically */
            .profile-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .card {
                padding: 20px;
            }

            /* Profile picture size */
            .profile-picture {
                width: 100px;
                height: 100px;
            }

            .admin-name {
                font-size: 22px;
            }

            /* Stats grid - full width items */
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .stat-item {
                flex-direction: row;
                justify-content: space-between;
            }

            /* Form title */
            .form-title {
                font-size: 18px;
                margin-bottom: 20px;
            }

            /* Photo upload group - stack on small screens */
            .photo-upload-group {
                flex-direction: column;
                align-items: flex-start;
            }

            .current-photo {
                width: 80px;
                height: 80px;
                margin-bottom: 10px;
            }

            .btn-change-photo {
                width: 100%;
            }
        }

        /* =========================================== */
        /* RESPONSIVE DESIGN - SMALL MOBILE (max-width: 480px) */
        /* Optimasi untuk layar sangat kecil */
        /* =========================================== */
        @media (max-width: 480px) {
            header {
                padding: 12px 15px;
            }

            .content-wrapper {
                padding: 15px;
            }

            .page-title {
                font-size: 22px;
                margin-bottom: 15px;
            }

            .card {
                padding: 15px;
            }

            .profile-picture {
                width: 90px;
                height: 90px;
            }

            .admin-name {
                font-size: 20px;
            }

            .admin-email {
                font-size: 13px;
            }

            .form-title {
                font-size: 16px;
            }

            .form-input,
            .form-textarea {
                padding: 10px 12px;
                font-size: 13px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 10px 20px;
                font-size: 14px;
            }

            #notification-bell img {
                width: 20px;
                height: 20px;
            }

            .profile-pic {
                width: 25px;
                height: 25px;
            }
        }

        /* =========================================== */
        /* LANDSCAPE MODE - MOBILE */
        /* Optimasi untuk mode landscape di mobile */
        /* =========================================== */
        @media (max-height: 500px) and (orientation: landscape) {
            .sidebar {
                overflow-y: auto;
            }

            .content-wrapper {
                padding: 15px 20px;
            }

            .page-title {
                margin-top: 10px;
                margin-bottom: 15px;
            }

            .profile-picture {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body>

    <!-- =========================================== -->
    <!-- OVERLAY untuk menutup sidebar di mobile -->
    <!-- =========================================== -->
    <div class="overlay" id="overlay"></div>

    <!-- =========================================== -->
    <!-- HEADER SECTION -->
    <!-- Bar navigasi atas dengan notifikasi dan profil admin -->
    <!-- =========================================== -->
    <header role="banner">
        <!-- Hamburger Menu Button (hanya muncul di mobile) -->
        <button class="hamburger" id="hamburger-btn" aria-label="Toggle menu" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17h14M5 12h14M5 7h14"/></svg>
        </button>

        <nav role="navigation" aria-label="User navigation">
            <ul>
                <li>
                    <a href="#" id="notification-bell" aria-label="Notifikasi">
                        <img src="aset/bell.png" alt="Icon notifikasi">
                    </a>
                </li>
                <!-- Dropdown notifikasi -->
                <div id="notification-dropdown" class="hidden" role="menu" aria-label="Menu notifikasi">
                    <p style="color: #666; font-size: 14px;">Tidak ada notifikasi baru</p>
                </div>
                <li class="profile">
                    <img src="aset/pp.jfif" alt="Foto profil Admin" class="profile-pic">
                    <span>Admin</span>
                </li>
            </ul>
        </nav>
    </header>

    <!-- =========================================== -->
    <!-- SIDEBAR NAVIGATION -->
    <!-- Menu navigasi samping untuk berpindah halaman -->
    <!-- =========================================== -->
    <nav class="sidebar" id="sidebar" role="navigation" aria-label="Main navigation">
        <div class="sidebarH">
            <a href="#" aria-label="Logo Bahtera - Kembali ke beranda">
                <img src="aset/LogoBahtera.png" alt="Logo Bahtera" class="nav_logo">
            </a>
        </div>
        <ul>
            <li><a href="DCadmin.php">Dashboard</a></li>
            <li><a href="KBadmin.php">Konten Budaya</a></li>
            <li><a href="URadmin.php">Ulasan & Rating</a></li>
            <li><a href="Kadmin.php">Kategori</a></li>
            <li><a href="Padmin.php" aria-current="page">Profile</a></li>
        </ul>
    </nav>

    <!-- =========================================== -->
    <!-- MAIN CONTENT -->
    <!-- Area konten utama profil admin -->
    <!-- =========================================== -->
    <main class="content-wrapper" role="main">
        <h1 class="page-title">Profil Admin</h1>

        <div class="profile-container">

            <!-- =========================================== -->
            <!-- KOLOM KIRI: INFO PROFIL ADMIN -->
            <!-- Menampilkan informasi statis profil admin -->
            <!-- =========================================== -->
            <div class="col-left">
                <article class="card info-card" role="region" aria-label="Informasi profil admin">

                    <!-- Gambar Profil -->
                    <img src="https://placehold.co/120x120/808080/ffffff?text=P" alt="Foto Profil Admin"
                        class="profile-picture"
                        onerror="this.src='https://placehold.co/120x120/808080/ffffff?text=P';">

                    <h2 class="admin-name">Admin Utama</h2>
                    <p class="admin-email">admin@budyaid.com</p>
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
                </article>
            </div>

            <!-- =========================================== -->
            <!-- KOLOM KANAN: FORM EDIT & PASSWORD -->
            <!-- Form untuk mengedit profil dan ganti password -->
            <!-- =========================================== -->
            <div class="col-right">

                <!-- Bagian Edit Profil -->
                <article class="card edit-profile-section" role="region" aria-label="Form edit profil">
                    <div class="form-title">Edit Profil</div>

                    <form id="edit-profile-form">
                        <div class="form-group">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" class="form-input" value="Admin Utama" required
                                aria-required="true">
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-input input-readonly" value="admin@budyaid.com"
                                readonly aria-readonly="true">
                        </div>

                        <div class="form-group">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea id="bio" class="form-textarea"
                                aria-label="Bio admin">Admin sistem manajemen konten budaya Indonesia</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Foto Profil</label>
                            <div class="photo-upload-group">
                                <img src="https://placehold.co/60x60/cccccc/333333?text=P"
                                    alt="Foto Profil Admin Saat Ini" class="current-photo"
                                    onerror="this.src='https://placehold.co/60x60/cccccc/333333?text=P';">
                                <button type="button" class="btn-change-photo"
                                    aria-label="Ganti foto profil">Ganti Foto</button>
                            </div>
                        </div>

                        <button class="btn-primary" type="submit">Simpan Perubahan</button>
                    </form>
                </article>

                <!-- Bagian Ganti Password -->
                <article class="card password-section" role="region" aria-label="Form ganti password">
                    <div class="form-title">Ganti Password</div>

                    <form id="change-password-form">
                        <div class="form-group">
                            <label for="password_saat_ini" class="form-label">Password Saat Ini</label>
                            <input type="password" id="password_saat_ini" class="form-input" required
                                aria-required="true">
                        </div>

                        <div class="form-group">
                            <label for="password_baru" class="form-label">Password Baru</label>
                            <input type="password" id="password_baru" class="form-input" required
                                aria-required="true" minlength="8">
                        </div>

                        <div class="form-group">
                            <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" id="konfirmasi_password" class="form-input" required
                                aria-required="true" minlength="8">
                        </div>

                        <button class="btn-secondary" type="submit">Ganti Password</button>
                    </form>
                </article>

            </div> <!-- /.col-right -->

        </div> <!-- /.profile-container -->
    </main>

    <!-- =========================================== -->
    <!-- JAVASCRIPT -->
    <!-- Interactivity handlers -->
    <!-- =========================================== -->
    <script>
        /* =========================================== */
        /* HAMBURGER MENU HANDLER */
        /* Toggle sidebar dan overlay untuk mobile */
        /* Purpose: Membuka/menutup menu sidebar di mobile */
        /* Side-effects: Menambah/menghapus class 'active' */
        /* =========================================== */
        (function initHamburgerMenu() {
            const hamburger = document.getElementById('hamburger-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            if (hamburger && sidebar && overlay) {
                // Toggle sidebar saat hamburger diklik
                hamburger.addEventListener('click', function () {
                    const isActive = sidebar.classList.toggle('active');
                    overlay.classList.toggle('active', isActive);
                    hamburger.classList.toggle('active', isActive);

                    // Update ARIA attribute
                    hamburger.setAttribute('aria-expanded', isActive);
                });

                // Tutup sidebar saat overlay diklik
                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    hamburger.classList.remove('active');
                    hamburger.setAttribute('aria-expanded', 'false');
                });

                // Tutup sidebar saat link menu diklik (mobile UX)
                const menuLinks = sidebar.querySelectorAll('a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function () {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.remove('active');
                            overlay.classList.remove('active');
                            hamburger.classList.remove('active');
                            hamburger.setAttribute('aria-expanded', 'false');
                        }
                    });
                });
            }
        })();

        /* =========================================== */
        /* NOTIFICATION DROPDOWN HANDLER */
        /* Toggle tampilan dropdown notifikasi */
        /* Purpose: Menampilkan/menyembunyikan notifikasi */
        /* Side-effects: Toggle class 'hidden' pada dropdown */
        /* =========================================== */
        (function initNotificationHandler() {
            const notifBell = document.getElementById('notification-bell');
            const dropdown = document.getElementById('notification-dropdown');

            if (notifBell && dropdown) {
                notifBell.addEventListener('click', function (e) {
                    e.preventDefault();
                    dropdown.classList.toggle('hidden');
                });

                // Tutup dropdown jika klik di luar area
                document.addEventListener('click', function (e) {
                    if (!notifBell.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        })();

        /* =========================================== */
        /* EDIT PROFILE FORM HANDLER */
        /* Menangani submit form edit profil */
        /* Purpose: Validasi dan simpan perubahan profil */
        /* =========================================== */
        (function initEditProfileForm() {
            const form = document.getElementById('edit-profile-form');

            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const nama = document.getElementById('nama_lengkap').value;
                    const bio = document.getElementById('bio').value;

                    // Validasi dasar
                    if (!nama || nama.trim() === '') {
                        alert('Nama lengkap tidak boleh kosong!');
                        return;
                    }

                    // Simulasi sukses (replace dengan API call di production)
                    alert('Password berhasil diubah!');
                    console.log('Password updated');

                    // Reset form
                    form.reset();
                });
            }
        })();

        /* =========================================== */
        /* CHANGE PHOTO BUTTON HANDLER */
        /* Menangani klik tombol ganti foto */
        /* Purpose: Trigger file input untuk upload foto */
        /* =========================================== */
        (function initChangePhotoButton() {
            const changePhotoBtn = document.querySelector('.btn-change-photo');

            if (changePhotoBtn) {
                changePhotoBtn.addEventListener('click', function () {
                    // Simulasi file picker (implement file upload di production)
                    alert('Fitur upload foto akan segera hadir!\n\nDi production, ini akan membuka dialog file picker untuk memilih foto profil baru.');

                    // Production implementation example:
                    // const fileInput = document.createElement('input');
                    // fileInput.type = 'file';
                    // fileInput.accept = 'image/*';
                    // fileInput.onchange = (e) => handlePhotoUpload(e.target.files[0]);
                    // fileInput.click();
                });
            }
        })();
    </script>

</body>

</html>