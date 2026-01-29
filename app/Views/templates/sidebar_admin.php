<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <a href="<?= base_url('admin/profile') ?>">
          <img src="<?= base_url('uploads/profile/' . (session('foto') ?? 'default.jpg')) ?>" class="img-circle elevation-2"
            alt="User Image">
        </a>
      </div>

      <div class="info">
        <a href="<?= base_url('admin/profile') ?>" class="d-block"><?= session('nama') ?? 'Admin' ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
            <i class="fas fa-tachometer-alt"></i>
            <p>
              dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('lapangan') ?>" class="nav-link">
            <i class="fas fa-table-tennis"></i>
            <p>
              data lapangan
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/jadwal-lapangan') ?>" class="nav-link">
            <i class="fas fa-calendar-alt"></i>
            <p>
              jadwal lapangan
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/pengguna') ?>" class="nav-link">
            <i class="fas fa-users"></i>
            <p>
              data pengguna
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-calendar-plus"></i>
            <p>
              Reservasi
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/reservasi') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelola Data Reservasi</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/reservasi/history') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Riwayat Reservasi</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="<?= base_url('admin/laporan/harian') ?>" class="nav-link">
            <i class="fas fa-file-invoice-dollar"></i>
            <p>Laporan Harian</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?= base_url('admin/laporan/bulanan') ?>" class="nav-link">
            <i class="fas fa-chart-line"></i>
            <p>Laporan Bulanan</p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-user-cog"></i>
            <p>
              Profile
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?= base_url('admin/profile') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>View Profile</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?= base_url('admin/profile/edit') ?>" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Edit Profile</p>
              </a>
            </li>
          </ul>
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