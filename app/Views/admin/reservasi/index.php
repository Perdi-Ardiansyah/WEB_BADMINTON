<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0">Kelola Data Reservasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Reservasi</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <form method="get" class="form-inline">
                    <div class="form-group mb-2">
                        <label for="tanggal" class="mr-2">Filter Tanggal:</label>
                        <input type="date" name="tanggal" id="tanggal" value="<?= $tanggal ?>"
                            class="form-control mr-2">
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" class="btn btn-primary mb-2">Filter</button>
                        <a href="<?= base_url('admin/reservasi') ?>" class="btn btn-secondary mb-2 ml-2">Reset</a>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Harga</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;
                        foreach ($reservasi as $r): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($r['username']) ?></td>
                                <td><?= esc($r['nama_lapangan']) ?></td>
                                <td><?= esc($r['tanggal']) ?></td>
                                <td class="text-center">
                                    <?= substr($r['jam_mulai'], 0, 5) ?>
                                    -
                                    <?= substr($r['jam_selesai'], 0, 5) ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    $badge = match ($r['status']) {
                                        'menunggu' => 'warning',
                                        'dibayar' => 'success',
                                        'selesai' => 'primary',
                                        'dibatalkan' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge badge-<?= $badge ?>">
                                        <?= ucfirst($r['status']) ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($r['total_harga'] ?? 0, 0, ',', '.') ?></td>

                                <td class="text-center">
                                    <?php if ($r['status'] == 'menunggu'): ?>
                                        <a href="<?= base_url('admin/reservasi/status/' . $r['id_reservasi'] . '/dibayar') ?>"
                                            class="btn btn-success btn-sm mb-1">
                                            <i class="fas fa-check"></i> Dibayar
                                        </a>

                                        <a href="<?= base_url('admin/reservasi/status/' . $r['id_reservasi'] . '/dibatalkan') ?>"
                                            class="btn btn-danger btn-sm mb-1"
                                            onclick="return confirm('Batalkan reservasi ini?')">
                                            <i class="fas fa-times"></i> Batalkan
                                        </a>

                                    <?php elseif ($r['status'] == 'dibayar'): ?>
                                        <a href="<?= base_url('admin/reservasi/status/' . $r['id_reservasi'] . '/selesai') ?>"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-flag-checkered"></i> Selesai
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
            aria-labelledby="custom-tabs-one-profile-tab">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Nama Lapangan</th>
                            <th>Tanggal</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Riwayat data will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</section>

<?= $this->endSection() ?>