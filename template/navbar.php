<header class="header header-sticky p-0 mb-4">
  <div class="container-fluid border-bottom px-4">
    <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
      <svg class="icon icon-lg">
        <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-menu"></use>
      </svg>
    </button>
    <ul class="header-nav ms-auto">

      <?php if (isset($_SESSION['nawala_notification']) && !empty($_SESSION['nawala_notification'])): ?>
        <li class="nav-item dropdown">
          <a class="nav-link" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <svg class="icon icon-lg">
              <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-bell"></use>
            </svg>
            <?php if (isset($_SESSION['nawala_count']) && $_SESSION['nawala_count'] > 0): ?>
              <span class="badge rounded-pill position-absolute top-0 end-0 bg-danger text-white"><?= $_SESSION['nawala_count'] ?></span>
            <?php endif; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-end pt-0" style="min-width: 20rem; max-width: 25rem;">
            <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">Notifikasi Nawala</div>
            <a class="dropdown-item" href="manage-domain.php">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <svg class="icon icon-lg text-warning">
                    <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-warning"></use>
                  </svg>
                </div>
                <div class="flex-grow-1">
                  <p class="mb-0 small text-wrap"><?= htmlspecialchars($_SESSION['nawala_notification']) ?></p>
                </div>
              </div>
            </a>
          </div>
        </li>
      <?php endif; ?>

      <li class="nav-item py-1">
        <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
      </li>
      <li class="nav-item dropdown">
        <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button" aria-expanded="false" data-coreui-toggle="dropdown">
          <svg class="icon icon-lg theme-icon-active">
            <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-contrast"></use>
          </svg>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
          <li>
            <button class="dropdown-item d-flex align-items-center" type="button" data-coreui-theme-value="light">
              <svg class="icon icon-lg me-3">
                <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-sun"></use>
              </svg>Light
            </button>
          </li>
          <li>
            <button class="dropdown-item d-flex align-items-center" type="button" data-coreui-theme-value="dark">
              <svg class="icon icon-lg me-3">
                <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-moon"></use>
              </svg>Dark
            </button>
          </li>
          <li>
            <button class="dropdown-item d-flex align-items-center active" type="button" data-coreui-theme-value="auto">
              <svg class="icon icon-lg me-3">
                <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-contrast"></use>
              </svg>Auto
            </button>
          </li>
        </ul>
      </li>
      <li class="nav-item py-1">
        <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-md"><img class="avatar-img" src="assets/img/avatars/8.jpg" alt="user@email.com"></div>
        </a>
        <div class="dropdown-menu dropdown-menu-end pt-0">
          <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">Account</div>
          <a class="dropdown-item" href="logout.php">
            <svg class="icon me-2">
              <use xlink:href="../node_modules/@coreui/icons/sprites/free.svg#cil-account-logout"></use>
            </svg> Logout</a>
        </div>
      </li>
    </ul>
  </div>
</header>