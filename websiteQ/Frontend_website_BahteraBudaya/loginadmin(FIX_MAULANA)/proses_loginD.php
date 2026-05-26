<?php
session_start();
// Menggunakan nama file sesuai di folder kamu
include 'koneksiD.php'; 


if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

$query = "SELECT * FROM login WHERE username='$username' AND password='$password'";    
    // Pastikan variabel $koneksi di bawah ini huruf kecil semua
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['admin'] = $username;
        header("Location: ../DshAdmin/DCadmin.php"); 
        exit;
    } else {
        echo "<script>
                alert('Username atau Password salah!');
                window.location.href='page-loginAdmin.php';
              </script>";
    }
}
?>