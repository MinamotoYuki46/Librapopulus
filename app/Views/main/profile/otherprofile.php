<?php
    // $user = [
    //     'username' => 'alice123',
    //     'full_name' => 'Alice Liddell',
    //     'city' => 'Jakarta',
    //     'province' => 'DKI Jakarta',
    //     'friend_count' => 42,
    //     'book_count' => 17,
    //     'photo_url' => 'https://i.pravatar.cc/200?u=alice123',
    //     'biodata' => "Penggembar buku klasik"
    // ];

    // Simulasi status pertemanan antara user login dan profil yang dilihat
    // Status bisa: 'none' (bukan teman, belum ada request), 
    //              'requested' (kita sudah kirim permintaan),
    //              'pending' (kita menerima permintaan),
    //              'friends' (sudah teman)
    // $friendship_status = 'none'; // Ganti sesuai logika backend Anda
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="bg-gray-100 text-gray-900">
    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main class="px-4 py-10" id="mainContent">
        <div class="max-w-lg mx-auto relative">

            <!-- Profile Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex flex-col items-center gap-6">
                    <!-- Profile Photo -->
                    <div class="w-32 h-32">
                        <img src="<?= esc(Base_url('uploads/' . $otherPhotoProfile)) ?>" alt="Foto Profil"
                             class="rounded-full w-full h-full object-cover border-4 border-gray-300" />
                    </div>

                    <!-- Username & Name -->
                    <div class="text-center">
                        <h2 class="text-2xl font-bold">@<?= esc($username) ?></h2>
                        <p class="text-lg text-gray-700 font-semibold"><?= esc($fullname) ?></p>
                    </div>

                    <!-- Stats -->
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

                    <!-- Location -->
                    <div class="text-gray-600">
                        <i class="fa-solid fa-location-dot mr-1 text-red-500"></i>
                        <?= esc($city) ?>, <?= esc($province) ?>
                    </div>

                    <!-- Biodata -->
                    <div class="mt-6 text-gray-800">
                        <p class="text-sm text-gray-700">
                            <?= !empty($description) ? esc($description) : 'Belum ada biodata yang ditambahkan.' ?>
                        </p>
                    </div>

                    <!-- Tombol pengajuan pertemanan -->
                    <?php $status = ($friendship === null) ? \App\Models\FriendshipModel::STATUS_NONE : $friendship['status'];?>
                    <div class="mt-6 flex justify-center gap-4">
                        <?php if ($status == \App\Models\FriendshipModel::STATUS_NONE || $status ==  \App\Models\FriendshipModel::STATUS_DECLINED) : ?>
                            <form method="POST" action="<?= base_url('/friends/request/' . $username) ?>">
                                <button type="submit"
                                    class="px-5 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700 transition font-semibold">
                                    <i class="fa-solid fa-user-plus mr-2"></i> Tambah Teman
                                </button>
                            </form>

                        <?php elseif ($status == \App\Models\FriendshipModel::STATUS_PENDING && $friendship['user_one_id'] == $myId) : ?>
                            <form method="POST" action="<?= base_url('/friends/cancel/' . $username) ?>">
                                <button type="submit"
                                    class="px-5 py-2 bg-gray-400 text-gray-800 rounded-md hover:bg-gray-500 transition font-semibold">
                                    <i class="fa-solid fa-xmark mr-2"></i> Batalkan Permintaan
                                </button>
                            </form>

                        <?php elseif ($status == \App\Models\FriendshipModel::STATUS_PENDING && $friendship['user_one_id'] == $targetId) : ?>
                            <form method="POST" action="<?= base_url('/friends/accept/' . $username) ?>" class="inline-block">
                                <button type="submit"
                                    class="px-5 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-semibold">
                                    <i class="fa-solid fa-check mr-2"></i> Terima
                                </button>
                            </form>

                            <form method="POST" action="<?= base_url('/friends/decline/' . $username) ?>" class="inline-block ml-3">
                                <button type="submit"
                                    class="px-5 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition font-semibold">
                                    <i class="fa-solid fa-ban mr-2"></i> Tolak
                                </button>
                            </form>

                        <?php elseif ($status == \App\Models\FriendshipModel::STATUS_ACCEPTED) : ?>
                            <button disabled
                                class="px-5 py-2 bg-gray-300 text-gray-600 rounded-md cursor-default font-semibold">
                                <i class="fa-solid fa-user-check mr-2"></i> Teman
                            </button>
                        <?php endif; ?>
                    </div>

                    <!-- Tombol Koleksi Buku & Diskusi -->
                    <div class="mt-6 flex justify-center gap-6">
                        <a href="<?= base_url('/users/' . $username . '/books') ?>"
                        class="flex items-center gap-2 px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700 transition">
                            <i class="fa-solid fa-book"></i> Koleksi Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/../layout/navbar.php'; ?>
</body>
</html>
