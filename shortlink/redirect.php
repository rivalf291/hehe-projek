<?php

// --- Konfigurasi Database ---
// Ganti dengan detail koneksi database Anda.
define('DB_HOST', 'sql100.infinityfree.com');
define('DB_USER', 'if0_39811554');     // Ganti dengan username database Anda
define('DB_PASS', 'Kuebalok00783');         // Ganti dengan password database Anda
define('DB_NAME', 'if0_39811554_shortlink');

// --- Halaman Fallback ---
// Jika short code tidak ditemukan, pengguna akan diarahkan ke URL ini.
// Ganti dengan domain utama atau halaman 404 kustom Anda.
define('FALLBACK_URL', 'https://gas.ct.ws/'); // Ganti dengan URL Anda

// 1. Membuat koneksi ke database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    // Sebaiknya log error ini daripada menampilkannya ke pengguna
    error_log("Connection failed: " . $conn->connect_error);
    // Arahkan ke halaman fallback jika koneksi gagal
    header("Location: " . FALLBACK_URL);
    exit();
}

// 2. Mengambil short_code dari URL yang diberikan oleh .htaccess
$short_code = isset($_GET['code']) ? trim($_GET['code']) : '';

if (empty($short_code)) {
    // Jika tidak ada kode (misalnya, akses langsung ke domain), arahkan ke halaman utama
    header("Location: " . FALLBACK_URL);
    exit();
}

// 3. Mencari original_url di database menggunakan prepared statement untuk keamanan
$stmt = $conn->prepare("SELECT id, original_url FROM short_links WHERE short_code = ? AND status = 'active' LIMIT 1");
if ($stmt === false) {
    error_log("Prepare failed: " . $conn->error);
    header("Location: " . FALLBACK_URL);
    exit();
}

$stmt->bind_param("s", $short_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // 4. Jika short_code ditemukan
    $row = $result->fetch_assoc();
    $link_id = $row['id'];
    $original_url = $row['original_url'];

    // Menambah (increment) jumlah klik secara atomik
    $update_stmt = $conn->prepare("UPDATE short_links SET clicks = clicks + 1 WHERE id = ?");
    if ($update_stmt) {
        $update_stmt->bind_param("i", $link_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Log error jika gagal update, tapi tetap lanjutkan redirect
        error_log("Failed to update clicks for link ID: " . $link_id . " - " . $conn->error);
    }

    // 5. Melakukan redirect ke URL asli
    // Menggunakan 301 redirect (Moved Permanently) yang baik untuk SEO
    header("Location: " . $original_url, true, 301);
    exit();

} else {
    // 6. Jika short_code tidak ditemukan, arahkan ke halaman fallback
    header("Location: " . FALLBACK_URL);
    exit();
}

$stmt->close();
$conn->close();

?>