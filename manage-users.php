<?php
require_once 'config.php';

$page_title = 'Manage Users';
$breadcrumb_title = 'Manage Users';

// Ambil semua user dari database
$users = getAllUsers($pdo);

// Proses hapus user jika ada request
if (isset($_GET['delete'])) {
    $deleteId = intval($_GET['delete']);
    deleteUser($pdo, $deleteId);
    header('Location: manage-users.php');
    exit;
}

// Proses tambah user dari popup
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $level = $_POST['level'] ?? 'basic';

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $data = [
        'username' => $username,
        'email' => $email,
        'password_hash' => $password_hash,
        'level' => $level
    ];

    addUser($pdo, $data);
    header('Location: manage-users.php');
    exit;
}

// Proses update user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = intval($_POST['id']);
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $level = $_POST['level'] ?? 'basic';

    $data = [
        'username' => $username,
        'email' => $email,
        'level' => $level
    ];

    // Jika password diisi, update juga
    if (!empty($_POST['password'])) {
        $data['password_hash'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    updateUser($pdo, $id, $data);
    header('Location: manage-users.php');
    exit;
}
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

<div class="body flex-grow-1">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Manage Users</h1>
        <p class="lead">Kelola semua user Anda dengan mudah</p>
        
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Daftar User</strong>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
              <i class="fas fa-plus"></i> Tambah User Baru
            </button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Tanggal Registrasi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($users as $index => $user): ?>
                  <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td>
                      <span class="badge bg-<?= $user['level'] == 'admin' ? 'danger' : ($user['level'] == 'premium' ? 'warning' :($user['level'] == 'super' ? 'success' : 'info')) ?>">
                        <?= ucfirst($user['level']) ?>
                      </span>
                    </td>
                    <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-outline-primary" 
                              onclick="editUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['username']) ?>', '<?= htmlspecialchars($user['email']) ?>', '<?= $user['level'] ?>')">
                        Edit
                      </button>
                      <a href="manage-users.php?delete=<?= $user['id'] ?>" class="btn btn-sm btn-outline-danger" 
                         onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
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

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Tambah User Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <input type="hidden" name="action" value="add">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required 
                   placeholder="contoh: johndoe">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required 
                   placeholder="contoh: user@example.com">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select class="form-select" id="level" name="level">
              <option value="basic">Basic</option>
              <option value="premium">Premium</option>
              <option value="super">Super</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="">
          <input type="hidden" name="action" value="edit">
          <input type="hidden" name="id" id="edit_user_id">
          <div class="mb-3">
            <label for="edit_username" class="form-label">Username</label>
            <input type="text" class="form-control" id="edit_username" name="username" required>
          </div>
          <div class="mb-3">
            <label for="edit_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit_email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="edit_password" class="form-label">Password (kosongkan jika tidak diubah)</label>
            <input type="password" class="form-control" id="edit_password" name="password">
          </div>
          <div class="mb-3">
            <label for="edit_level" class="form-label">Level</label>
            <select class="form-select" id="edit_level" name="level">
              <option value="basic">Basic</option>
              <option value="premium">Premium</option>
              <option value="super">Super</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Update User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
// Fungsi untuk edit user
function editUser(id, username, email, level) {
    document.getElementById('edit_user_id').value = id;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_level').value = level;
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}
</script>
<?php include 'template/footer.php'; ?>
