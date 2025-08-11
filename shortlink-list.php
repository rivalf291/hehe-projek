<?php
require_once 'config.php';
$page_title = 'Short Link List';
$breadcrumb_title = 'Short Link List';

// Ambil semua short link dari database
$shortLinks = getAllShortLinks($pdo);
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

<div class="body flex-grow-1">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Short Link List</h1>
        <p class="lead">Daftar semua short link yang tersedia.</p>

        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Semua Short Link</strong>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Short Link</th>
                    <th>URL Asli</th>
                    <th>Klik</th>
                    <th>Tanggal Buat</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($shortLinks as $index => $link): ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><a href="<?= htmlspecialchars($link['short_code']) ?>" class="text-decoration-none"><?= htmlspecialchars($link['short_code']) ?></a></td>
                    <td><?= htmlspecialchars($link['original_url']) ?></td>
                    <td><?= $link['clicks'] ?></td>
                    <td><?= date('d M Y', strtotime($link['created_at'])) ?></td>
                    <td>
                      <span class="badge bg-<?= $link['status'] == 'active' ? 'success' : 'secondary' ?>">
                        <?= $link['status'] ?>
                      </span>
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

<script>
function deleteShortLink(id) {
  if (confirm('Apakah Anda yakin ingin menghapus short link ini?')) {
    window.location.href = 'manage-shortlink.php?delete=' + id;
  }
}
</script>

<?php include 'template/footer.php'; ?>
