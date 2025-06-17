<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .glass {
            backdrop-filter: blur(8px);
            background-color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 min-h-screen flex items-center justify-center">

    <div class="glass-effect w-full max-w-md p-8 rounded-2xl glass shadow-xl border border-gray-200">
        <div class="text-center mb-6">
            <div class="flex justify-center mb-4">
                <div class="bg-blue-500 from-blue-500 to-purple-600 text-white p-4 rounded-full shadow-lg">
                    <i class="fa-solid fa-key text-2xl"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-1">Atur Ulang Password</h1>
            <p class="text-gray-600 text-sm">Masukkan password baru untuk akunmu</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/reset-password') ?>" method="post" class="space-y-4">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>">

            <div>
                <label for="password" class="block mb-1 text-sm font-semibold text-gray-700">Password Baru</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-3 pr-3 flex items-center text-gray-500">
                        <i id="eyeIcon" class="fa-solid fa-eye"></i>
                    </button>
                </div>
                
                <div class="mt-2">
                    <div class="password-strength bg-gray-200" id="passwordStrength"></div>
                    <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter berupa kombinasi huruf, angka, dan simbol</p>
                </div>
            </div>

            <div>
                <label for="confirmPassword" class="block mb-1 text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" id="confirmPassword" name="confirmPassword" required
                        class="w-full px-4 py-3 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:outline-none transition">
                    <button type="button" id="toggleConfirm" class="absolute inset-y-0 right-3 pr-3 flex items-center text-gray-500">
                        <i id="eyeIconConfirm" class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <div id="passwordMatch" class="text-xs mt-1 hidden">
                    <span class="text-red-500">
                        <i class="fas fa-times-circle mr-1"></i>
                        Password tidak cocok
                    </span>
                </div>
            </div>

            <button type="submit"
                class="w-full py-3 bg-blue-500 from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-md transform hover:scale-[1.02] transition duration-150">
                Simpan Password Baru
            </button>
        </form>
    </div>

    <script src="<?= base_url('assets/js/passStrength.js') ?>"></script>
    <script src="<?= base_url('assets/js/showPass.js') ?>"></script>

    <script src="<?= base_url('flowbite.min.js') ?>"></script>
</body>
</html>
