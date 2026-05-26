<?php
// =============================================
// auth.php — API Login, Daftar, Cek Sesi, Logout
// Endpoint: auth.php?action=register | login | check | logout
// =============================================

session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

$action = $_GET['action'] ?? '';

switch ($action) {

    // ------------------------------------------
    // DAFTAR akun baru
    // Method: POST
    // Body JSON: { nama, email, password }
    // ------------------------------------------
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            jsonResponse(false, 'Method tidak valid.');
        }

        $body = json_decode(file_get_contents('php://input'), true);
        $nama     = trim($body['nama']     ?? '');
        $email    = trim($body['email']    ?? '');
        $password = trim($body['password'] ?? '');

        // Validasi input
        if (!$nama || !$email || !$password) {
            jsonResponse(false, 'Nama, email, dan password wajib diisi.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            jsonResponse(false, 'Format email tidak valid.');
        }
        if (strlen($password) < 6) {
            jsonResponse(false, 'Password minimal 6 karakter.');
        }

        // Cek apakah email sudah terdaftar
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            jsonResponse(false, 'Email sudah terdaftar. Silakan login.');
        }

        // Simpan ke database (password di-hash)
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO users (nama, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$nama, $email, $hash]);
        $userId = $pdo->lastInsertId();

        // Langsung login setelah daftar
        $_SESSION['user_id']   = $userId;
        $_SESSION['user_nama'] = $nama;

        jsonResponse(true, 'Akun berhasil dibuat!', ['nama' => $nama]);
        break;

    // ------------------------------------------
    // LOGIN dengan email & password
    // Method: POST
    // Body JSON: { email, password }
    // ------------------------------------------
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            jsonResponse(false, 'Method tidak valid.');
        }

        $body     = json_decode(file_get_contents('php://input'), true);
        $email    = trim($body['email']    ?? '');
        $password = trim($body['password'] ?? '');

        if (!$email || !$password) {
            jsonResponse(false, 'Email dan password wajib diisi.');
        }

        // Cari user berdasarkan email
        $stmt = $pdo->prepare('SELECT id, nama, password FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            jsonResponse(false, 'Email atau password salah.');
        }

        // Simpan ke session
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_nama'] = $user['nama'];

        jsonResponse(true, 'Login berhasil!', ['nama' => $user['nama']]);
        break;

    // ------------------------------------------
    // CEK apakah sudah login (dipanggil saat halaman dimuat)
    // Method: GET
    // ------------------------------------------
    case 'check':
        if (isset($_SESSION['user_id'])) {
            jsonResponse(true, 'Sudah login.', ['nama' => $_SESSION['user_nama']]);
        } else {
            jsonResponse(false, 'Belum login.');
        }
        break;

    // ------------------------------------------
    // LOGOUT
    // Method: GET atau POST
    // ------------------------------------------
    case 'logout':
        session_destroy();
        jsonResponse(true, 'Logout berhasil.');
        break;

    default:
        jsonResponse(false, 'Action tidak dikenali.');
}