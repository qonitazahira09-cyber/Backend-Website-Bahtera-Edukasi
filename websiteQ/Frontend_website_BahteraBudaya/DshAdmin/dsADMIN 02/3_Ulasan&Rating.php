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
            background-color: #EBD7C1;
            transition: padding-left 0.3s ease;
        }

        /* Header Styles */
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

        .hamburger span {
            display: block;
            height: 2px;
            width: 100%;
            background-color: #fff;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        header h1 {
            font-size: 20px;
        }

        header nav ul {
            display: flex;
            list-style: none;
        }

        header ul li {
            margin-left: 15px;
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

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 180px;
            height: 100%;
            background-color: #6D2323;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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
            transition: margin-left 0.3s ease;
            margin-left: 180px;
        }

        h1 {
            margin-top: 20px;
            margin-bottom: 20px;
            color: #6D2323;
            font-size: 26px;
        }

        /* Judul Utama "Dashboard" */
        h1.page-title {
            font-size: 32px;
            font-weight: bold;
            color: #6D2323;
            margin-bottom: 25px;
        }

         /* ======================== */
        /* == FILTER / DROP DOWNS == */
        /* ======================== */

        .content-wrapper {
            margin: 0;
        }

        .filter-row {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-row input[type="text"] {
            padding: 14px 12px;
            border: none;
            border-radius: 5px;
            background-color: #6D2323;
            color: white;
            flex: 2;
            min-width: 180px;
            font-size: 14px;
        }
        
        .filter-row input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .filter-row select, .filter-row button {
            padding: 14px 12px;
            border: none;
            border-radius: 5px;
            background-color: #6D2323;
            color: white;
            cursor: pointer;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            flex: 1;
            max-width: 180px;
            min-width: 140px;
            text-align: left;
            font-size: 14px;
        }

        .filter-row button {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
        }

        /* Ikon Filter */
        .filter-row button::before {
            content: '▼';
            margin-right: 6px;
            font-size: 9px;
        }
        
        .filter-row button:last-child::before {
            content: '🔍';
            margin-right: 6px;
            font-size: 14px;
        }

        /* ======================== */
        /* == LIST ULASAN == */
        /* ======================== */
        
        .review-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
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
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #ccc;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .reviewer-info h3 {
            font-size: 15px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }

        .rating-stars {
            color: #FFC107;
            font-size: 16px;
            margin-bottom: 4px;
        }
        
        .review-source {
            font-size: 12px;
            color: #999;
            margin-top: -2px;
        }

        .review-text {
            font-size: 14px;
            color: #555;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .review-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 8px;
        }
        
        .review-actions button {
            background: none;
            border: none;
            cursor: pointer;
            color: #6D2323;
            font-size: 16px;
            padding: 4px;
        }
        
        /* Ikon Bendera (Report) */
        .review-actions .report-icon {
            color: #f00;
            font-size: 13px;
        }

        /* Overlay untuk mobile saat sidebar terbuka */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 98;
            display: none;
        }

        /* Media Queries untuk Responsivitas */
        
        /* Tablet */
        @media (max-width: 1024px) {
            .sidebar {
                width: 160px;
            }
            
            .main-content {
                margin-left: 160px;
                padding: 15px;
            }
            
            .filter-row {
                gap: 10px;
            }
            
            .filter-row input[type="text"],
            .filter-row select,
            .filter-row button {
                padding: 12px 10px;
                font-size: 13px;
                min-width: 150px;
                max-width: 160px;
            }
            
            .review-actions {
                position: static;
                margin-top: 8px;
                justify-content: flex-end;
            }
        }
        
        /* Mobile */
        @media (max-width: 768px) {
            body {
                padding-left: 0;
            }
            
            header {
                padding: 12px 15px;
                height: 60px;
            }
            
            .hamburger {
                display: flex;
            }
            
            .sidebar {
                width: 220px;
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 15px;
            }
            
            h1.page-title {
                font-size: 26px;
                margin-top: 15px;
                margin-bottom: 20px;
            }
            
            .filter-row {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-row input[type="text"],
            .filter-row select,
            .filter-row button {
                max-width: 100%;
                min-width: auto;
                padding: 12px 10px;
            }
            
            .review-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .reviewer-pic {
                margin-bottom: 8px;
            }
            
            .review-actions {
                position: static;
                margin-top: 10px;
                justify-content: flex-end;
            }
        }
        
        /* Small Mobile */
        @media (max-width: 480px) {
            header {
                padding: 10px 12px;
                height: 55px;
            }
            
            header h1 {
                font-size: 18px;
            }
            
            header nav ul li {
                margin-left: 8px;
            }
            
            .profile span {
                display: none;
            }
            
            .main-content {
                padding: 10px;
            }
            
            h1.page-title {
                font-size: 22px;
            }
            
            .filter-row input[type="text"],
            .filter-row select,
            .filter-row button {
                padding: 10px 8px;
                font-size: 13px;
            }
            
            .review-card {
                padding: 12px;
            }
            
            .sidebar {
                width: 200px;
            }
        }
    </style>
</head>

<body>

    <!-- Overlay untuk mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <header>
        <div class="header-left">
            <div class="hamburger" id="hamburger">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 17h14M5 12h14M5 7h14"/></svg>
            </div>
            <h1>Bahtera Budaya</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#" id="notification-bell">
                        <img src="aset/bell.png" alt="Notifikasi">
                    </a></li>
                <div id="notification-dropdown" class="hidden">
                </div>
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
            <li><a href="DCadmin.php"> Dashboard</a></li>
            <li><a href="KBadmin.php"> Konten Budaya</a></li>
            <li><a href="URadmin.php"> Ulasan & Rating</a></li>
            <li><a href="Kadmin.php">Kategori</a></li>
            <li><a href="Padmin.php">Profile</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <div class="content-wrapper">

        <h1 class="page-title">Ulasan & Rating</h1>

        <!-- BARIS FILTER -->
        <div class="filter-row">
            <input type="text" placeholder="Cari konten...">
            <select>
                <option value="">Semua Konten</option>
                <option value="konten1">Rumah Gadang</option>
                <option value="konten2">Batik Jawa</option>
            </select>
            <select>
                <option value="">Semua Rating</option>
                <option value="5">5 Bintang</option>
                <option value="4">4 Bintang</option>
                <option value="3">3 Bintang</option>
                <option value="2">2 Bintang</option>
                <option value="1">1 Bintang</option>
            </select>
            <button>Filter</button>
        </div>

        <!-- LIST ULASAN -->
        <div class="review-list">

            <!-- ULASAN 1 -->
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-pic"></div>
                    <div class="reviewer-info">
                        <h3>Ahmad Rizki</h3>
                        <div class="rating-stars">⭐⭐⭐⭐⭐</div>
                        <div class="review-source">Ulasan konten: Rumah Gadang</div>
                    </div>
                </div>
                <p class="review-text">
                    Informasi yang disajikan sangat lengkap dan gambarnya kategori. Pembaruan yang berkala membuat konten ini selalu up-to-date dan menarik. Perlu ditingkatkan lagi.
                </p>
                <div class="review-actions">
                    <!-- Placeholder untuk Ikon Hapus/Tindak Lanjut -->
                    <button class="delete-icon">🗑️</button>
                    <button class="report-icon">🚩</button>
                </div>
            </div>

            <!-- ULASAN 2 -->
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-pic"></div>
                    <div class="reviewer-info">
                        <h3>Siti Nurhaliza</h3>
                        <div class="rating-stars">⭐⭐⭐⭐</div>
                        <div class="review-source">Ulasan konten: Tarian Tradisional</div>
                    </div>
                </div>
                <p class="review-text">
                    Bagus, tapi kurang rincian gerakan. Mohon ditambahkan video atau demo/langkah-langkah. Terima kasih.
                </p>
                <div class="review-actions">
                    <button class="delete-icon">🗑️</button>
                    <button class="report-icon">🚩</button>
                </div>
            </div>

            <!-- ULASAN 3 (Contoh Ulasan Bintang Rendah) -->
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-pic"></div>
                    <div class="reviewer-info">
                        <h3>Joko Susanto</h3>
                        <div class="rating-stars">⭐⭐</div>
                        <div class="review-source">Ulasan konten: Papeda</div>
                    </div>
                </div>
                <p class="review-text">
                    Gambarnya buram dan informasinya tidak relevan dengan budaya daerah saat ini. Mohon perbaikan secepatnya.
                </p>
                <div class="review-actions">
                    <button class="delete-icon">🗑️</button>
                    <button class="report-icon">🚩</button>
                </div>
            </div>

        </div> <!-- /.review-list -->

    </div> 
    </div>

    <script>
        // Toggle sidebar untuk mobile
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        hamburger.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            hamburger.classList.toggle('active');
            sidebarOverlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        });
        
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            hamburger.classList.remove('active');
            sidebarOverlay.style.display = 'none';
        });
        
        // Notifikasi dropdown
        document.getElementById('notification-bell').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('notification-dropdown').classList.toggle('hidden');
        });
    </script>

</body>

</html>