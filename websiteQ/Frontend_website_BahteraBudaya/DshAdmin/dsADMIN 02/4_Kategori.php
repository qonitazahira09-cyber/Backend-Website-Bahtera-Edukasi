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

        /* --- KONTEN UTAMA --- */
        .content-wrapper {
            padding: 30px;
            position: relative; 
        }

        .page-title {
            font-size: 32px;
            font-weight: bold;
            color: #6D2323;
            margin-bottom: 30px;
            margin-left: 0;
            margin-top: 0;
        }
        
        /* --- GAYA TOMBOL TAMBAH KONTEN BARU --- */
        .add-content-btn {
            background-color: #6D2323; 
            color: white;
            border: none;
            border-radius: 8px; 
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            padding: 15px 25px; 
            
            position: absolute;
            top: 30px;
            right: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.2s;
        }

        .add-content-btn:hover {
            background-color: #903030; 
            transform: translateY(-2px);
        }

        /* --- CARD KATEGORI GRID --- */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }

        .category-card {
            background-color: #FFF;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            position: relative;
            display: flex;
            flex-direction: column;
            min-height: 180px;
        }

        .category-icon-wrapper {
            width: 45px;
            height: 45px;
            border-radius: 8px;
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
        }

        .category-card p {
            font-size: 13px;
            color: #666;
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .category-card small {
            font-size: 12px;
            color: #999;
        }

        .card-actions {
            position: absolute;
            top: 15px;
            right: 15px;
            display: flex;
            gap: 5px;
        }

        .card-actions button {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 14px;
            transition: color 0.2s;
            padding: 5px;
            border-radius: 4px;
        }

        .card-actions button:hover {
            color: #6D2323;
            background-color: #F5F5F5;
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
            
            .content-wrapper {
                padding: 20px;
            }
            
            .add-content-btn {
                top: 20px;
                right: 20px;
                padding: 12px 20px;
                font-size: 15px;
            }
            
            .category-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
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
            
            .content-wrapper {
                padding: 15px;
            }
            
            h1.page-title {
                font-size: 26px;
                margin-top: 15px;
                margin-bottom: 20px;
            }
            
            .add-content-btn {
                position: relative;
                top: auto;
                right: auto;
                margin-bottom: 20px;
                width: 100%;
            }
            
            .category-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .category-card {
                padding: 20px;
                min-height: 160px;
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
            
            .content-wrapper {
                padding: 10px;
            }
            
            h1.page-title {
                font-size: 22px;
            }
            
            .add-content-btn {
                padding: 12px 15px;
                font-size: 14px;
            }
            
            .category-card {
                padding: 15px;
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

            <h1 class="page-title">Manajemen Kategori</h1>

            <!-- TOMBOL TAMBAHKAN KONTEN BARU -->
            <button class="add-content-btn">
                + Tambahkan Konten
            </button>

            <!-- GRID KARTU KATEGORI -->
            <div class="category-grid">

                <!-- KARTU 1: Rumah Adat -->
                <div class="category-card">
                    <div class="category-icon-wrapper" style="background-color: #FFF3F3; color: #E74C3C;">
                        🏠
                    </div>
                    <h3>Rumah Adat</h3>
                    <p>Kumpulan rumah adat dan berbagai daerah di Indonesia.</p>
                    <small>40 konten</small>
                    <div class="card-actions">
                        <button title="Edit">✏️</button>
                        <button title="Hapus">🗑️</button>
                    </div>
                </div>

                <!-- KARTU 2: Pakaian Adat -->
                <div class="category-card">
                    <div class="category-icon-wrapper" style="background-color: #F3FFF3; color: #2ECC71;">
                        🤸
                    </div>
                    <h3>Pakaian Adat</h3>
                    <p>Pakaian tradisional dan modern, mengungkap cerita dan identitas daerah.</p>
                    <small>38 konten</small>
                    <div class="card-actions">
                        <button title="Edit">✏️</button>
                        <button title="Hapus">🗑️</button>
                    </div>
                </div>

                <!-- KARTU 3: Tarian Tradisional -->
                <div class="category-card">
                    <div class="category-icon-wrapper" style="background-color: #F3F3FF; color: #3498DB;">
                        💃
                    </div>
                    <h3>Tarian Tradisional</h3>
                    <p>Aneka tarian tradisional Indonesia yang mengandung nilai luhur dan filosofi.</p>
                    <small>25 konten</small>
                    <div class="card-actions">
                        <button title="Edit">✏️</button>
                        <button title="Hapus">🗑️</button>
                    </div>
                </div>

                <!-- KARTU 4: Makanan Tradisional -->
                <div class="category-card">
                    <div class="category-icon-wrapper" style="background-color: #FFFFF3; color: #F1C40F;">
                        🍽️
                    </div>
                    <h3>Makanan Tradisional</h3>
                    <p>Makanan tradisional Indonesia yang kaya rasa, sejarah, dan warisan.</p>
                    <small>60 konten</small>
                    <div class="card-actions">
                        <button title="Edit">✏️</button>
                        <button title="Hapus">🗑️</button>
                    </div>
                </div>

            </div> <!-- /.category-grid -->

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