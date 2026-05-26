<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manajemen Konten Budaya - Sistem Admin Bahtera">
    <title>Manajemen Konten Budaya - Bahtera</title>
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
        /* Container untuk judul dan tombol action */
        /* =========================================== */
        .content-wrappert {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            margin: 10px 40px 40px 40px;
            gap: 20px;
        }

        .page-title {
            font-size: 38px;
            font-weight: bold;
            color: #6D2323;
            margin: 30px 0;
            flex: 1;
            min-width: 250px;
        }

        /* =========================================== */
        /* HEADER ACTION BUTTON */
        /* Tombol tambah konten */
        /* =========================================== */
        .header-action {
            margin-top: 30px;
        }

        .add-content-btn {
            background-color: #6D2323;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s;
            white-space: nowrap;
        }

        .add-content-btn:hover {
            background-color: #903030;
        }

        /* =========================================== */
        /* FILTER BAR (BARIS MERAH) */
        /* Bar filter dengan search dan dropdown */
        /* =========================================== */
        .filter-bar {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            background-color: #6D2323;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            gap: 10px;
        }

        .filter-group {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            background-color: #903030;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            width: 200px;
            min-width: 150px;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .filter-dropdown {
            background-color: #903030;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            appearance: none;
            min-width: 120px;
        }

        .sort-dropdown {
            background-color: #6D2323;
            border: 1px solid #fff;
        }

        /* =========================================== */
        /* DATA TABLE CONTAINER */
        /* Tabel data konten budaya */
        /* =========================================== */
        .data-table-container {
            width: 100%;
            background-color: #FFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        .data-table-container table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 700px;
        }

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

        /* =========================================== */
        /* STATUS INDICATOR */
        /* Lingkaran kecil indikator status */
        /* =========================================== */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .status-active {
            background-color: #4CAF50;
        }

        /* =========================================== */
        /* ACTION MENU BUTTON */
        /* Tombol aksi (titik tiga) */
        /* =========================================== */
        .action-menu {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #333;
            padding: 5px 10px;
        }

        .action-menu:hover {
            background-color: #f5f5f5;
            border-radius: 4px;
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

            .content-wrappert {
                margin: 10px 30px 30px 30px;
            }

            .page-title {
                font-size: 32px;
            }

            .search-input {
                width: 180px;
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
            .content-wrappert {
                margin: 10px 20px 20px 20px;
                flex-direction: column;
                align-items: stretch;
            }

            .page-title {
                font-size: 26px;
                margin: 20px 0 15px 0;
                min-width: auto;
            }

            .header-action {
                margin-top: 0;
                width: 100%;
            }

            .add-content-btn {
                width: 100%;
                padding: 12px 20px;
            }

            /* Filter bar stack vertically */
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                padding: 15px;
            }

            .filter-group {
                width: 100%;
                flex-direction: column;
            }

            .search-input,
            .filter-dropdown,
            .sort-dropdown {
                width: 100%;
            }

            /* Table container */
            .data-table-container {
                padding: 15px;
                margin-bottom: 20px;
            }

            .data-table-container table {
                font-size: 12px;
                min-width: 600px;
            }

            .data-table-container table thead th,
            .data-table-container table tbody td {
                padding: 8px 6px;
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

            .content-wrappert {
                margin: 10px 15px 15px 15px;
            }

            .page-title {
                font-size: 22px;
                margin: 15px 0 10px 0;
            }

            .add-content-btn {
                font-size: 13px;
                padding: 10px 15px;
            }

            .filter-bar {
                padding: 12px;
            }

            .search-input,
            .filter-dropdown {
                font-size: 13px;
                padding: 8px 12px;
            }

            .data-table-container {
                padding: 12px;
            }

            .data-table-container table {
                font-size: 11px;
                min-width: 550px;
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

            .page-title {
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .content-wrappert {
                margin-top: 5px;
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
            <li><a href="KBadmin.php" aria-current="page">Konten Budaya</a></li>
            <li><a href="URadmin.php">Ulasan & Rating</a></li>
            <li><a href="Kadmin.php">Kategori</a></li>
            <li><a href="Padmin.php">Profile</a></li>
        </ul>
    </nav>

    <!-- =========================================== -->
    <!-- MAIN CONTENT -->
    <!-- Area konten utama manajemen konten budaya -->
    <!-- =========================================== -->
    <div class="content-wrappert">
        
        <!-- Page Title -->
        <h1 class="page-title">Manajemen Konten Budaya</h1>

        <!-- Action Button -->
        <div class="header-action">
            <button class="add-content-btn" aria-label="Tambahkan konten baru">+ Tambahkan Konten</button>
        </div>

        <!-- =========================================== -->
        <!-- FILTER BAR -->
        <!-- Bar filter dengan search dan dropdown kategori -->
        <!-- =========================================== -->
        <div class="filter-bar" role="search" aria-label="Filter konten">
            <div class="filter-group">
                <input type="text" placeholder="Cari konten..." class="search-input" aria-label="Cari konten">
            </div>

            <div class="filter-group">
                <select class="filter-dropdown" aria-label="Filter kategori">
                    <option>Semua Kategori</option>
                    <option>Rumah Adat</option>
                    <option>Pakaian Adat</option>
                    <option>Tari Tradisional</option>
                    <option>Musik Daerah</option>
                </select>
                <select class="filter-dropdown" aria-label="Filter provinsi">
                    <option>Semua Provinsi</option>
                    <option>Sumatera Barat</option>
                    <option>Jawa Tengah</option>
                    <option>Bali</option>
                    <option>Sulawesi Selatan</option>
                </select>
                <select class="filter-dropdown sort-dropdown" aria-label="Urutkan konten">
                    <option>Urutkan</option>
                    <option>Terbaru</option>
                    <option>Terlama</option>
                    <option>Rating Tertinggi</option>
                    <option>Rating Terendah</option>
                </select>
            </div>
        </div>

        <!-- =========================================== -->
        <!-- DATA TABLE -->
        <!-- Tabel daftar konten budaya -->
        <!-- =========================================== -->
        <div class="data-table-container">
            <table role="table" aria-label="Tabel konten budaya">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" aria-label="Pilih semua"></th>
                        <th scope="col">Judul</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Provinsi</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox" aria-label="Pilih Rumah Gadang"></td>
                        <td>Rumah Gadang</td>
                        <td>Rumah Adat</td>
                        <td>Sumatera Barat</td>
                        <td>⭐⭐⭐⭐⭐ 5.0</td>
                        <td><span class="status-indicator status-active" title="Aktif"></span>Aktif</td>
                        <td><button class="action-menu" aria-label="Menu aksi Rumah Gadang">⋮</button></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" aria-label="Pilih Kebaya"></td>
                        <td>Kebaya</td>
                        <td>Pakaian Adat</td>
                        <td>Jawa Tengah</td>
                        <td>⭐⭐⭐⭐⭐ 5.0</td>
                        <td><span class="status-indicator status-active" title="Aktif"></span>Aktif</td>
                        <td><button class="action-menu" aria-label="Menu aksi Kebaya">⋮</button></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" aria-label="Pilih Tari Kecak"></td>
                        <td>Tari Kecak</td>
                        <td>Tari Tradisional</td>
                        <td>Bali</td>
                        <td>⭐⭐⭐⭐☆ 4.8</td>
                        <td><span class="status-indicator status-active" title="Aktif"></span>Aktif</td>
                        <td><button class="action-menu" aria-label="Menu aksi Tari Kecak">⋮</button></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" aria-label="Pilih Angklung"></td>
                        <td>Angklung</td>
                        <td>Musik Daerah</td>
                        <td>Jawa Barat</td>
                        <td>⭐⭐⭐⭐⭐ 5.0</td>
                        <td><span class="status-indicator status-active" title="Aktif"></span>Aktif</td>
                        <td><button class="action-menu" aria-label="Menu aksi Angklung">⋮</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

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
                hamburger.addEventListener('click', function() {
                    const isActive = sidebar.classList.toggle('active');
                    overlay.classList.toggle('active', isActive);
                    hamburger.classList.toggle('active', isActive);
                    
                    // Update ARIA attribute
                    hamburger.setAttribute('aria-expanded', isActive);
                });

                // Tutup sidebar saat overlay diklik
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    hamburger.classList.remove('active');
                    hamburger.setAttribute('aria-expanded', 'false');
                });

                // Tutup sidebar saat link menu diklik (mobile UX)
                const menuLinks = sidebar.querySelectorAll('a');
                menuLinks.forEach(link => {
                    link.addEventListener('click', function() {
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
        /* SEARCH INPUT HANDLER */
        /* Filter tabel berdasarkan input pencarian */
        /* Purpose: Real-time search pada tabel konten */
        /* =========================================== */
        (function initSearchHandler() {
            const searchInput = document.querySelector('.search-input');
            const tableRows = document.querySelectorAll('.data-table-container tbody tr');

            if (searchInput && tableRows.length > 0) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();

                    tableRows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        })();

        /* =========================================== */
        /* SELECT ALL CHECKBOX HANDLER */
        /* Toggle semua checkbox di tabel */
        /* Purpose: Memudahkan bulk selection */
        /* =========================================== */
        (function initSelectAllHandler() {
            const selectAllCheckbox = document.querySelector('thead input[type="checkbox"]');
            const rowCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');

            if (selectAllCheckbox && rowCheckboxes.length > 0) {
                selectAllCheckbox.addEventListener('change', function() {
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });
            }
        })();
    </script>

</body>
</html>