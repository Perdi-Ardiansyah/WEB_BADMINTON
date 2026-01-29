<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Buat Jadwal Lapangan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Buat Jadwal Lapangan</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <div class="row pt-2">
                    <!-- Tambah Jadwal -->
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalTambah">
                            <i class="fas fa-plus-circle"></i><br>
                            Tambah Jadwal
                        </button>
                    </div>

                    <!-- Hapus Jadwal by Tanggal -->
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-warning btn-block" data-toggle="collapse" data-target="#hapusTanggal">
                            <i class="fas fa-calendar-times"></i><br>
                            Hapus Jadwal (Tanggal)
                        </button>

                        <div class="collapse mt-2" id="hapusTanggal">
                            <form action="<?= base_url('admin/jadwal-lapangan/hapus-tanggal') ?>" method="post">
                                <input type="date" name="tanggal" class="form-control mb-2" required>
                                <button class="btn btn-warning btn-block"
                                    onclick="return confirm('Hapus semua jadwal di tanggal ini?')">
                                    Konfirmasi Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Hapus Semua Jadwal -->
                    <div class="col-md-3 mb-2">
                        <form action="<?= base_url('admin/jadwal-lapangan/hapus-semua') ?>" method="post">
                            <button class="btn btn-danger btn-block" onclick="return confirm('Hapus semua jadwal?')">
                                <i class="fas fa-trash-alt"></i><br>
                                Hapus Semua Jadwal
                            </button>
                        </form>
                    </div>
                    <!-- Generate Semua Lapangan -->
                    <div class="col-md-3 mb-2">
                        <button class="btn btn-success btn-block" data-toggle="collapse" data-target="#generateTanggal">
                            <i class="fas fa-calendar-plus"></i><br>
                            Generate Semua Lapangan
                        </button>

                        <div class="collapse mt-2" id="generateTanggal">
                            <form action="<?= base_url('admin/jadwal-lapangan/generate-semua') ?>" method="post">
                                <input type="date" name="tanggal" class="form-control mb-2" required>
                                <button class="btn btn-success btn-block">
                                    Konfirmasi Generate
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <form method="get" action="<?= base_url('admin/jadwal-lapangan') ?>" class="mb-3">
                    <div class="card-body p-2">
                        <div class="row no-gutters align-items-center">
                            <!-- Filter Lapangan -->
                            <div class="col-md-3 mb-2 pr-1">
                                <select name="lapangan" class="form-control form-control-sm">
                                    <option value="">Semua Lapangan</option>
                                    <?php foreach ($lapangan as $l): ?>
                                        <option value="<?= $l['id_lapangan'] ?>" <?= ($l['id_lapangan'] == ($_GET['lapangan'] ?? '')) ? 'selected' : '' ?>>
                                            <?= $l['nama_lapangan'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <!-- Filter Tanggal -->
                            <div class="col-md-3 mb-2 pr-1">
                                <input type="date" name="tanggal" class="form-control form-control-sm"
                                    value="<?= $_GET['tanggal'] ?? '' ?>">
                            </div>

                            <!-- Filter Jam -->
                            <div class="col-md-2 mb-2 pr-1">
                                <select name="jam" class="form-control form-control-sm">
                                    <option value="">Semua Jam</option>
                                    <?php for ($j = 8; $j < 22; $j++):
                                        $jam = sprintf('%02d:00:00', $j); ?>
                                        <option value="<?= $jam ?>" <?= ($jam == ($_GET['jam'] ?? '')) ? 'selected' : '' ?>>
                                            <?= substr($jam, 0, 5) ?>
                                        </option>
                                    <?php endfor ?>
                                </select>
                            </div>

                            <!-- Tombol Filter -->
                            <div class="col-md-2 mb-2 pr-1">
                                <button class="btn btn-primary btn-sm btn-block">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>

                            <!-- Tombol Reset -->
                            <div class="col-md-2 mb-2 pr-1">
                                <a href="<?= base_url('admin/jadwal-lapangan') ?>"
                                    class="btn btn-secondary btn-sm btn-block">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>

                        </div>

                    </div>
                </form>
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session('error') ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('warning')): ?>
                    <div class="alert alert-warning">
                        <?= session('warning') ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= session('success') ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($jadwal as $j): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $j['nama_lapangan'] ?></td>
                                <td><?= $j['tanggal'] ?></td>
                                <td><?= $j['jam_mulai'] ?> - <?= $j['jam_selesai'] ?></td>
                                <td class="text-center">
                                    <?php
                                    $status = $j['reservasi_status'] ?? $j['status'];
                                    if ($status == 'tersedia' || $status == 'dibatalkan'): ?>
                                        <span class="badge badge-success">Tersedia</span>
                                    <?php elseif ($status == 'menunggu'): ?>
                                        <span class="badge badge-warning">Menunggu</span>
                                    <?php elseif ($status == 'dibooking' || $status == 'dibayar'): ?>
                                        <span class="badge badge-info">Dibayar</span>
                                    <?php elseif ($status == 'selesai'): ?>
                                        <span class="badge badge-secondary">Selesai</span>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <form method="post"
                                        action="<?= base_url('admin/jadwal-lapangan/delete/' . $j['id_jadwal']) ?>"
                                        class="d-inline">
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus jadwal?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/jadwal-lapangan/store') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Lapangan</label>
                        <select name="id_lapangan" class="form-control" required>
                            <?php foreach ($lapangan as $l): ?>
                                <option value="<?= $l['id_lapangan'] ?>"><?= $l['nama_lapangan'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>