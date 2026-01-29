<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>



<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0">Laporan Bulanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Laporan Bulanan</li>
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
                <select name="bulan" class="form-control mr-2">
                    <?php for ($b = 1; $b <= 12; $b++): ?>
                        <option value="<?= $b ?>" <?= $b == $bulan ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $b, 1)) ?>
                        </option>
                    <?php endfor ?>
                </select>

                <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control mr-2">
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
                        <th>Tanggal</th>
                        <th>Total Reservasi</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporan as $l): ?>
                        <tr>
                            <td><?= $l['tanggal'] ?></td>
                            <td class="text-center"><?= $l['total_reservasi'] ?></td>
                            <td class="text-right">
                                Rp <?= number_format($l['pendapatan'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr class="font-weight-bold bg-light">
                        <td colspan="2" class="text-center">Total Bulanan</td>
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