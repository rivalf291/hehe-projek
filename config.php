<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'nawala');
define('DB_USER', 'root');
define('DB_PASS', '');

// Konfigurasi URL
define('BASE_URL', 'http://localhost/');

// Membuat koneksi ke database
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi untuk mendapatkan semua domain
function getAllDomains($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM domains ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllUsers($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk mendapatkan semua short links
function getAllShortLinks($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM short_links ORDER BY created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fungsi untuk mendapatkan domain berdasarkan ID
function getDomainById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM domains WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fungsi untuk mendapatkan short link berdasarkan ID
function getShortLinkById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM short_links WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fungsi untuk menambah domain baru
function addDomain($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO domains (domain_name, status, created_at) VALUES (?, ?, NOW())");
    return $stmt->execute([$data['domain_name'], $data['status']]);
}

function addUser($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, created_at, level) VALUES (?, ?, ?, NOW(), ?)");
    return $stmt->execute([$data['username'], $data['email'],$data['password_hash'],$data['level']]);
}

// Fungsi untuk menambah short link baru
function addShortLink($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO short_links (short_code, original_url, clicks, status, created_at) VALUES (?, ?, 0, 'active', NOW())");
    return $stmt->execute([$data['short_code'], $data['original_url']]);
}

// Fungsi untuk update domain
function updateDomain($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE domains SET domain_name = ?, status = ? WHERE id = ?");
    return $stmt->execute([$data['domain_name'], $data['status'], $id]);
}

// Fungsi untuk update short link
function updateShortLink($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE short_links SET short_code = ?, original_url = ?, status = ? WHERE id = ?");
    return $stmt->execute([$data['short_code'], $data['original_url'], $data['status'], $id]);
}

// Fungsi untuk menghapus domain
function deleteDomain($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM domains WHERE id = ?");
    return $stmt->execute([$id]);
}

// Fungsi untuk menghapus short link
function deleteShortLink($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM short_links WHERE id = ?");
    return $stmt->execute([$id]);
}

// Fungsi untuk generate short code
function generateShortCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $shortCode = '';
    for ($i = 0; $i < $length; $i++) {
        $shortCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $shortCode;
}
?>
