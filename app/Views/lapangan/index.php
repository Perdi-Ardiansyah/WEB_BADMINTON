<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<!-- Content Header -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Lapangan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Data Lapangan</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger ">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
    <?php endif; ?>
    <div class="card">
      <div class="card-header">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">
          <i class="fas fa-plus"></i> Tambah Lapangan
        </button>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="5%">No</th>
              <th>Nama Lapangan</th>
              <th>Jenis</th>
              <th>Harga / Jam</th>
              <th>Status</th>
              <th width="15%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($lapangan as $l): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $l['nama_lapangan'] ?></td>
                <td><?= $l['jenis'] ?></td>
                <td>Rp <?= number_format($l['harga_per_jam']) ?></td>
                <td>
                  <span class="badge badge-<?= $l['status'] == 'aktif' ? 'success' : 'danger' ?>">
                    <?= $l['status'] ?>
                  </span>
                </td>
                <td class="col-md-2 mb-2">
                  <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit<?= $l['id_lapangan'] ?>">
                    <i class="fas fa-edit"></i>
                  </button>
                  <a href="<?= base_url('lapangan/delete/' . $l['id_lapangan']) ?>" class="btn btn-danger btn-sm"
                    onclick="return confirmDelete()">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>

<!-- Modal Edit -->
<?php $no = 1;
foreach ($lapangan as $l): ?>
  <div class="modal fade" id="edit<?= $l['id_lapangan'] ?>">
    <div class="modal-dialog">
      <form action="<?= base_url('lapangan/update/' . $l['id_lapangan']) ?>" method="post" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Lapangan</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Lapangan</label>
            <input type="text" name="nama_lapangan" value="<?= $l['nama_lapangan'] ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Jenis</label>
            <input type="text" name="jenis" value="<?= $l['jenis'] ?>" class="form-control">
          </div>
          <div class="form-group">
            <label>Harga / Jam</label>
            <input type="number" name="harga_per_jam" value="<?= $l['harga_per_jam'] ?>" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="aktif" <?= $l['status'] == 'aktif' ? 'selected' : '' ?>>Aktif</option>
              <option value="nonaktif" <?= $l['status'] == 'nonaktif' ? 'selected' : '' ?>>NonAktif</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
<?php endforeach ?>
<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
  <div class="modal-dialog">
    <form action="<?= base_url('lapangan/store') ?>" method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Lapangan</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Nama Lapangan</label>
          <input type="text" name="nama_lapangan" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Jenis</label>
          <input type="text" name="jenis" class="form-control">
        </div>
        <div class="form-group">
          <label>Harga / Jam</label>
          <input type="number" name="harga_per_jam" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="aktif">Aktif</option>
            <option value="nonaktif">NonAktif</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
function confirmDelete() {
    if (confirm('Kalau anda menghapus data lapangan ini maka jadwal ikut terhapus.')) {
        return confirm('Apakah anda yakin?');
    }
    return false;
}
</script>

<?= $this->endSection() ?>
