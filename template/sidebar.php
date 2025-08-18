<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
      <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
          <span class="badge badge-xl bg-info ms-auto">Projek Guys</span>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
      </div>
<?php
session_start();
$userLevel = $_SESSION['level'] ?? 'basic';
?>
      <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item"><a class="nav-link" href="index.php">
            <svg class="nav-icon">
              <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-speedometer"></use>
            </svg> Dashboard</a></li>
        <li class="nav-title">Nawala Domain</li>
        <li class="nav-item"><a class="nav-link" href="manage-domain.php">
            <svg class="nav-icon">
              <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-color-border"></use>
            </svg> Manage Domain</a></li>
        <li class="nav-group"><a class="nav-link nav-group" href="domain-list.php">
            <svg class="nav-icon">
              <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-notes"></use>
            </svg> Domain List</a>
        </li>
        <?php if ($userLevel == 'super' || $userLevel == 'admin'): ?>
        <li class="nav-title">Short Link</li>
        <li class="nav-group" id="short-link-menu"><a class="nav-link nav-group" href="generate-shortlink.php">
            <svg class="nav-icon">
              <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-cog"></use>
            </svg> Generate Short Link</a>
        </li>
        <li class="nav-group" id="short-link-menu"><a class="nav-link nav-group" href="manage-shortlink.php">
          <svg class="nav-icon">
          <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-color-border"></use>
            </svg> Manage Short Link</a>
        </li>
        <li class="nav-group" id="short-link-menu"><a class="nav-link nav-group" href="shortlink-list.php">
        <svg class="nav-icon">
          <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-notes"></use>
            </svg> Short Link List</a>
        </li>

        <?php endif; ?>
        <li class="nav-title">Telegram</li>
        <li class="nav-group"><a class="nav-link nav-group" href="telegram.php">
        <svg class="nav-icon">
          <use xlink:href="node_modules/@coreui/icons/sprites/brand.svg#cib-telegram"></use>
            </svg>Telegram Group Invite Link</a>
        </li>
        <?php if ($userLevel == 'admin'): ?>
        <li class="nav-title">Admin Menu</li>
          <li class="nav-group"><a class="nav-link nav-group" href="manage-users.php">
        <svg class="nav-icon">
          <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-color-border"></use>
            </svg> Manage Admin</a>
        </li>
        <?php endif; ?>
        <li class="nav-item mt-auto"><a class="nav-link" href="https://coreui.io/bootstrap/docs/templates/installation/" target="_blank">
            <svg class="nav-icon">
              <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-description"></use>
            </svg> Docs</a></li>
      </ul>
      <div class="sidebar-footer border-top d-none d-md-flex">     
        <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
      </div>
    </div>
