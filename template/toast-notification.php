<?php
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['nawala_notification']) && !empty($_SESSION['nawala_notification'])) {
?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="nawalaToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-coreui-autohide="false">
    <div class="toast-header">
      <svg class="icon icon-lg me-2 text-warning">
        <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-warning"></use>
      </svg>
      <strong class="me-auto">Peringatan</strong>
      <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?php echo htmlspecialchars($_SESSION['nawala_notification']); ?>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const nawalaToastEl = document.getElementById('nawalaToast');
  if (nawalaToastEl) {
    const nawalaToast = new coreui.Toast(nawalaToastEl);
    nawalaToast.show();
  }
});
</script>
<?php
  // Hapus notifikasi dari session setelah ditampilkan agar tidak muncul terus-menerus
  unset($_SESSION['nawala_notification']);
  unset($_SESSION['nawala_count']);
}
?>
