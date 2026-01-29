<!DOCTYPE html>
<html>

<head>
    <title>Register | Reservasi Badminton</title>
    <link href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Registrasi</h4>
                    </div>
                    <div class="card-body">
                        <!-- Error -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?php
                                $errors = session()->getFlashdata('error');
                                if (is_array($errors)) {
                                    foreach ($errors as $err) {
                                        echo "<div>$err</div>";
                                    }
                                } else {
                                    echo $errors;
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        <form action="/register" method="post">
                            <div class="mb-3">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required value="<?= old('nama') ?>">
                            </div>

                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required
                                    value="<?= old('username') ?>">
                            </div>

                            <div class="mb-3">
                                <label>Nomor WhatsApp</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+62</span>
                                    </div>
                                    <input type="text" name="whatsapp" class="form-control" required
                                        value="<?= old('whatsapp') ?>" placeholder="81234567890" maxlength="15">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button class="btn btn-primary w-100">Register</button>
                        </form>

                        <div class="text-center mt-3">
                            <label for="">Sudah punya akun? <a href="/login" class="text-decoration-none">Login
                                </a></label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>