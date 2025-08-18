<?php
require_once 'config.php';

$page_title = 'Dashboard';
$breadcrumb_title = 'Dashboard';

// Ambil total domain dan short link dari database
$totalDomains = count(getAllDomains($pdo));
$totalShortLinks = count(getAllShortLinks($pdo));
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
                        session_start();
                        $userLevel = $_SESSION['level'] ?? 'basic';
                        ?>
                        <h5 class="card-title"><?= ucfirst($userLevel) ?></h5>
                        <p class="card-text">Benefit <br> * A <br> * B <br> * C</p>
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
