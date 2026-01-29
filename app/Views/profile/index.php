<?= $this->extend('templates/layout') ?>

<?= $this->section('content') ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('client/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Profile</li>
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
                    <div class="text-center mb-3">
                        <img src="<?= base_url('uploads/profile/' . ($user['foto'] ?? 'default.jpg')) ?>" class="img-circle elevation-2" alt="User Image" style="width: 100px; height: 100px;">
                    </div>
                    <div class="form-group">
                        <label>Nama:</label>
                        <p><?= $user['nama'] ?></p>
                    </div>
                    <div class="form-group">
                        <label>Username:</label>
                        <p><?= $user['username'] ?></p>
                    </div>
                    <a href="<?= base_url('profile/edit') ?>" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
