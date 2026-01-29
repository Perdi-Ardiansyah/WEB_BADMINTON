<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('client/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group text-center">
                            <img src="<?= base_url('uploads/profile/' . ($user['foto'] ?? 'default.jpg')) ?>"
                                class="img-circle elevation-2" alt="User Image" style="width: 100px; height: 100px;">
                            <br><br>
                            <label for="foto">Foto Profile</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control <?= (session('error') && isset(session('error')['nama'])) ? 'is-invalid' : '' ?>" id="nama" name="nama"
                                value="<?= old('nama', $user['nama']) ?>" required>
                            <?php if (session('error') && isset(session('error')['nama'])): ?>
                                <div class="invalid-feedback">
                                    <?= session('error')['nama'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control <?= (session('error') && isset(session('error')['username'])) ? 'is-invalid' : '' ?>" id="username" name="username"
                                value="<?= old('username', $user['username']) ?>" required>
                            <?php if (session('error') && isset(session('error')['username'])): ?>
                                <div class="invalid-feedback">
                                    <?= session('error')['username'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="password">Password (leave blank if not changing)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                        <a href="<?= base_url('profile') ?>" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>