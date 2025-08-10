<?php
$page_title = 'Manage Short Link';
$breadcrumb_title = 'Manage Short Link';
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

      <div class="body flex-grow-1">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h1>Manage Short Link</h1>
                <p class="lead">Kelola semua short link yang telah Anda buat.</p>
                
                <div class="row">
                  <div class="col-md-8">
                    <div class="card">
                      <div class="card-header">
                        <strong>Daftar Short Link</strong>
                        <a href="generate-shortlink.php" class="btn btn-primary btn-sm float-end">Buat Baru</a>
                      </div>
                      <div class="card-body">
                        <div class="table-responsive">
                          <table class="table table-hover">
                            <thead>
                              <tr>
                                <th>Short Link</th>
                                <th>URL Asli</th>
                                <th>Klik</th>
                                <th>Tanggal Buat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td><a href="#" class="text-decoration-none">projek.link/abc123</a></td>
                                <td>https://example.com/very-long-url-here</td>
                                <td>245</td>
                                <td>01 Jan 2024</td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td>
                                  <button class="btn btn-sm btn-outline-primary">Edit</button>
                                  <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </td>
                              </tr>
                              <tr>
                                <td><a href="#" class="text-decoration-none">projek.link/xyz789</a></td>
                                <td>https://another-example.com/another-long-url</td>
                                <td>89</td>
                                <td>15 Feb 2024</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>
                                  <button class="btn btn-sm btn-outline-primary">Edit</button>
                                  <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="card">
                      <div class="card-header">
                        <strong>Filter & Pencarian</strong>
                      </div>
                      <div class="card-body">
                        <form>
                          <div class="mb-3">
                            <label for="searchShortlink" class="form-label">Cari Short Link</label>
                            <input type="text" class="form-control" id="searchShortlink" placeholder="Masukkan kata kunci">
                          </div>
                          <div class="mb-3">
                            <label for="filterStatus" class="form-label">Filter Status</label>
                            <select class="form-select" id="filterStatus">
                              <option value="">Semua Status</option>
                              <option value="active">Aktif</option>
                              <option value="inactive">Non Aktif</option>
                              <option value="expired">Expired</option>
                            </select>
                          </div>
                          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php include 'template/footer.php'; ?>
