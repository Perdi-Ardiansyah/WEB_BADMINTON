<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?= base_url('template'); ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
          alt="User Image">
      </div>

      <div class="info">
        <a href="<?= base_url('profile') ?>" class="d-block">Admin</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?= base_url('dashboard') ?>" class="nav-link">
            <i class="fas fa-home"></i>
            <p>
              dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('lapangan') ?>" class="nav-link">
            <i class="fas fa-map"></i>
            <p>
              data lapangan
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('jadwal-lapangan') ?>" class="nav-link">
            <i class="fas fa-calendar-check"></i>
            <p>
              jadwal lapangan
            </p>
          </a>
        </li>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/reservasi') ?>" class="nav-link">
            <i class="fas fa-calendar-check"></i>
            <p>Data Reservasi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/laporan/harian') ?>" class="nav-link">
            <i class="fas fa-file-alt"></i>
            <p>Laporan Harian</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/laporan/bulanan') ?>" class="nav-link">
            <i class="fas fa-chart-bar"></i>
            <p>Laporan Bulanan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('logout') ?>" class="nav-link">
            <i class="fas fa-sign-out-alt"></i>
            <p>
              logout
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<div class="content-wrapper">
  <!-- Content Wrapper. Contains page content -->