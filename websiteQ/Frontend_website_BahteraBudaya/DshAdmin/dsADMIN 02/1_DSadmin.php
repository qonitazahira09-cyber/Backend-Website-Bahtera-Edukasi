<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Admin Bahtera - Sistem Manajemen Konten Budaya">
    <title>Dashboard Admin - Bahtera</title>
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
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

        /* Dropdown notifikasi */
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
            height: 100vh;
            overflow-y: auto;
            background-color: #6D2323;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: transform 0.3s ease;
            will-change: transform;
            -webkit-overflow-scrolling: touch;
            display: flex;
    flex-direction: column;
    overflow-y: auto;
        }

        .sidebarH {
            margin-bottom: 30px;
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
        /* MAIN CONTENT AREA */
        /* Area konten utama (di kanan sidebar) */
        /* =========================================== */
        .main-content {
            min-height: 100vh;
        }

        /* =========================================== */
        /* PAGE TITLE */
        /* Judul halaman utama "Dashboard" */
        /* =========================================== */
        h1.page-title {
            font-size: 38px;
            font-weight: bold;
            color: #6D2323;
            margin: 30px 0 30px 45px;
        }

        /* =========================================== */
        /* SUMMARY CARDS (RANGKUMAN DATA) */
        /* Kartu-kartu ringkasan data di baris pertama */
        /* =========================================== */
        .rangkum_data {
            display: flex;
            flex-direction: row;
            gap: 20px;
            padding: 0 40px;
            margin-bottom: 5px;
        }

        .isi_rangkum {
            flex: 1;
            color: #fff;
            padding: 20px;
            background-color: #6D2323;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            min-width: 0;
        }

        .isi_rangkum h4 {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 8px;
        }

        .isi_rangkum h5 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .isi_rangkum p {
            font-size: 12px;
            margin: 0;
        }

        /* =========================================== */
        /* CHARTS ROW (BARIS GRAFIK) */
        /* Container untuk grafik kunjungan dan distribusi */
        /* =========================================== */
        .charts-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            padding: 40px;
        }

        .chart-container {
            flex: 1;
            background-color: #FFF;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 30px 20px 80px 20px;
            min-height: 350px;
            display: flex;
            flex-direction: column;
            min-width: 0;
            will-change: transform;
            transform: translateZ(0);
        }

        .chart-container h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        /* =========================================== */
        /* ACTIVITY TABLE (TABEL AKTIVITAS) */
        /* Tabel menampilkan aktivitas terbaru pengguna */
        /* =========================================== */
        .table-container {
            background-color: #FFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin: 40px;
        }

        .table-container h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        table thead th {
            background-color: #F6F7F8;
            padding: 12px 10px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
            color: #666;
        }

        table tbody td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        /* =========================================== */
        /* STATUS COLORS (WARNA STATUS) */
        /* Pewarnaan untuk status di tabel dan persentase */
        /* =========================================== */
        .status-sukses {
            color: #4CAF50;
            font-weight: bold;
        }

        .status-aktif {
            color: #2196F3;
            font-weight: bold;
        }

        .status-ditolak {
            color: #ff2600;
            font-weight: bold;
        }

        .green {
            color: #4CAF50;
            font-size: 12px;
        }

        .red {
            color: #ff2600;
            font-size: 12px;
        }

        /* =========================================== */
        /* RESPONSIVE DESIGN - TABLET (768px - 1024px) */
        /* Layout untuk tablet: sidebar tetap terlihat */
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

            h1.page-title {
                font-size: 32px;
                margin-left: 30px;
            }

            .rangkum_data,
            .charts-row,
            .table-container {
                padding: 30px;
            }

            .isi_rangkum h5 {
                font-size: 24px;
            }

            .isi_rangkum h4 {
                font-size: 13px;
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

            /* Page title */
            h1.page-title {
                margin-left: 20px;
                margin-right: 20px;
                font-size: 28px;
            }

            /* Summary cards stack vertically */
            .rangkum_data {
                flex-direction: column;
                padding: 0 20px;
                gap: 15px;
            }

            .isi_rangkum {
                padding: 15px;
            }

            .isi_rangkum h5 {
                font-size: 24px;
            }

            /* Charts stack vertically */
            .charts-row {
                flex-direction: column;
                padding: 20px;
                gap: 15px;
            }

            .chart-container {
                padding: 20px 15px 60px 15px;
                min-height: 250px;
                contain: layout style paint;
            }

            .chart-container h2 {
                font-size: 16px;
            }

            /* Optimasi rendering untuk mobile */
            .chart-container canvas {
                max-height: 220px;
            }

            /* Table container */
            .table-container {
                margin: 20px;
                padding: 15px;
                overflow-x: auto;
            }

            .table-container h2 {
                font-size: 16px;
            }

            table {
                font-size: 12px;
                min-width: 500px;
            }

            table thead th,
            table tbody td {
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

            h1.page-title {
                font-size: 24px;
                margin: 20px 15px;
            }

            .rangkum_data {
                padding: 0 15px;
            }

            .isi_rangkum {
                padding: 12px;
            }

            .isi_rangkum h4 {
                font-size: 12px;
            }

            .isi_rangkum h5 {
                font-size: 20px;
            }

            .isi_rangkum p {
                font-size: 11px;
            }

            .charts-row {
                padding: 15px;
            }

            .chart-container {
                padding: 15px 10px 50px 10px;
                min-height: 250px;
            }

            .table-container {
                margin: 15px;
                padding: 12px;
            }

            table {
                font-size: 11px;
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

            h1.page-title {
                margin-top: 15px;
                margin-bottom: 15px;
            }

            .rangkum_data,
            .charts-row,
            .table-container {
                padding: 15px;
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
                <!-- Dropdown notifikasi (akan ditampilkan via JavaScript) -->
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
            <li><a href="DCadmin.php" aria-current="page">Dashboard</a></li>
            <li><a href="KBadmin.php">Konten Budaya</a></li>
            <li><a href="URadmin.php">Ulasan & Rating</a></li>
            <li><a href="Kadmin.php">Kategori</a></li>
            <li><a href="Padmin.php">Profile</a></li>
        </ul>
    </nav>

    <!-- =========================================== -->
    <!-- MAIN CONTENT -->
    <!-- Area konten utama dashboard -->
    <!-- =========================================== -->
    <main class="main-content" role="main">

        <h1 class="page-title">Dashboard</h1>

        <!-- =========================================== -->
        <!-- SUMMARY CARDS SECTION -->
        <!-- Kartu ringkasan data statistik -->
        <!-- =========================================== -->
        <section class="rangkum_data" aria-label="Ringkasan statistik">

            <article class="isi_rangkum" role="region" aria-label="Total Pengguna">
                <h4>Total Pengguna</h4>
                <h5>12.543</h5>
                <p><span class="green" aria-label="Naik 12 persen">↑ 12% dari bulan lalu</span></p>
            </article>

            <article class="isi_rangkum" role="region" aria-label="Total Konten">
                <h4>Total Konten</h4>
                <h5>856</h5>
                <p><span class="green" aria-label="Naik 8 persen">↑ 8% dari bulan lalu</span></p>
            </article>

            <article class="isi_rangkum" role="region" aria-label="Ulasan Baru">
                <h4>Ulasan Baru</h4>
                <h5>234</h5>
                <p><span class="red" aria-label="Turun 2 persen">↓ 2% dari bulan lalu</span></p>
            </article>

            <article class="isi_rangkum" role="region" aria-label="Kunjungan Hari Ini">
                <h4>Kunjungan Hari Ini</h4>
                <h5>3.421</h5>
                <p><span class="red" aria-label="Turun 10 persen">↓ 10% dari kemarin</span></p>
            </article>

        </section>

        <!-- =========================================== -->
        <!-- CHARTS SECTION -->
        <!-- Grafik visualisasi data (kunjungan & distribusi) -->
        <!-- =========================================== -->
        <section class="charts-row" aria-label="Visualisasi data">

            <article class="chart-container" role="region" aria-label="Grafik kunjungan">
                <h2>Kunjungan 7 Hari Terakhir</h2>
                <canvas id="grafikKunjungan" aria-label="Grafik garis menampilkan kunjungan 7 hari terakhir"></canvas>
            </article>

            <article class="chart-container" role="region" aria-label="Grafik distribusi konten">
                <h2>Distribusi Konten</h2>
                <canvas id="grafikDistribusi" aria-label="Grafik donat menampilkan distribusi konten budaya"></canvas>
            </article>

        </section>

        <!-- =========================================== -->
        <!-- ACTIVITY TABLE SECTION -->
        <!-- Tabel aktivitas terbaru pengguna -->
        <!-- =========================================== -->
        <section class="table-container" role="region" aria-label="Aktivitas terbaru">
            <h2>Aktivitas Terbaru</h2>
            <table role="table" aria-label="Tabel aktivitas pengguna">
                <thead>
                    <tr>
                        <th scope="col">Waktu</th>
                        <th scope="col">Pengguna</th>
                        <th scope="col">Aktivitas</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>10:30</td>
                        <td>Budi Santoso</td>
                        <td>Menambah konten: Rumah Gadang</td>
                        <td class="status-sukses">Sukses</td>
                    </tr>
                    <tr>
                        <td>09:45</td>
                        <td>Sri Aminah</td>
                        <td>Mengedit konten: Batik</td>
                        <td class="status-aktif">Aktif</td>
                    </tr>
                    <tr>
                        <td>08:20</td>
                        <td>Ahmad Fauzi</td>
                        <td>Login sistem</td>
                        <td class="status-sukses">Sukses</td>
                    </tr>
                </tbody>
            </table>
        </section>

    </main>

    <!-- =========================================== -->
    <!-- EXTERNAL SCRIPTS -->
    <!-- Library Chart.js untuk membuat grafik -->
    <!-- =========================================== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

                // Tutup sidebar saat link menu diklik (opsional, untuk UX lebih baik)
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
        /* CHART 1: LINE CHART (Grafik Kunjungan) */
        /* Menampilkan tren kunjungan selama 8 bulan terakhir */
        /* Input: Data kunjungan per bulan (array) */
        /* Output: Grafik garis interaktif dengan animasi */
        /* Side-effects: Render canvas chart ke DOM */
        /* OPTIMIZED: Lazy loading & performance tuning untuk mobile */
        /* =========================================== */
        (function initVisitChart() {
            const ctxKunjungan = document.getElementById('grafikKunjungan');
            
            if (ctxKunjungan) {
                // Deteksi device untuk optimasi
                const isMobile = window.innerWidth <= 768;
                
                new Chart(ctxKunjungan.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'],
                        datasets: [{
                            label: 'Jumlah Kunjungan',
                            data: [1100, 1350, 1200, 1500, 1400, 1650, 1550, 1800],
                            borderColor: '#6D2323',
                            backgroundColor: 'rgba(109, 35, 35, 0.1)',
                            borderWidth: isMobile ? 2 : 3,
                            tension: 0.4,
                            pointRadius: isMobile ? 3 : 5,
                            pointBackgroundColor: '#6D2323',
                            pointHoverRadius: isMobile ? 5 : 7,
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: isMobile ? 500 : 1000
                        },
                        interaction: {
                            mode: 'nearest',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: false,
                                grid: { 
                                    display: true,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: isMobile ? 5 : 8
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    maxRotation: 0,
                                    autoSkip: true
                                }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                enabled: !isMobile,
                                mode: 'index',
                                intersect: false,
                            }
                        },
                        elements: {
                            line: {
                                tension: 0.4
                            }
                        }
                    }
                });

                // Set tinggi container untuk grafik
                const containerHeight = isMobile ? '220px' : '300px';
                ctxKunjungan.parentElement.style.height = containerHeight;
            }
        })();

        /* =========================================== */
        /* CHART 2: DOUGHNUT CHART (Distribusi Konten) */
        /* Menampilkan proporsi kategori konten budaya */
        /* Input: Data persentase tiap kategori (array) */
        /* Output: Grafik donat dengan legenda di kanan */
        /* Side-effects: Render canvas chart ke DOM */
        /* OPTIMIZED: Performance tuning untuk mobile */
        /* =========================================== */
        (function initDistributionChart() {
            const ctxDistribusi = document.getElementById('grafikDistribusi');
            
            if (ctxDistribusi) {
                // Deteksi device untuk optimasi
                const isMobile = window.innerWidth <= 768;
                
                new Chart(ctxDistribusi.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Rumah Adat', 'Pakaian Adat', 'Tari Tradisional', 'Musik Daerah'],
                        datasets: [{
                            label: 'Jumlah Konten',
                            data: [40, 30, 15, 15],
                            backgroundColor: [
                                '#6D2323',
                                '#903030',
                                '#A84848',
                                '#C06060'
                            ],
                            hoverOffset: isMobile ? 2 : 4,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: isMobile ? 500 : 1000,
                            animateRotate: true,
                            animateScale: false
                        },
                        plugins: {
                            legend: {
                                position: isMobile ? 'bottom' : 'right',
                                labels: {
                                    boxWidth: 10,
                                    padding: isMobile ? 10 : 15,
                                    font: {
                                        size: isMobile ? 11 : 12
                                    }
                                }
                            },
                            tooltip: {
                                enabled: !isMobile
                            }
                        }
                    }
                });

                // Set tinggi container untuk grafik
                const containerHeight = isMobile ? '220px' : '300px';
                ctxDistribusi.parentElement.style.height = containerHeight;
            }
        })();

        /* =========================================== */
        /* RESPONSIVE CHART RESIZE HANDLER */
        /* Mengatur ulang grafik saat window diresize */
        /* Purpose: Memastikan chart tetap responsif */
        /* OPTIMIZED: Debounced dengan throttling untuk performa */
        /* =========================================== */
        (function handleChartResize() {
            let resizeTimer;
            let throttleTimer;
            const throttleDelay = 100;
            const debounceDelay = 300;
            
            window.addEventListener('resize', function() {
                // Throttle: Batasi eksekusi terlalu sering
                if (throttleTimer) return;
                
                throttleTimer = setTimeout(function() {
                    throttleTimer = null;
                }, throttleDelay);
                
                // Debounce: Eksekusi setelah user selesai resize
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Chart.js akan auto-resize dengan performa tinggi
                    const charts = Chart.instances;
                    if (charts && Object.keys(charts).length > 0) {
                        Object.values(charts).forEach(chart => {
                            if (chart && chart.resize) {
                                // requestAnimationFrame untuk smooth rendering
                                requestAnimationFrame(() => {
                                    chart.resize();
                                });
                            }
                        });
                    }
                }, debounceDelay);
            }, { passive: true });
        })();
    </script>

</body>
</html>