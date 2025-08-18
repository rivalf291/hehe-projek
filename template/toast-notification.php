<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <img src="..." class="rounded me-2" alt="...">

    <strong class="me-auto">CoreUI for Bootstrap</strong>
    <small>11 mins ago</small>
    <button type="button" class="btn-close" data-coreui-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
    Hello, world! This is a toast message.
  </div>
</div>

<script>
  // Function to show toast notification for Nawala domains
  function showToast(domain) {
    const toastBody = document.querySelector('.toast-body');
    toastBody.textContent = `Domain ${domain} status is Nawala!`;
    const toast = new bootstrap.Toast(document.getElementById('liveToast'));
    toast.show();
  }
</script>
