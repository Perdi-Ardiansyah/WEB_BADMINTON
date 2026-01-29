<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard Admin</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <!-- Welcome Message -->
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">
                    <h5><i class="icon fas fa-info"></i> Selamat Datang, Admin!</h5>
                    Kelola sistem booking lapangan badminton dengan mudah melalui dashboard ini.
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $totalReservasi ?? 0 ?></h3>
                        <p>Total Reservasi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <a href="<?= base_url('admin/reservasi') ?>" class="small-box-footer">
                        Kelola Reservasi <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= $pendingReservasi ?? 0 ?></h3>
                        <p>Menunggu Konfirmasi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <a href="<?= base_url('admin/reservasi') ?>" class="small-box-footer">
                        Proses Sekarang <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rp <?= number_format($totalRevenue ?? 0, 0, ',', '.') ?></h3>
                        <p>Total Pendapatan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <a href="<?= base_url('admin/laporan/harian') ?>" class="small-box-footer">
                        Lihat Laporan <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= $totalUsers ?? 0 ?></h3>
                        <p>Total Pengguna</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="small-box-footer">&nbsp;</div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?= $paidReservasi ?? 0 ?></h3>
                        <p>Sudah Dibayar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="small-box-footer">&nbsp;</div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-dark">
                    <div class="inner">
                        <h3><?= $completedReservasi ?? 0 ?></h3>
                        <p>Selesai</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <div class="small-box-footer">&nbsp;</div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3 style="color: #333;"><?= $totalLapangan ?? 0 ?></h3>
                        <p>Total Lapangan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-map-marker-alt" style="color: #333;"></i>
                    </div>
                    <a href="<?= base_url('/lapangan') ?>" class="small-box-footer" style="color: #333;">
                        Kelola Lapangan <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Reservations -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reservasi Terbaru</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recentReservasi)): ?>
                            <p class="text-muted">Belum ada reservasi.</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Pengguna</th>
                                            <th>Lapangan</th>
                                            <th>Tanggal</th>
                                            <th>Jam</th>
                                            <th>Status</th>
                                            <th>Harga</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($recentReservasi as $r): ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $r['username'] ?></td>
                                                <td><?= $r['nama_lapangan'] ?></td>
                                                <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                                <td><?= substr($r['jam_mulai'], 0, 5) ?> - <?= substr($r['jam_selesai'], 0, 5) ?></td>
                                                <td>
                                                    <?php
                                                    $statusClass = '';
                                                    $statusText = '';
                                                    switch ($r['status']) {
                                                        case 'menunggu':
                                                            $statusClass = 'badge-warning';
                                                            $statusText = 'Menunggu';
                                                            break;
                                                        case 'dibayar':
                                                            $statusClass = 'badge-success';
                                                            $statusText = 'Dibayar';
                                                            break;
                                                        case 'selesai':
                                                            $statusClass = 'badge-info';
                                                            $statusText = 'Selesai';
                                                            break;
                                                        case 'dibatalkan':
                                                            $statusClass = 'badge-danger';
                                                            $statusText = 'Dibatalkan';
                                                            break;
                                                        default:
                                                            $statusClass = 'badge-secondary';
                                                            $statusText = $r['status'];
                                                    }
                                                    ?>
                                                    <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                                </td>
                                                <td>Rp <?= number_format($r['total_harga'] ?? 0, 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aksi Cepat</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="<?= base_url('admin/reservasi') ?>" class="btn btn-primary btn-block">
                                    <i class="fas fa-calendar-check"></i> Kelola Reservasi
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="<?= base_url('admin/jadwal-lapangan') ?>" class="btn btn-secondary btn-block">
                                    <i class="fas fa-clock"></i> Jadwal Lapangan
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="<?= base_url('admin/laporan/harian') ?>" class="btn btn-info btn-block">
                                    <i class="fas fa-chart-bar"></i> Laporan Harian
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="<?= base_url('/lapangan') ?>" class="btn btn-warning btn-block">
                                    <i class="fas fa-map-marker-alt"></i> Kelola Lapangan
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="<?= base_url('admin/pengguna') ?>" class="btn btn-success btn-block">
                                    <i class="fas fa-users"></i> Kelola Pengguna
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="<?= base_url('admin/laporan/bulanan') ?>" class="btn btn-dark btn-block">
                                    <i class="fas fa-chart-line"></i> Laporan Bulanan
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="<?= base_url('admin/profile') ?>" class="btn btn-light btn-block text-dark">
                                    <i class="fas fa-user"></i> Profil
                                </a>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-2">
                                <a href="<?= base_url('admin/reservasi/history') ?>" class="btn btn-danger btn-block">
                                    <i class="fas fa-history"></i> Riwayat Reservasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
