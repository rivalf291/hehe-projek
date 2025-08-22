<?php
require_once 'config.php';

session_start();

$page_title = 'Dashboard';
$breadcrumb_title = 'Dashboard';

// Ambil total domain dan short link dari database
$allDomains = getAllDomains($pdo);
$totalDomains = count($allDomains);
$totalShortLinks = count(getAllShortLinks($pdo));

// Cek status nawala pada domain
$nawalaDomains = [];
foreach ($allDomains as $domain) {
    // Gunakan strtolower untuk memastikan pengecekan tidak case-sensitive
    if (isset($domain['status']) && strtolower($domain['status']) === 'nawala') {
        // Kumpulkan semua nama domain yang terkena nawala
        $nawalaDomains[] = htmlspecialchars($domain['domain_name']);
    }
}

// Jika ada domain yang terkena nawala, buat pesan notifikasi yang spesifik
if (!empty($nawalaDomains)) {
    $_SESSION['nawala_count'] = count($nawalaDomains);
    if (count($nawalaDomains) > 1) {
        // Pesan untuk lebih dari satu domain
        $domainList = implode(', ', $nawalaDomains);
        $_SESSION['nawala_notification'] = "Peringatan: Domain berikut terindikasi Nawala: {$domainList}. Silakan periksa Manage Domain.";
    } else {
        // Pesan untuk satu domain
        $domainName = $nawalaDomains[0];
        $_SESSION['nawala_notification'] = "Peringatan: Domain '{$domainName}' terindikasi Nawala. Silakan periksa Manage Domain.";
    }
} else {
    unset($_SESSION['nawala_notification']);
    unset($_SESSION['nawala_count']);
}

// Untuk debugging, Anda bisa uncomment baris di bawah ini untuk melihat isi session
// var_dump($_SESSION);
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

      <div class="body flex-grow-1">
          <div class="container">
            <div class="row justify-content-center min-vh-100">
              <div class="col-12">
                <div class="row g-4">
                  <!-- Baris 1 -->
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">Total Domain</div>
                      <div class="card-body">
                        <h5 class="card-title"><?= $totalDomains ?> Domain</h5>
                        <p class="card-text"><?= $totalDomains ?> domain dikelola di panel ini.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">Total Short Link</div>
                      <div class="card-body">
                        <h5 class="card-title"><?= $totalShortLinks ?> Short Link</h5>
                        <p class="card-text"><?= $totalShortLinks ?> short link dikelola di panel ini.</p>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Baris 2 -->
                  <div class="col-md-6">
                  <div class="card">
                      <div class="card-header">User Level</div>
                      <div class="card-body">
                        <?php
                        $userLevel = $_SESSION['level'] ?? 'basic';
                        ?>
                        <h5 class="card-title"><?= ucfirst($userLevel) ?></h5>
                        <p class="card-text">Benefit <br> * Manage Domain <br> * Auto Cek Domain Via Trust Positif <br> * Telegram Group
                        <?php if ($userLevel == 'premium'): ?>
                          <br> * Auto Cek Nawala Via Provider (XL, Telkomsel, Indosat)
                        <?php endif; ?>  
                        <?php if ($userLevel == 'super'): ?>
                          <br> * Generate Short Link <br> * Manage Short Link
                        <?php endif; ?>
                        <?php if ($userLevel == 'admin'): ?>
                          <br> * Manage User
                        <?php endif; ?>
                      </p>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">Upgrade Level / Ada Masalah?</div>
                      <div class="card-body">
                        <h5 class="card-title">Hubungi Kami</h5>
                        <p class="card-text"><a class="btn btn-primary" href="#" role="button">Telegram</a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php include 'template/footer.php'; ?>
<?php include 'template/toast-notification.php'; ?>
