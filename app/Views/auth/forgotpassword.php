<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .glass {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.85);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-100 via-blue-100 to-white min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md p-8 rounded-2xl glass shadow-xl border border-gray-200">
        <div class="text-center mb-6">
            <div class="flex justify-center mb-4">
                <div class="bg-blue-500 text-white p-4 rounded-full shadow-lg">
                    <i class="fa-solid fa-envelope-open-text text-2xl"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Lupa Password</h1>
            <p class="text-gray-600 text-sm">Kami akan mengirimkan link reset ke email Anda</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="p-4 mb-4 flex items-center text-sm text-red-800 bg-red-100 rounded-lg">
                <i class="fa-solid fa-circle-exclamation mr-2"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php elseif(session()->getFlashdata('success')): ?>
            <div class="p-4 mb-4 flex items-center text-sm text-green-800 bg-green-100 rounded-lg">
                <i class="fa-solid fa-circle-check mr-2"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/forgot-password') ?>" method="post" class="space-y-4">
            <?= csrf_field() ?>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            </div>
            <button type="submit"
                class="w-full py-3 bg-blue-500 from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-md transform hover:scale-[1.02] transition duration-150">
                Kirim Link Reset
            </button>
        </form>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
