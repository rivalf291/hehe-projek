<?php
require_once 'config.php';

$page_title = 'Manage Short Link';
$breadcrumb_title = 'Manage Short Link';

// --- Logic to manage custom shortlink domain ---
// Catatan: Kode ini mengasumsikan Anda memiliki tabel 'settings' dengan kolom 'name' dan 'value'.
// Kolom 'name' harus unik. Domain akan disimpan dengan name = 'shortlink_domain'.

// Ambil domain kustom dari database
try {
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'shortlink_domain'");
    $stmt->execute();
    $shortlink_domain_setting = $stmt->fetch(PDO::FETCH_ASSOC);
    // Gunakan domain kustom jika ada, jika tidak, gunakan BASE_URL dari config.php
    $shortlink_domain = $shortlink_domain_setting ? rtrim($shortlink_domain_setting['setting_value'], '/') : rtrim(BASE_URL, '/');
} catch (PDOException $e) {
    // Jika tabel tidak ada atau terjadi error DB, gunakan BASE_URL
    $shortlink_domain = rtrim(BASE_URL, '/');
}

// Proses permintaan untuk update domain
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_domain') {
    $new_domain = rtrim($_POST['shortlink_domain'] ?? '', '/');
    try {
        if (filter_var($new_domain, FILTER_VALIDATE_URL)) {
            // Cek apakah setting sudah ada
            $stmt = $pdo->prepare("SELECT setting_key FROM settings WHERE setting_key = 'shortlink_domain'");
            $stmt->execute();
            if ($stmt->fetch()) {
                $updateStmt = $pdo->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'shortlink_domain'");
                $updateStmt->execute([$new_domain]);
            } else {
                $insertStmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)");
                $insertStmt->execute(['shortlink_domain', $new_domain]);
            }
            header('Location: manage-shortlink.php');
            exit;
        } else {
            $error_message = "URL Domain tidak valid. Silakan masukkan URL yang benar.";
        }
    } catch (PDOException $e) {
        // Tangani error jika tabel 'settings' tidak ada atau ada masalah lain
        $error_message = "Terjadi kesalahan database saat memperbarui domain. Pastikan tabel 'settings' sudah ada.";
    }
}

// Ambil semua short links dari database
$shortLinks = getAllShortLinks($pdo);

// Proses hapus short link jika ada request
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    deleteShortLink($pdo, $deleteId);
    header('Location: manage-shortlink.php');
    exit;
}

// Proses tambah short link dari popup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $short_code = $_POST['short_code'] ?? '';
    $original_url = $_POST['original_url'] ?? '';
    $status = $_POST['status'] ?? 'active';

    // Validasi URL
    if (filter_var($original_url, FILTER_VALIDATE_URL)) {
        $data = [
            'short_code' => $short_code,
            'original_url' => $original_url,
            'status' => $status
        ];

        addShortLink($pdo, $data);
        header('Location: manage-shortlink.php');
        exit;
    } else {
        $error_message = "URL tidak valid. Silakan masukkan URL yang benar.";
    }
}

// Proses update short link
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = intval($_POST['id']);
    $short_code = $_POST['short_code'] ?? '';
    $original_url = $_POST['original_url'] ?? '';
    $status = $_POST['status'] ?? 'active';

    // Validasi URL
    if (filter_var($original_url, FILTER_VALIDATE_URL)) {
        $data = [
            'short_code' => $short_code,
            'original_url' => $original_url,
            'status' => $status
        ];

        updateShortLink($pdo, $id, $data);
        header('Location: manage-shortlink.php');
        exit;
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1>Manage Short Link</h1>
                <p class="lead mb-0">Kelola semua short link Anda dengan mudah</p>
            </div>
            <?php if ($userLevel == 'admin'): ?>
            <div>
                <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#manageDomainModal">
                    Kelola Domain
                </button>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($error_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Short Code</th>
                    <th>URL Asli</th>
                    <th>Klik</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($shortLinks as $index => $link): ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td>
                      <a href="<?= htmlspecialchars($shortlink_domain) . '/' . htmlspecialchars($link['short_code']) ?>" target="_blank">
                        <?= htmlspecialchars(str_replace(['http://', 'https://'], '', $shortlink_domain)) . '/' . htmlspecialchars($link['short_code']) ?>
                      </a>
                    </td>
                    <td>
                      <span class="text-truncate d-inline-block" style="max-width: 200px;">
                        <?= htmlspecialchars($link['original_url']) ?>
                      </span>
                    </td>
                    <td><?= number_format($link['clicks']) ?></td>
                    <td>
                      <span class="badge bg-<?= $link['status'] == 'active' ? 'success' : 'danger' ?>">
                        <?= ucfirst($link['status']) ?>
                      </span>
                    </td>
                    <td><?= date('d M Y', strtotime($link['created_at'])) ?></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-outline-primary" 
                              onclick="editShortLink(<?= $link['id'] ?>, '<?= htmlspecialchars($link['short_code']) ?>', '<?= htmlspecialchars($link['original_url']) ?>', '<?= $link['status'] ?>')">
                        Edit
                      </button>
                      <a href="manage-shortlink.php?delete=<?= $link['id'] ?>" class="btn btn-sm btn-outline-danger" 
                         onclick="return confirm('Apakah Anda yakin ingin menghapus short link ini?')">Hapus</a>
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

<!-- Modal Tambah Short Link -->
<div class="modal fade" id="addShortLinkModal" tabindex="-1" aria-labelledby="addShortLinkModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addShortLinkModalLabel">Tambah Short Link Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <input type="hidden" name="action" value="add">
          <div class="mb-3">
            <label for="add_short_code" class="form-label">Short Code</label>
            <input type="text" class="form-control" id="add_short_code" name="short_code" required 
                   placeholder="contoh: abc123">
          </div>
          <div class="mb-3">
            <label for="add_original_url" class="form-label">URL Asli</label>
            <input type="url" class="form-control" id="add_original_url" name="original_url" required 
                   placeholder="https://example.com/very-long-url-here">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Short Link</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Kelola Domain -->
<div class="modal fade" id="manageDomainModal" tabindex="-1" aria-labelledby="manageDomainModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="manageDomainModalLabel">Kelola Domain Shortlink</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <input type="hidden" name="action" value="update_domain">
          <div class="mb-3">
            <label for="shortlink_domain" class="form-label">Domain Shortlink</label>
            <input type="url" class="form-control" id="shortlink_domain" name="shortlink_domain" required 
                   placeholder="https://contoh.com" value="<?= htmlspecialchars($shortlink_domain) ?>">
            <div class="form-text">Masukkan domain lengkap yang akan digunakan untuk short link, contoh: https://s.id</div>
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

<!-- Modal Edit Short Link -->
<div class="modal fade" id="editShortLinkModal" tabindex="-1" aria-labelledby="editShortLinkModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editShortLinkModalLabel">Edit Short Link</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <input type="hidden" name="action" value="edit">
          <input type="hidden" name="id" id="edit_shortlink_id">
          <div class="mb-3">
            <label for="edit_short_code" class="form-label">Short Code</label>
            <input type="text" class="form-control" id="edit_short_code" name="short_code" required>
          </div>
          <div class="mb-3">
            <label for="edit_original_url" class="form-label">URL Asli</label>
            <input type="url" class="form-control" id="edit_original_url" name="original_url" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update Short Link</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Fungsi untuk edit short link
function editShortLink(id, shortCode, originalUrl, status) {
    document.getElementById('edit_shortlink_id').value = id;
    document.getElementById('edit_short_code').value = shortCode;
    document.getElementById('edit_original_url').value = originalUrl;
    new bootstrap.Modal(document.getElementById('editShortLinkModal')).show();
}
</script>
<?php include 'template/footer.php'; ?>
