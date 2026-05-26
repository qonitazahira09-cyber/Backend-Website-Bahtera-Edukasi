<?php
// =============================================
// review.php — API Submit, Ambil Review, Toggle Like
// Endpoint: review.php?action=get | submit | like
// =============================================

session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

$action    = $_GET['action']   ?? '';
$kontenId  = $_GET['konten']   ?? 'mod-aki-aksa';

switch ($action) {

    // ------------------------------------------
    // AMBIL semua review beserta rata-rata rating
    // Method: GET
    // ------------------------------------------
    case 'get':
        // Ambil semua review dengan nama user & jumlah like
        $stmt = $pdo->prepare('
            SELECT
                r.id,
                u.nama          AS user_nama,
                r.rating,
                r.ulasan,
                r.created_at,
                COUNT(rl.id)    AS total_likes,
                MAX(CASE WHEN rl.user_id = :uid THEN 1 ELSE 0 END) AS user_liked
            FROM reviews r
            JOIN users u ON u.id = r.user_id
            LEFT JOIN review_likes rl ON rl.review_id = r.id
            WHERE r.konten_id = :kid
            GROUP BY r.id
            ORDER BY r.created_at DESC
        ');
        $stmt->execute([
            ':uid' => $_SESSION['user_id'] ?? 0,
            ':kid' => $kontenId,
        ]);
        $reviews = $stmt->fetchAll();

        // Hitung rata-rata rating & distribusi bintang
        $stmt2 = $pdo->prepare('
            SELECT
                AVG(rating)                              AS avg_rating,
                COUNT(*)                                 AS total,
                SUM(rating = 5)                          AS star5,
                SUM(rating = 4)                          AS star4,
                SUM(rating = 3)                          AS star3,
                SUM(rating = 2)                          AS star2,
                SUM(rating = 1)                          AS star1
            FROM reviews
            WHERE konten_id = ?
        ');
        $stmt2->execute([$kontenId]);
        $stat = $stmt2->fetch();

        jsonResponse(true, 'OK', [
            'reviews'    => $reviews,
            'avg_rating' => $stat['avg_rating'] ? round($stat['avg_rating'], 1) : 0,
            'total'      => (int)$stat['total'],
            'dist'       => [
                5 => (int)$stat['star5'],
                4 => (int)$stat['star4'],
                3 => (int)$stat['star3'],
                2 => (int)$stat['star2'],
                1 => (int)$stat['star1'],
            ],
        ]);
        break;

    // ------------------------------------------
    // SUBMIT review baru (harus login)
    // Method: POST
    // Body JSON: { rating, ulasan }
    // ------------------------------------------
    case 'submit':
        if (!isset($_SESSION['user_id'])) {
            jsonResponse(false, 'Harus login untuk memberi ulasan.');
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            jsonResponse(false, 'Method tidak valid.');
        }

        $body   = json_decode(file_get_contents('php://input'), true);
        $rating = (int)($body['rating'] ?? 0);
        $ulasan = trim($body['ulasan'] ?? '');

        if ($rating < 1 || $rating > 5) {
            jsonResponse(false, 'Rating harus antara 1–5 bintang.');
        }
        if (!$ulasan) {
            jsonResponse(false, 'Ulasan tidak boleh kosong.');
        }

        // Cek apakah user sudah pernah review konten ini
        $stmt = $pdo->prepare('SELECT id FROM reviews WHERE user_id = ? AND konten_id = ?');
        $stmt->execute([$_SESSION['user_id'], $kontenId]);
        if ($stmt->fetch()) {
            jsonResponse(false, 'Kamu sudah pernah memberi ulasan untuk konten ini.');
        }

        // Simpan review
        $stmt = $pdo->prepare('
            INSERT INTO reviews (user_id, konten_id, rating, ulasan)
            VALUES (?, ?, ?, ?)
        ');
        $stmt->execute([$_SESSION['user_id'], $kontenId, $rating, $ulasan]);

        jsonResponse(true, 'Ulasan berhasil disimpan!');
        break;

    // ------------------------------------------
    // TOGGLE LIKE pada sebuah review (harus login)
    // Method: POST
    // Body JSON: { review_id }
    // ------------------------------------------
    case 'like':
        if (!isset($_SESSION['user_id'])) {
            jsonResponse(false, 'Harus login untuk memberi suka.');
        }

        $body      = json_decode(file_get_contents('php://input'), true);
        $reviewId  = (int)($body['review_id'] ?? 0);
        $userId    = $_SESSION['user_id'];

        if (!$reviewId) {
            jsonResponse(false, 'review_id tidak valid.');
        }

        // Cek apakah sudah like
        $stmt = $pdo->prepare('SELECT id FROM review_likes WHERE review_id = ? AND user_id = ?');
        $stmt->execute([$reviewId, $userId]);
        $existing = $stmt->fetch();

        if ($existing) {
            // Sudah like → unlike
            $pdo->prepare('DELETE FROM review_likes WHERE review_id = ? AND user_id = ?')
                ->execute([$reviewId, $userId]);
            $liked = false;
        } else {
            // Belum like → like
            $pdo->prepare('INSERT INTO review_likes (review_id, user_id) VALUES (?, ?)')
                ->execute([$reviewId, $userId]);
            $liked = true;
        }

        // Hitung total like terbaru
        $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM review_likes WHERE review_id = ?');
        $stmt->execute([$reviewId]);
        $total = (int)$stmt->fetchColumn();

        jsonResponse(true, $liked ? 'Disukai.' : 'Batal disukai.', [
            'liked' => $liked,
            'total' => $total,
        ]);
        break;

    default:
        jsonResponse(false, 'Action tidak dikenali.');
}