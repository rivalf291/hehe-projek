<?php
$page_title = 'Manage Domain';
$breadcrumb_title = 'Manage Domain';
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

      <div class="body flex-grow-1">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h1>Manage Domain</h1>
                <p class="lead">Kelola domain anda di sini.</p>
                
                <div class="card">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Kelola Domain</strong>
                    <a href="manage-domain.php" class="btn btn-primary btn-sm">Tambah Domain</a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Domain</th>
                            <th>Status</th>
                            <th>Tanggal Registrasi</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td>example.com</td>
                            <td><span class="badge bg-success">Aman</span></td>
                            <td>01 Jan 2024</td>
                            <td>
                              <button class="btn btn-sm btn-outline-primary">Detail</button>
                              <button class="btn btn-sm btn-outline-warning">Edit</button>
                            </td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td>test.net</td>
                            <td><span class="badge bg-danger">Nawala</span></td>
                            <td>15 Feb 2024</td>
                            <td>
                              <button class="btn btn-sm btn-outline-primary">Detail</button>
                              <button class="btn btn-sm btn-outline-warning">Edit</button>
                            </td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td>demo.org</td>
                            <td><span class="badge bg-success">Aman</span></td>
                            <td>10 Mar 2024</td>
                            <td>
                              <button class="btn btn-sm btn-outline-primary">Detail</button>
                              <button class="btn btn-sm btn-outline-warning">Edit</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php include 'template/footer.php'; ?>
