<?php
require_once 'config.php';

$page_title = 'Manage Domain';
$breadcrumb_title = 'Manage Domain';

// Ambil semua domain dari database
$domains = getAllDomains($pdo);

// Proses hapus domain jika ada request
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    deleteDomain($pdo, $deleteId);
    header('Location: manage-domain.php');
    exit;
}

// Proses tambah domain dari popup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $domain_name = $_POST['domain_name'] ?? '';
    $status = $_POST['status'] ?? 'Aman';


    $data = [
        'domain_name' => $domain_name,
        'status' => $status
    ];

    addDomain($pdo, $data);
    header('Location: manage-domain.php');
    exit;
}

// Proses update domain
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = intval($_POST['id']);
    $domain_name = $_POST['domain_name'] ?? '';
    $status = $_POST['status'] ?? 'Aman';

    $data = [
        'domain_name' => $domain_name,
        'status' => $status
    ];

    updateDomain($pdo, $id, $data);
    header('Location: manage-domain.php');
    exit;
}
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

<div class="body flex-grow-1">
  <div class="container">
    <div class="row min-vh-100">
      <div class="col-12">
        <h1>Manage Domain</h1>
        <p class="lead">Kelola semua domain Anda dengan mudah</p>
        
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Daftar Domain</strong>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDomainModal">
              <i class="fas fa-plus"></i> Tambah Domain Baru
            </button>
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
                    <th>Aksi</th>
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
                      <span class="badge bg-<?= $domain['statusxl'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statusxl'] ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-<?= $domain['statustsel'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statustsel'] ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-<?= $domain['statusisat'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statusisat'] ?>
                      </span>
                    </td>
                  <?php endif; ?> 
                  <?php if ($userLevel == 'super'): ?>
                    <td>
                      <span class="badge bg-<?= $domain['statusxl'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statusxl'] ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-<?= $domain['statustsel'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statustsel'] ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-<?= $domain['statusisat'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statusisat'] ?>
                      </span>
                    </td>
                  <?php endif; ?> 
                  <?php if ($userLevel == 'admin'): ?>
                    <td>
                      <span class="badge bg-<?= $domain['statusxl'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statusxl'] ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-<?= $domain['statustsel'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statustsel'] ?>
                      </span>
                    </td>
                    <td>
                      <span class="badge bg-<?= $domain['statusisat'] == 'Aman' ? 'success' : 'danger' ?>">
                      <?= $domain['statusisat'] ?>
                      </span>
                    </td>
                  <?php endif; ?>
                    <td><?= date('d M Y', strtotime($domain['created_at'])) ?></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-outline-primary" 
                              onclick="editDomain(<?= $domain['id'] ?>, '<?= htmlspecialchars($domain['domain_name']) ?>', '<?= $domain['status'] ?>')">
                        Edit
                      </button>
                      <a href="manage-domain.php?delete=<?= $domain['id'] ?>" class="btn btn-sm btn-outline-danger" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus domain ini?')">Hapus</a>
                    </td>
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
    <!-- Modal Tambah Domain -->
    <div class="modal fade" id="addDomainModal" tabindex="-1" aria-labelledby="addDomainModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addDomainModalLabel">Tambah Domain Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="">
              <input type="hidden" name="action" value="add">
              <div class="mb-3">
                <label for="domain_name" class="form-label">Nama Domain</label>
                <input type="text" class="form-control" id="domain_name" name="domain_name" required 
                      placeholder="contoh: example.com">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Domain</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Edit Domain -->
    <div class="modal fade" id="editDomainModal" tabindex="-1" aria-labelledby="editDomainModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editDomainModalLabel">Edit Domain</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="">
              <input type="hidden" name="action" value="edit">
              <input type="hidden" name="id" id="edit_id">
              <div class="mb-3">
                <label for="edit_domain_name" class="form-label">Nama Domain</label>
                <input type="text" class="form-control" id="edit_domain_name" name="domain_name" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Update Domain</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

<script>
// Fungsi untuk edit domain
function editDomain(id, domainName, status, expiryDate) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_domain_name').value = domainName;
    new bootstrap.Modal(document.getElementById('editDomainModal')).show();
}
</script>
<?php include 'template/footer.php'; ?>
