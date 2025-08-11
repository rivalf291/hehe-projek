<!-- Modal Edit Domain -->
<div class="modal fade" id="editDomainModal" tabindex="-1" aria-labelledby="editDomainModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDomainModalLabel">Edit Domain</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="manage-domain.php" id="editDomainForm">
          <input type="hidden" name="action" value="edit">
          <input type="hidden" name="id" id="edit_id">
          
          <div class="mb-3">
            <label for="edit_domain_name" class="form-label">Nama Domain</label>
            <input type="text" class="form-control" id="edit_domain_name" name="domain_name" required>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Domain -->
<div class="modal fade" id="addDomainModal" tabindex="-1" aria-labelledby="addDomainModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDomainModalLabel">Tambah Domain Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="manage-domain.php" id="addDomainForm">
          <input type="hidden" name="action" value="add">
          
          <div class="mb-3">
            <label for="add_domain_name" class="form-label">Nama Domain</label>
            <input type="text" class="form-control" id="add_domain_name" name="domain_name" required>
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

<script>
// Fungsi untuk membuka modal edit
function editDomain(id, domainName, status, expiryDate) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_domain_name').value = domainName;
    new bootstrap.Modal(document.getElementById('editDomainModal')).show();
}

// Fungsi untuk membuka modal tambah
function addDomain() {
    new bootstrap.Modal(document.getElementById('addDomainModal')).show();
}
</script>
