<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register | Reservasi Badminton</title>
    <link href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url(<?= base_url('template/img/bg.jpg') ?>);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mx-auto px-4">
        <div class="flex justify-center items-center min-h-screen">
            <div class="w-full max-w-md bg-white rounded-lg shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-700 to-green-800 text-white text-center py-6 relative">
                    <h4 class="text-2xl font-bold">Registrasi Reservasi Badminton</h4>
                    <p class="text-sm opacity-90">Daftar dan mulai pesan lapangan sekarang!</p>
                </div>
                <div class="p-8">
                    <!-- Error -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
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
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-green-500" required value="<?= old('nama') ?>">
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                            <input type="text" name="username" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-green-500" required value="<?= old('username') ?>">
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nomor WhatsApp</label>
                            <div class="flex">
                                <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-r-0 border-gray-300 rounded-l-md">+62</span>
                                <input type="text" name="whatsapp" class="shadow appearance-none border rounded-r w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-green-500" required value="<?= old('whatsapp') ?>" placeholder="81234567890" maxlength="15">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                            <input type="password" name="password" class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:ring-2 focus:ring-green-500" required>
                        </div>

                        <button class="bg-gradient-to-r from-green-700 to-green-800 hover:from-green-700 hover:to-green-700 text-white font-bold py-3 px-4 rounded w-full focus:outline-none focus:shadow-outline transition duration-300">Daftar Sekarang</button>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-gray-600">Sudah punya akun? <a href="/login" class="text-green-500 hover:text-green-700 font-semibold transition duration-300">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>