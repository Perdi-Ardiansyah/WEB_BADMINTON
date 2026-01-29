<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Riwayat Booking</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('client/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Riwayat Booking</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Riwayat Booking</h3>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="get" action="<?= base_url('client/reservasi/history') ?>" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Filter Status</label>
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="menunggu" <?= ($_GET['status'] ?? '') == 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                                <option value="dibayar" <?= ($_GET['status'] ?? '') == 'dibayar' ? 'selected' : '' ?>>Dibayar</option>
                                <option value="selesai" <?= ($_GET['status'] ?? '') == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                                <option value="dibatalkan" <?= ($_GET['status'] ?? '') == 'dibatalkan' ? 'selected' : '' ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Filter Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="<?= $_GET['tanggal'] ?? '' ?>">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="<?= base_url('client/reservasi/history') ?>" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <?php if (empty($riwayat)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Belum ada riwayat booking.
                    </div>
                <?php else: ?>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lapangan</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($riwayat as $r): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $r['nama_lapangan'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                    <td><?= substr($r['jam_mulai'], 0, 5) ?></td>
                                    <td><?= substr($r['jam_selesai'], 0, 5) ?></td>
                                    <td>Rp <?= number_format($r['total_harga'], 0, ',', '.') ?></td>
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
                                    <td>
                                        <form method="post" action="<?= base_url('client/reservasi/history/delete/' . $r['id_riwayat']) ?>" style="display:inline;">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
