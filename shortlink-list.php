<?php
$page_title = 'Short Link List';
$breadcrumb_title = 'Short Link List';
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
                
                <div class="row">
                  <div class="col-md-8">
                    <div class="card">
                      <div class="card-header">
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
                              <tr>
                                <td>1</td>
                                <td><a href="#" class="text-decoration-none">projek.link/abc123</a></td>
                                <td>https://example.com/very-long-url-here</td>
                                <td>245</td>
                                <td>01 Jan 2024</td>
                                <td><span class="badge bg-success">Aktif</span></td>

                              </tr>
                              <tr>
                                <td>2</td>
                                <td><a href="#" class="text-decoration-none">projek.link/xyz789</a></td>
                                <td>https://another-example.com/another-long-url</td>
                                <td>89</td>
                                <td>15 Feb 2024</td>
                                <td><span class="badge bg-warning">Pending</span></td>

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
          </div>
        </div>

<?php include 'template/footer.php'; ?>
