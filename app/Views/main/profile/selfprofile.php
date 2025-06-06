<?php
    $user = [
        'username' => 'alice123',
        'full_name' => 'Alice Liddell',
        'city' => 'Jakarta',
        'province' => 'DKI Jakarta',
        'friend_count' => 42,
        'book_count' => 17,
        'photo_url' => 'https://i.pravatar.cc/200?u=alice123',
        'biodata' => "Penggembar buku klasik"
    ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main class="px-4 py-10" id="mainContent">
        <div class="max-w-lg mx-auto relative">
            <!-- Settings Icon -->
            <div class="absolute top-5 right-5">
                <a href="<?= base_url('/settings') ?>" class="text-gray-600 hover:text-gray-800 text-2xl">
                    <i class="fa-solid fa-gear"></i>
                </a>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex flex-col items-center gap-6">
                    <!-- Profile Photo -->
                    <div class="w-32 h-32">
                        <img src="<?= htmlspecialchars($user['photo_url']) ?>" alt="Foto Profil"
                             class="rounded-full w-full h-full object-cover border-4 border-gray-300">
                    </div>

                    <!-- Username & Name -->
                    <div class="text-center">
                        <h2 class="text-2xl font-bold">@<?= htmlspecialchars($user['username']) ?></h2>
                        <p class="text-lg text-gray-700 font-semibold"><?= htmlspecialchars($user['full_name']) ?></p>
                    </div>

                    <!-- Stats -->
                    <div class="flex gap-10 text-center text-gray-700">
                        <div>
                            <span class="block text-xl font-bold"><?= $user['friend_count'] ?></span>
                            <span class="text-sm">Teman</span>
                        </div>
                        <div>
                            <span class="block text-xl font-bold"><?= $user['book_count'] ?></span>
                            <span class="text-sm">Buku</span>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="text-gray-600">
                        <i class="fa-solid fa-location-dot mr-1 text-red-500"></i>
                        <?= htmlspecialchars($user['city']) ?>, <?= htmlspecialchars($user['province']) ?>
                    </div>

                    <div class="mt-6 text-gray-800">
                        <p class="text-sm text-gray-700">
                            <?= !empty($user['biodata']) ? htmlspecialchars($user['biodata']) : 'Belum ada biodata yang ditambahkan.' ?>
                        </p>
                    </div>

                    <div class="mt-6 flex justify-center gap-6">
                        <a href="<?= base_url('/users/' . $user['username'] . '/books') ?>"
                        class="flex items-center gap-2 px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700 transition">
                            <i class="fa-solid fa-book"></i> Koleksi Buku
                        </a>
                        <a href="<?= base_url('/users/' . $user['username'] . '/discussions') ?>"
                        class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                            <i class="fa-solid fa-comments"></i> Diskusi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>
