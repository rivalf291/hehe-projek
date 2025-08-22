<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config.php';

// Cek status nawala pada domain di setiap halaman
$allDomainsHeader = getAllDomains($pdo);
$nawalaDomainsHeader = [];
foreach ($allDomainsHeader as $domain) {
    // Gunakan strtolower untuk memastikan pengecekan tidak case-sensitive
    if (isset($domain['status']) && strtolower($domain['status']) === 'nawala') {
        // Kumpulkan semua nama domain yang terkena nawala
        $nawalaDomainsHeader[] = htmlspecialchars($domain['domain_name']);
    }
}

// Jika ada domain yang terkena nawala, buat pesan notifikasi yang spesifik
if (!empty($nawalaDomainsHeader)) {
    $_SESSION['nawala_count'] = count($nawalaDomainsHeader);
    if (count($nawalaDomainsHeader) > 1) {
        // Pesan untuk lebih dari satu domain
        $domainList = implode(', ', $nawalaDomainsHeader);
        $_SESSION['nawala_notification'] = "Peringatan: Domain berikut terindikasi Nawala: {$domainList}. Silakan periksa Manage Domain.";
    } else {
        // Pesan untuk satu domain
        $domainName = $nawalaDomainsHeader[0];
        $_SESSION['nawala_notification'] = "Peringatan: Domain '{$domainName}' terindikasi Nawala. Silakan periksa Manage Domain.";
    }
} else {
    // Jika tidak ada domain nawala, bersihkan session terkait
    unset($_SESSION['nawala_notification']);
    unset($_SESSION['nawala_count']);
}
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title><?php echo isset($page_title) ? $page_title . ' - Projek Guys Panel' : 'Projek Guys Panel - Test Server'; ?></title>
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons/css/all.min.css">
    <!-- Main styles for this application-->
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/config.js"></script>
    <script src="js/color-modes.js"></script>
  </head>
  <body>