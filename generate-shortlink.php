<?php
$page_title = 'Generate Short Link';
$breadcrumb_title = 'Generate Short Link';
?>
<?php include 'template/header.php'; ?>
<?php include 'template/sidebar.php'; ?>
<?php include 'template/navbar.php'; ?>

      <div class="body flex-grow-1">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <h1>Generate Short Link</h1>
                <p class="lead">Buat short link untuk URL panjang Anda.</p>
                
                <div class="row">
                  <div class="col-md-8">
                    <div class="card">
                      <div class="card-header">
                        <strong>Buat Short Link Baru</strong>
                      </div>
                      <div class="card-body">
                        <form>
                          <div class="mb-3">
                            <label for="longUrl" class="form-label">URL Panjang</label>
                            <input type="url" class="form-control" id="longUrl" placeholder="https://example.com/very-long-url-here" required>
                          </div>
                          <div class="mb-3">
                            <label for="customSlug" class="form-label">Custom Slug (Opsional)</label>
                            <input type="text" class="form-control" id="customSlug" placeholder="my-custom-link">
                            <small class="text-muted">Jika dikosongkan, akan dibuatkan otomatis</small>
                          </div>
                          <button type="submit" class="btn btn-primary">Generate Short Link</button>
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
                        <p>Total Short Link: <strong>13</strong></p>
                        <p>Total Klik: <strong>1,245</strong></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php include 'template/footer.php'; ?>
