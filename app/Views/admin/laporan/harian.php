<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Harian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Laporan Harian</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">

                <form method="get" class="form-inline mb-3">
                    <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control mr-2">
                    <button class="btn btn-primary btn-sm">Filter</button>
                </form>

                <div class="alert alert-success">
                    <strong>Total Pendapatan:</strong>
                    Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
                </div>
                <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Lapangan</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $r): ?>
                            <tr>
                                <td><?= esc($r['nama_user']) ?></td>
                                <td><?= esc($r['nama_lapangan']) ?></td>
                                <td><?= substr($r['jam_mulai'], 0, 5) ?> - <?= substr($r['jam_selesai'], 0, 5) ?></td>
                                <td><?= ucfirst($r['status']) ?></td>
                                <td class="text-right">
                                    Rp <?= number_format($r['total_harga'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold bg-light">
                            <td colspan="4" class="text-center">Total Hari Ini</td>
                            <td colspan="1" class="text-right">
                                Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>