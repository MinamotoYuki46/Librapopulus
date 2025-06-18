<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari</title>
    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen font-[Inter]">

    <?php include 'layout/layout.php' ?>

    <main class="px-4 py-10 max-w-4xl mx-auto" id="mainContent">
        <div class="mb-4">
            <a href="<?= base_url() ?>" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali Ke koleksi Buku
            </a>
        </div>
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Pencarian</h1>

        <form method="GET" action="<?= site_url('search') ?>" class="flex gap-2 mb-8">
            <div class="relative w-full">
                <input 
                    type="text" 
                    name="query" 
                    value="<?= esc($query ?? '') ?>" 
                    placeholder="Cari pengguna atau buku..."
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                />
            </div>
            <button 
                type="submit" 
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300"
            >
                <i class="fas fa-search mr-2"></i> Cari
            </button>
        </form>

        <?php if (!empty($query)): ?>
            <p class="mb-4 text-gray-600 text-center">Hasil untuk: <strong><?= esc($query) ?></strong></p>

            <?php if (empty($userResults) && empty($bookResults) && empty($groupResults)): ?>
                <div class="text-center text-red-500 font-semibold mb-6">Tidak ada hasil ditemukan.</div>
            <?php else: ?>

                <?php if (!empty($userResults)): ?>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Pengguna</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                        <?php foreach ($userResults as $user): ?>
                            <a href="<?= base_url('profile/' . $user['username']) ?>" class="block bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition duration-200">
                                <div class="w-28 h-28 mx-auto">
                                    <img src="<?= base_url('uploads/' . $user['picture']) ?>"
                                        alt="<?= esc($user['username']) ?>"
                                        class="rounded-full w-full h-full object-cover border-4 border-gray-300" />
                                </div>
                                <p class="text-black font-bold mt-2 truncate"><?= '@' . esc($user['username']) ?></p>
                                <p class="text-gray-600 font-medium truncate"><?= esc($user['full_name']) ?></p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <?php if (!empty($bookResults)): ?>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Buku</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php foreach ($bookResults as $book): ?>
                            <a href="<?= base_url('/library/book/' . $book['slug']) ?>">
                            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flowbite-card-with-image">
                                <?php $cover = !empty($book['book_cover']) ? base_url('uploads/bookcover/' . esc($book['book_cover'])) : 'https://flowbite.com/docs/images/blog/image-1.jpg'; ?>
                                
                                <img class="book-cover w-full aspect-[2/3] object-cover rounded-t-lg" src="<?= $cover ?>" alt="<?= esc($book['title']) ?> cover" />

                                <div class="p-5">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        <?= esc($book['title']) ?>
                                    </h5>
                                    <p class="text-sm text-gray-700 dark:text-gray-400">
                                        Penulis: <?= esc($book['author']) ?>
                                    </p>
                                </div>
                            </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($groupResults)): ?>
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Grup</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <?php foreach ($groupResults as $group): ?>
                            <div class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition duration-200">
                                <a href="<?= base_url('group/' . $group['slug']) ?>" class="flex items-center w-full">
                                    <div class="w-16 h-16 mr-4 flex-shrink-0">
                                        <img src="<?= base_url('uploads/groups/' . $group['icon']) ?>"
                                            alt="<?= esc($group['name']) ?>"
                                            class="rounded-full w-full h-full object-cover" />
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-black font-bold text-lg"><?= esc($group['name']) ?></p>
                                        
                                        <?php if (!empty($group['description'])): ?>
                                            <p class="text-gray-600 text-sm mt-1 truncate">
                                                <?= esc($group['description']) ?>
                                            </p>
                                        <?php endif; ?>

                                        <div class="flex items-center text-xs text-gray-500 mt-2">
                                            <i class="fas fa-users mr-1.5"></i>
                                            <span><?= $group['member_count'] ?> Anggota</span>
                                        </div>
                                    </div>
                                </a>

                                <?php if (!in_array($group['id'], $joinedGroupIds)): ?>
                                    <form action="<?= base_url('group-request/join/' . $group['id']) ?>" method="post" class="ml-3">
                                        <?= csrf_field() ?>
                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                                            Gabung
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="ml-3 text-xs text-gray-500">Sudah bergabung</span>
                                <?php endif ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
