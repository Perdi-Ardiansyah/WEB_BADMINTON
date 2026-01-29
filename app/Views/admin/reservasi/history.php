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
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/reservasi') ?>">Kelola Data Booking</a>
                    </li>
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
                <h3 class="card-title">Daftar Riwayat Reservasi</h3>
                <div class="card-tools">
                    <a href="<?= base_url('admin/reservasi/history/print') . '?year=' . $year . '&month=' . $month ?>"
                        class="btn btn-primary btn-sm" target="_blank">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="get" action="<?= base_url('admin/reservasi/history') ?>" class="mb-3">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="year">Tahun</label>
                            <select name="year" id="year" class="form-control">
                                <?php
                                $currentYear = date('Y');
                                for ($y = $currentYear - 5; $y <= $currentYear + 1; $y++) {
                                    $selected = ($y == ($year ?? $currentYear)) ? 'selected' : '';
                                    echo "<option value=\"$y\" $selected>$y</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="month">Bulan</label>
                            <select name="month" id="month" class="form-control">
                                <?php
                                $months = [
                                    '01' => 'Januari',
                                    '02' => 'Februari',
                                    '03' => 'Maret',
                                    '04' => 'April',
                                    '05' => 'Mei',
                                    '06' => 'Juni',
                                    '07' => 'Juli',
                                    '08' => 'Agustus',
                                    '09' => 'September',
                                    '10' => 'Oktober',
                                    '11' => 'November',
                                    '12' => 'Desember'
                                ];
                                $currentMonth = date('m');
                                foreach ($months as $num => $name) {
                                    $selected = ($num == ($month ?? $currentMonth)) ? 'selected' : '';
                                    echo "<option value=\"$num\" $selected>$name</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp;</label>
                            <a href="<?= base_url('admin/reservasi/history') ?>"
                                class="btn btn-secondary btn-block">Reset</a>
                        </div>
                    </div>
                </form>
                <?php if (empty($riwayat)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Belum ada riwayat reservasi.
                    </div>
                <?php else: ?>
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

                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($riwayat as $r): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $r['nama_user'] ?></td>
                                        <td><?= $r['nama_lapangan'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                                        <td><?= substr($r['jam_mulai'], 0, 5) ?></td>
                                        <td><?= substr($r['jam_selesai'], 0, 5) ?></td>
                                        <td>Rp <?= number_format($r['total_harga'], 0, ',', '.') ?></td>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>