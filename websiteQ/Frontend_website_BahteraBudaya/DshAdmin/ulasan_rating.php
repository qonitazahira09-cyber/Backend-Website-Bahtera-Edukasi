<?php
session_start();
include 'koneksiKA.php'; // Hubungkan ke koneksi database kamu

// Ambil data ulasan dari yang paling baru
$query = mysqli_query($koneksi, "SELECT * FROM ulasan ORDER BY tanggal_kirim DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Ulasan & Rating</title>
    <style>
        /* Style sederhana untuk tabel, nanti bisa kamu sesuaikan dengan tema BahteraBudaya */
        body { font-family: Arial, sans-serif; background-color: #EBD7C1; padding: 20px; }
        .container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #800000; color: white; }
        .badge-rating { background-color: #FFD700; color: #333; padding: 5px 10px; border-radius: 5px; font-weight: bold; }
        .btn-hapus { background-color: #d9534f; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>Manajemen Ulasan & Rating Pengunjung</h2>

<?php if (isset($_SESSION['sukses_update'])): ?>
    <script>
        alert("<?php echo $_SESSION['sukses_update']; ?>");
    </script>
    <?php 
    unset($_SESSION['sukses_update']); 
    ?>
<?php endif; ?>

<p>Berikut adalah feedback yang dikirimkan oleh pengguna website BahteraBudaya.</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengunjung</th>
                <th>Email</th>
                <th>Komentar / Ulasan</th>
                <th>Rating</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = mysqli_fetch_assoc($query)) { 
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_user']); ?></td>
                <td><?php echo htmlspecialchars($row['email_user']); ?></td>
                <td><?php echo htmlspecialchars($row['komentar']); ?></td>
                <td><span class="badge-rating">⭐ <?php echo $row['rating']; ?></span></td>
                <td>
                    <a href="hapus_ulasan.php?id=<?php echo $row['id_ulasan']; ?>" class="btn-hapus" onclick="return confirm('Apakah kamu yakin ingin menghapus ulasan ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>