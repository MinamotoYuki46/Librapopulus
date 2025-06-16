<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil <?= $targetUsername ?></title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white">
    <?php include __DIR__ . '/../layout/layout.php'; ?>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-10" id="mainContent">
        <div class="max-w-xl mx-auto"> <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 p-6">
                <div class="flex flex-col items-center gap-6">
                    <div class="relative w-32 h-32 mb-2">
                        <img src="<?= esc(base_url('uploads/' . $otherPhotoProfile)) ?>" alt="Foto Profil"
                             class="rounded-full w-full h-full object-cover border-4 border-blue-500 dark:border-blue-700 shadow-lg" />
                    </div>

                    <div class="text-center">
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">@<?= esc($targetUsername) ?></h2>
                        <p class="text-xl text-gray-700 dark:text-gray-400 font-semibold"><?= esc($fullname) ?></p>
                    </div>

                    <div class="flex gap-8 sm:gap-12 text-center">
                        <div>
                            <span class="block text-2xl font-bold text-blue-600 dark:text-blue-400"><?= esc($friendCount) ?></span>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Teman</span>
                        </div>
                        <div>
                            <span class="block text-2xl font-bold text-green-600 dark:text-green-400"><?= esc($bookCount) ?></span>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Buku</span>
                        </div>
                    </div>

                    <div class="text-gray-600 dark:text-gray-400 flex items-center text-base">
                        <i class="fa-solid fa-location-dot mr-2 text-red-500"></i>
                        <span><?= esc($city) ?>, <?= esc($province) ?></span>
                    </div>

                    <div class="mt-4 px-4 py-2 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-800 dark:text-gray-300 w-full text-center">
                        <p class="text-sm italic">
                            <?= !empty($description) ? esc($description) : 'Belum ada biodata yang ditambahkan.' ?>
                        </p>
                    </div>

                    <?php $status = ($friendship === null) ? \App\Models\FriendshipModel::STATUS_NONE : $friendship['status'];?>
                    <div class="mt-6 flex flex-wrap justify-center gap-3 w-full">
                        <?php if ($status == \App\Models\FriendshipModel::STATUS_NONE || $status == \App\Models\FriendshipModel::STATUS_DECLINED) : ?>
                            <form method="POST" action="<?= base_url('/friends/add/' . $targetId) ?>">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center justify-center">
                                    <i class="fa-solid fa-user-plus mr-2"></i> Tambah Teman
                                </button>
                            </form>
                        <?php elseif ($status == \App\Models\FriendshipModel::STATUS_PENDING && $friendship['user_one_id'] == $myId) : ?>
                            <form method="POST" action="<?= base_url('/friends/cancel/' . $friendship['id']) ?>">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center justify-center">
                                    <i class="fa-solid fa-xmark mr-2"></i> Batalkan Permintaan
                                </button>
                            </form>
                        <?php elseif ($status == \App\Models\FriendshipModel::STATUS_PENDING && $friendship['user_one_id'] == $targetId) : ?>
                            <form method="POST" action="<?= base_url('/friends/accept/' . $friendship['id']) ?>" class="inline-block w-full sm:w-auto">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="w-full px-5 py-2.5 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 inline-flex items-center justify-center">
                                    <i class="fa-solid fa-check mr-2"></i> Terima
                                </button>
                            </form>

                            <form method="POST" action="<?= base_url('/friends/decline/' . $friendship['id']) ?>" class="inline-block w-full sm:w-auto">
                                <?= csrf_field() ?>
                                <button type="submit"
                                    class="w-full px-5 py-2.5 text-sm font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 inline-flex items-center justify-center">
                                    <i class="fa-solid fa-ban mr-2"></i> Tolak
                                </button>
                            </form>
                        <?php elseif ($status == \App\Models\FriendshipModel::STATUS_ACCEPTED) : ?>
                            <button disabled
                                class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 cursor-not-allowed dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 inline-flex items-center justify-center">
                                <i class="fa-solid fa-user-check mr-2"></i> Teman
                            </button>
                        <?php endif; ?>

                        <a href="<?= base_url('/library/' . $targetUsername) ?>"
                            class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 inline-flex items-center justify-center">
                            <i class="fa-solid fa-book mr-2"></i> Koleksi Buku
                        </a>

                        <a href="<?= base_url('/message/' . $targetUsername) ?>"
                            class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center justify-center">
                            <i class="fa-solid fa-message mr-2"></i> Pesan
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>