<?php
require_once 'config.php';
$page_title = 'Domain List';
$breadcrumb_title = 'Domain List';

// Ambil semua domain dari database
$domains = getAllDomains($pdo);
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

      <div class="body flex-grow-1">
          <div class="container">
            <div class="row min-vh-100">
              <div class="col-12">
                <h1>Daftar Domain</h1>
                <p class="lead">Semua domain yang terdaftar di sistem.</p>
                
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Semua Domain</strong>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Domain</th>
                            <?php if ($userLevel == 'basic'): ?>
                            <th>Status</th>
                            <?php endif; ?> 
                            <?php if ($userLevel == 'premium'): ?>
                            <th>Status Trust+</th>
                            <th>Status XL</th>
                            <th>Status TSEL</th>
                            <th>Status INDOSAT</th>
                            <?php endif; ?> 
                            <?php if ($userLevel == 'super'): ?>
                            <th>Status Trust+</th>
                            <th>Status XL</th>
                            <th>Status TSEL</th>
                            <th>Status INDOSAT</th>
                            <?php endif; ?> 
                            <?php if ($userLevel == 'admin'): ?>
                            <th>Status Trust+</th>
                            <th>Status XL</th>
                            <th>Status TSEL</th>
                            <th>Status INDOSAT</th>
                            <?php endif; ?> 
                            <th>Tanggal Registrasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($domains as $index => $domain): ?>
                          <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($domain['domain_name']) ?></td>
                            <td>
                              <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                <?= $domain['status'] ?>
                              </span>
                            </td>
                            <?php if ($userLevel == 'premium'): ?>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statusxl'] ?>
                                  </span>
                                </td>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statustsel'] ?>
                                  </span>
                                </td>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statusisat'] ?>
                                  </span>
                                </td>
                              <?php endif; ?> 
                              <?php if ($userLevel == 'super'): ?>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statusxl'] ?>
                                  </span>
                                </td>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statustsel'] ?>
                                  </span>
                                </td>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statusisat'] ?>
                                  </span>
                                </td>
                              <?php endif; ?> 
                              <?php if ($userLevel == 'admin'): ?>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statusxl'] ?>
                                  </span>
                                </td>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statustsel'] ?>
                                  </span>
                                </td>
                                <td>
                                  <span class="badge bg-<?= $domain['status'] == 'Aman' ? 'success' : 'danger' ?>">
                                  <?= $domain['statusisat'] ?>
                                  </span>
                                </td>
                              <?php endif; ?> 
                            <td><?= date('d M Y', strtotime($domain['created_at'])) ?></td>
                          </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<script>
function deleteDomain(id) {
    if (confirm('Apakah Anda yakin ingin menghapus domain ini?')) {
        // Implementasi AJAX untuk delete
        window.location.href = 'manage-domain.php?delete=' + id;
    }
}
</script>

<?php include 'template/footer.php'; ?>
