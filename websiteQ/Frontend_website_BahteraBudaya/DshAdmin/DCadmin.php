<?php
session_start();
include 'koneksiKA.php'
if (!isset($_SESSION['admin'])) {
    header("Location: ../loginadmin(FIX_MAULANA)/page-loginAdmin.php");
    exit;
}

// 1. Total Pengguna
$queryUser = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM users");
$dataUser = mysqli_fetch_assoc($queryUser);
$totalUser = $dataUser['total']; // Menghasilkan angka seperti 12543

// 2. Total Konten
$queryKonten = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM konten");
$dataKonten = mysqli_fetch_assoc($queryKonten);
$totalKonten = $dataKonten['total'];

// 3. Ulasan Baru (Misal: ulasan yang masuk bulan ini)
$bulanIni = date('m');
$tahunIni = date('Y');
$queryUlasan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM ulasan WHERE MONTH(tanggal) = '$bulanIni' AND YEAR(tanggal) = '$tahunIni'");
$dataUlasan = mysqli_fetch_assoc($queryUlasan);
$totalUlasanBaru = $dataUlasan['total'];

// 4. Kunjungan Hari Ini (Mengambil data dari tabel log/traffic)
$hariIni = date('Y-m-d');
$queryKunjungan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM kunjungan WHERE DATE(waktu_kunjung) = '$hariIni'");
$dataKunjungan = mysqli_fetch_assoc($queryKunjungan);
$kunjunganHariIni = $dataKunjungan['total'];

// Mengambil total kunjungan per bulan di tahun berjalan
$queryGrafik = "SELECT MONTH(waktu_kunjung) as bulan, COUNT(*) as jumlah 
                FROM kunjungan 
                WHERE YEAR(waktu_kunjung) = YEAR(CURDATE()) 
                GROUP BY MONTH(waktu_kunjung)";
$resultGrafik = mysqli_query($koneksi, $queryGrafik);

$dataBulan = [];
$dataJumlah = [];

while($row = mysqli_fetch_assoc($resultGrafik)) {
    // Ubah angka bulan menjadi nama bulan singkat jika diperlukan (1 -> Jan, 2 -> Feb, dst)
    $dataBulan[] = $row['bulan']; 
    $dataJumlah[] = $row['jumlah'];
}

// Data ini nantinya di-inject ke dalam script Chart.js kamu:
// data: <?php echo json_encode($dataJumlah);

$queryPie = "SELECT kategori, COUNT(*) as total FROM konten GROUP BY kategori";
$resultPie = mysqli_query($koneksi, $queryPie);

$labelKategori = [];
$jumlahKonten = [];

while($row = mysqli_fetch_assoc($resultPie)) {
    $labelKategori[] = $row['kategori'];  // Contoh: 'Rumah Adat'
    $jumlahKonten[] = $row['total'];     // Contoh: 350
}

// Mengambil 5 aktivitas terbaru dari database
$queryLog = "SELECT waktu, pengguna, aktivitas, status 
             FROM log_aktivitas 
             ORDER BY waktu DESC 
             LIMIT 5";
$resultLog = mysqli_query($koneksi, $queryLog);

// Di HTML tinggal di-looping menggunakan while:
while($row = mysqli_fetch_assoc($resultLog)) {
    echo "<tr>";
    echo "<td>".date('H:i', strtotime($row['waktu']))."</td>";
    echo "<td>".$row['pengguna']."</td>";
    echo "<td>".$row['aktivitas']."</td>";
    
    // Memberikan warna dinamis pada status (Sukses / Aktif)
    $color = ($row['status'] == 'Sukses') ? 'text-success' : 'text-primary';
    echo "<td class='$color'>".$row['status']."</td>";
    echo "</tr>";
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
            min-height: calc(100vh-72);
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
            height: auto;
        }

        h1 {
            margin-top: 30px;
            margin-bottom: 20px;
            margin-left: 45px;
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

        /* --- KARTU RANGKUMAN DATA (BARIS MERAH) --- */
        .rangkum_data {
            display: flex;
            flex-direction: row;
            gap: 20px;
            padding: 40px;
            /* DIUBAH: Hapus padding luar */
            background-color: transparent;
            /* DIUBAH: Hapus latar belakang merah */
            border-radius: 0;
            /* DIUBAH: Hapus border-radius */
            margin-bottom: 5px;
        }

        .isi_rangkum {
            flex: 1;
            color: #fff;
            padding: 10px;
            background-color: #6D2323;
            border-radius: 10px;

            /* Tambahkan ikon kecil dan penunjuk % */
        }

        .isi_rangkum h4 {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 5px;
        }

        .isi_rangkum h5 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .isi_rangkum p {
            font-size: 12px;
            margin: 0;
        }

        /* --- GRAFIK (BARIS KEDUA) --- */
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
        }

        .chart-container h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        /* --- TABEL AKTIVITAS TERBARU (BARIS KETIGA) --- */
        .table-container {
            background-color: #FFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin: 40px;
        }

        .table-container h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
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

        /* Warna status di tabel */
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

        /* Warna Persentase di Kartu Data */
        .green {
            color: #4CAF50;
            font-size: 12px;
        }

        .red {
            color: #ff2600;
            font-size: 12px;
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
            <li><a href="DCadmin.php"> Dashboard</a></li>
            <li><a href="KBadmin.php"> Konten Budaya</a></li>
            <li><a href="URadmin.php"> Ulasan & Rating</a></li>
            <li><a href="Kadmin.php">Kategori</a></li>
            <li><a href="Padmin.php">Profile</a></li>
        </ul>
    </nav>

    <div class="main-content">

        <h1 class="page-title">Dashboard</h1>

        <div class="rangkum_data">

            <div class="isi_rangkum">
                <h4>Total Pengguna</h4>
                <h5>12.543</h5>
                <p><span class="green">↑ 12% dari bulan lalu</span></p>
            </div>

            <div class="isi_rangkum">
                <h4>Total Konten</h4>
                <h5>856</h5>
                <p><span class="green">↑ 8% dari bulan lalu</span></p>
            </div>

            <div class="isi_rangkum">
                <h4>Ulasan Baru</h4>
                <h5>234</h5>
                <p><span class="red">↓ 2% dari bulan lalu</span></p>
            </div>

            <div class="isi_rangkum">
                <h4>Kunjungan Hari Ini</h4>
                <h5>3.421</h5>
                <p><span class="red">↓ 10% dari kemarin</span></p>
            </div>

        </div>

        <div class="charts-row">

            <div class="chart-container">
                <h2>Kunjungan 7 Hari Terakhir</h2>
                <canvas id="grafikKunjungan"></canvas>
            </div>

            <div class="chart-container">
                <h2>Distribusi Konten</h2>
                <canvas id="grafikDistribusi"></canvas>
            </div>

        </div>

        <div class="table-container">
            <h2>Aktivitas Terbaru</h2>
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aktivitas</th>
                        <th>Status</th>
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
        </div>

    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.getElementById('notification-bell').addEventListener('click', function (e) {
        e.preventDefault(); // Mencegah browser scroll ke atas
        // Pastikan Anda memiliki elemen dengan ID 'notification-dropdown' dan class 'hidden' di CSS atau HTML.
        const dropdown = document.getElementById('notification-dropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    });

    // ===================================
    // DIAGRAM 1: GRAFIK GARIS (Kunjungan)
    // ===================================
    const ctxKunjungan = document.getElementById('grafikKunjungan');
    if (ctxKunjungan) {
        new Chart(ctxKunjungan.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu'], // Label sumbu X
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: [1100, 1350, 1200, 1500, 1400, 1650, 1550, 1800], // Data dummy
                    borderColor: '#6D2323', // Warna Garis Merah Marun
                    backgroundColor: 'rgba(109, 35, 35, 0.1)', // Warna latar belakang di bawah garis (transparan)
                    borderWidth: 3,
                    tension: 0.4, // Membuat garis melengkung (curve)
                    pointRadius: 5,
                    pointBackgroundColor: '#6D2323',
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: {
                            display: true,
                        },
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });

        // Set height for chart container (agar grafik tidak terlalu kecil)
        ctxKunjungan.parentElement.style.height = '300px';
    }


    // ===================================
    // DIAGRAM 2: DONUT CHART (Distribusi Konten)
    // ===================================
    const ctxDistribusi = document.getElementById('grafikDistribusi');
    if (ctxDistribusi) {
        new Chart(ctxDistribusi.getContext('2d'), {
            type: 'doughnut', // Donut chart
            data: {
                labels: ['Rumah Adat', 'Pakaian Adat', 'Tari Tradisional', 'Musik Daerah'], // Kategori
                datasets: [{
                    label: 'Jumlah Konten',
                    data: [40, 30, 15, 15], // Data Persentase/Jumlah (Total 100)
                    backgroundColor: [
                        '#6D2323', // Merah Marun 1
                        '#903030', // Merah Marun 2
                        '#A84848', // Merah Marun 3
                        '#C06060'  // Merah Marun 4
                    ],
                    hoverOffset: 4,
                    borderWidth: 0 // Hapus border
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right', // Letakkan legenda di kanan
                        labels: {
                            boxWidth: 10,
                            padding: 15
                        }
                    }
                }
            }
        });

        // Set height for chart container (agar grafik tidak terlalu kecil)
        ctxDistribusi.parentElement.style.height = '300px';
    }
</script>

</html>