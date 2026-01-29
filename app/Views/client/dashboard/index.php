<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
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
                    <h5><i class="icon fas fa-info"></i> Selamat Datang!</h5>
                    Selamat datang di sistem booking lapangan badminton. Kelola reservasi Anda dengan mudah.
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
                    <a href="<?= base_url('client/reservasi/history') ?>" class="small-box-footer">
                        Lihat Riwayat <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= count($upcomingReservasi ?? []) ?></h3>
                        <p>Reservasi Mendatang</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="small-box-footer">&nbsp;</div>
                </div>
            </div>
        </div>

        <!-- Upcoming and Recent Reservations -->
        <div class="row">
            <!-- Upcoming Reservations -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reservasi Mendatang</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($upcomingReservasi)): ?>
                            <p class="text-muted">Tidak ada reservasi mendatang.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($upcomingReservasi as $reservasi): ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong><?= $reservasi['nama_lapangan'] ?></strong><br>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y', strtotime($reservasi['tanggal'])) ?> -
                                                    <?= substr($reservasi['jam_mulai'], 0, 5) ?> s/d <?= substr($reservasi['jam_selesai'], 0, 5) ?>
                                                </small>
                                            </div>
                                            <span class="badge badge-<?= $reservasi['status'] == 'menunggu' ? 'warning' : 'success' ?>">
                                                <?= ucfirst($reservasi['status']) ?>
                                            </span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Recent Reservations -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Reservasi Terbaru</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($recentReservasi)): ?>
                            <p class="text-muted">Belum ada reservasi.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($recentReservasi as $reservasi): ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <strong><?= $reservasi['nama_lapangan'] ?></strong><br>
                                                <small class="text-muted">
                                                    <?= date('d/m/Y', strtotime($reservasi['tanggal'])) ?> -
                                                    <?= substr($reservasi['jam_mulai'], 0, 5) ?> s/d <?= substr($reservasi['jam_selesai'], 0, 5) ?>
                                                </small>
                                            </div>
                                            <span class="badge badge-<?= $reservasi['status'] == 'menunggu' ? 'warning' : ($reservasi['status'] == 'dibayar' ? 'success' : 'info') ?>">
                                                <?= ucfirst($reservasi['status']) ?>
                                            </span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
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
                        <a href="<?= base_url('client/reservasi') ?>" class="btn btn-primary mr-2">
                            <i class="fas fa-plus"></i> Buat Reservasi Baru
                        </a>
                        <a href="<?= base_url('client/reservasi/history') ?>" class="btn btn-secondary">
                            <i class="fas fa-history"></i> Lihat Riwayat Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
