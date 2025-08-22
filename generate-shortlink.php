<?php
require_once 'config.php';

$page_title = 'Generate Short Link';
$breadcrumb_title = 'Generate Short Link';

// Proses simpan short link baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_url = $_POST['original_url'] ?? '';
    $custom_slug = $_POST['custom_slug'] ?? '';
    
    // Generate short code
    $short_code = !empty($custom_slug) ? $custom_slug : generateShortCode();
    
    // Validasi URL
    if (filter_var($original_url, FILTER_VALIDATE_URL)) {
        $data = [
            'short_code' => $short_code,
            'original_url' => $original_url
        ];
        
        if (addShortLink($pdo, $data)) {
            $success_message = "Short link berhasil dibuat: " . BASE_URL . $short_code;
        } else {
            $error_message = "Gagal membuat short link. Silakan coba lagi.";
        }
    } else {
        $error_message = "URL tidak valid. Silakan masukkan URL yang benar.";
    }
}
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

<div class="body flex-grow-1">
  <div class="container">
    <div class="row min-vh-100">
      <div class="col-12">
        <h1>Generate Short Link</h1>
        <p class="lead">Buat short link untuk URL panjang Anda dengan mudah.</p>
        
        <?php if (isset($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($success_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($error_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <strong>Form Generate Short Link</strong>
              </div>
              <div class="card-body">
                <form method="post" action="">
                  <div class="mb-3">
                    <label for="original_url" class="form-label">URL Panjang</label>
                    <input type="url" class="form-control" id="original_url" name="original_url" 
                           required placeholder="https://example.com/very-long-url-here">
                  </div>
                  
                  <div class="mb-3">
                    <label for="custom_slug" class="form-label">Custom Slug (Opsional)</label>
                    <input type="text" class="form-control" id="custom_slug" name="custom_slug" 
                           placeholder="my-custom-link">
                    <small class="text-muted">Jika dikosongkan, akan dibuatkan otomatis</small>
                  </div>
                  
                  <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-link"></i> Generate Short Link
                    </button>
                    <a href="shortlink-list.php" class="btn btn-secondary">
                      <i class="fas fa-list"></i> Lihat Semua
                    </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <strong>Statistik</strong>
              </div>
              <div class="card-body">
                <?php
                $total_links = $pdo->query("SELECT COUNT(*) FROM short_links")->fetchColumn();
                $total_clicks = $pdo->query("SELECT SUM(clicks) FROM short_links")->fetchColumn();
                $active_links = $pdo->query("SELECT COUNT(*) FROM short_links WHERE status = 'active'")->fetchColumn();
                ?>
                <p><strong>Total Short Link:</strong> <?= $total_links ?></p>
                <p><strong>Total Klik:</strong> <?= $total_clicks ?></p>
                <p><strong>Short Link Aktif:</strong> <?= $active_links ?></p>
              </div>
            </div>
            
            <div class="card mt-3">
              <div class="card-header">
                <strong>Petunjuk</strong>
              </div>
              <div class="card-body">
                <ul>
                  <li>Masukkan URL lengkap dengan http:// atau https://</li>
                  <li>Custom slug bersifat opsional</li>
                  <li>Slug akan dibuat otomatis jika dikosongkan</li>
                  <li>Short link akan aktif segera setelah dibuat</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>
