<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>


<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Boking Lapangan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('client/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Boking Lapangan</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card p-2">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <!-- FILTER -->
            <form method="get" class="row mb-4">
                <div class="col-md-3">
                    <label>Pilih Tanggal</label>
                    <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Filter Lapangan</label>
                    <select name="lapangan" class="form-control">
                        <option value="">Semua Lapangan</option>
                        <?php foreach ($lapangan as $l): ?>
                            <option value="<?= $l['id_lapangan'] ?>">
                                <?= $l['nama_lapangan'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-2 align-self-end mt-2">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
        <!-- SLOT WAKTU -->
        <?php
        $groupJam = [];
        foreach ($jadwal as $j) {
            $groupJam[$j['jam_mulai']][] = $j;
        }
        ?>

        <?php foreach ($groupJam as $jam => $items): ?>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="far fa-clock"></i> <?= substr($jam, 0, 5) ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($items as $j): ?>
                            <div class="col-md-3">
                                <div class="border rounded p-3 mb-2
                                <?= $j['status'] === 'dibooking' ? 'bg-light' : '' ?>">

                                    <strong><?= $j['nama_lapangan'] ?></strong><br>
                                    <small><?= substr($j['jam_mulai'], 0, 5) ?> - <?= substr($j['jam_selesai'], 0, 5) ?></small>

                                    <?php if ($j['status'] === 'tersedia'): ?>
                                        <form action="<?= base_url('client/reservasi/store') ?>" method="post">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_jadwal" value="<?= $j['id_jadwal'] ?>">
                                            <button class="btn btn-success btn-sm btn-block mt-2">
                                                Pesan
                                            </button>
                                        </form>

                                    <?php elseif ($j['status'] == 'dibooking'): ?>
                                        <span class="badge badge-warning">Dibooking</span>

                                    <?php else: ?>
                                        <span class="badge badge-secondary">Selesai</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>
</section>
<?= $this->endSection() ?>