<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include __DIR__ . '/../layout/layout.php'; ?>

    <main class="px-4 py-10" id="mainContent">
        <div class="max-w-lg mx-auto relative">
            <div class="absolute top-5 right-5">
                <a href="<?= base_url('profile/edit') ?>" class="text-gray-600 hover:text-gray-800 text-2xl">
                    <i class="fa-solid fa-gear"></i>
                </a>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex flex-col items-center gap-6">
                    <div class="w-32 h-32">
                        <img src="<?= base_url('uploads/' . $photoProfile) ?>" alt="Foto Profil"
                             class="rounded-full w-full h-full object-cover border-4 border-gray-300">
                    </div>

                    <div class="text-center">
                        <h2 class="text-2xl font-bold">@<?= esc($username) ?></h2>
                        <p class="text-lg text-gray-700 font-semibold"><?= esc($fullname) ?></p>
                    </div>

                    <div class="flex gap-10 text-center text-gray-700">
                        <div>
                            <span class="block text-xl font-bold"><?= esc($friendCount) ?></span>
                            <span class="text-sm">Teman</span>
                        </div>
                        <div>
                            <span class="block text-xl font-bold"><?= esc($bookCount) ?></span>
                            <span class="text-sm">Buku</span>
                        </div>
                    </div>

                    <div class="text-gray-600">
                        <i class="fa-solid fa-location-dot mr-1 text-red-500"></i>
                        <?= esc($city) ?>, <?= esc($province) ?>
                    </div>

                    <div class="mt-6 text-gray-800">
                        <p class="text-sm text-gray-700">
                            <?= !empty($description) ? esc($description) : 'Belum ada biodata yang ditambahkan.' ?>
                        </p>
                    </div>

                    <div class="mt-6 flex justify-center gap-6">
                        <a href="<?= base_url('/library/') ?>"
                        class="flex items-center gap-2 px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700 transition">
                            <i class="fa-solid fa-book"></i> Koleksi Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
