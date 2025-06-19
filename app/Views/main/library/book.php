<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title> 
    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-200 min-h-screen">
    <?php include __DIR__ . '/../layout/layout.php'; ?>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <main class="py-6">
            
            <div class="mb-6 mt-2 space-y-4">
                <a href="<?= base_url('/library/booklist') ?>" 
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar Buku
                </a>

                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white text-center">Detail Buku</h2>
            </div>


            <div class="grid md:grid-cols-3 gap-8 items-start">
                <div class="md:col-span-1">
                    <?php if ($book['book_cover']): ?>
                        <img src="<?= base_url('uploads/bookcover/' . esc($book['book_cover'])) ?>"
                         alt="Cover of <?= esc($book['title']) ?>"
                            class="w-full h-auto object-cover rounded-lg shadow-xl md:sticky md:top-8"
                            style="max-height: 600px;">
                    <?php else: ?>
                        <div class="w-full bg-gray-300 aspect-[2/3] flex items-center justify-center rounded-lg shadow-xl md:sticky md:top-8"
                            style="max-height: 600px;">
                            <i class="fas fa-image text-gray-500 text-6xl"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="md:col-span-2">
                    <div class="space-y-6 pb-8">
                        <h1 class="text-3xl lg:text-5xl font-extrabold text-gray-900 dark:text-white">
                            <?= esc($book['title']) ?>
                        </h1>

                        <p class="text-xl lg:text-2xl text-gray-700 dark:text-gray-400">
                            oleh <strong class="font-semibold"><?= esc($book['author']) ?></strong>
                        </p>

                        <?php if (!empty($book['genres'])): ?>
                            <p class="text-lg text-gray-700 dark:text-gray-300">
                                <strong class="font-medium">Genre:</strong>
                                <?php foreach ($book['genres'] as $i => $genre): ?>
                                    <?= esc($genre['genre_name']) ?><?= $i < count($book['genres']) - 1 ? ', ' : '' ?>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>


                        <?php if (!empty(trim($book['published_date']))): ?>
                            <p class="text-lg text-gray-700 dark:text-gray-300">
                                <strong class="font-medium">Tanggal Publikasi:</strong> <?= esc(trim($book['published_date'])) ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($book['total_pages'])): ?>
                            <p class="text-lg text-gray-700 dark:text-gray-300">
                                <strong class="font-medium">Jumlah Halaman:</strong> <?= esc($book['total_pages']) ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty(trim($book['description']))): ?>
                            <div class="pt-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Deskripsi</h3>
                                <div class="text-medium text-lg prose max-w-none text-gray-700 dark:text-gray-400 leading-relaxed">
                                    <p><?= nl2br(esc(trim($book['description']))) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($ratings)): ?>
                            <div class="pt-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Penilaian Pengguna</h3>
                                <div class="flex items-center text-xl mb-4">
                                    <?php
                                        $avgRating = round(array_sum(array_column($ratings, 'rating')) / count($ratings), 2);
                                        $stars = floor($avgRating);
                                    ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa-star <?= $i <= $stars ? 'fas text-yellow-400' : 'far text-gray-300 dark:text-gray-600' ?> mr-1"></i>
                                    <?php endfor; ?>
                                    <span class="ml-2 text-md text-gray-700 dark:text-gray-400">(<?= $avgRating ?> dari 5)</span>
                                </div>

                                <?php foreach ($ratings as $entry): ?>
                                    <a href="<?= base_url('library/' . esc($entry['username']) . '/' . esc($book['slug'])) ?>" 
                                    class="dark:text-blue-400">

                                        <div class="mb-3 border-t pt-2">
                                            <p class="text-gray-800 dark:text-white font-medium">
                                                <?= esc($entry['full_name']) ?>
                                            </p>
                                            <div class="flex items-center mb-1">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i class="fa-star <?= $i <= $entry['rating'] ? 'fas text-yellow-400' : 'far text-gray-300 dark:text-gray-600' ?> mr-1"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <?php if (!empty(trim($entry['review']))): ?>
                                                <p class="text-gray-700 dark:text-gray-400"><?= nl2br(esc($entry['review'])) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <p class="text-gray-700 dark:text-gray-300 text-lg mt-4">Dimiliki oleh:</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <?php foreach ($owners as $owner): ?>
                    <a href="<?= base_url('profile/' . $owner['username']) ?>" class="block bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition duration-200">
                        <div class="w-28 h-28 mx-auto">
                            <img src="<?= base_url('uploads/users/' . $owner['picture']) ?>"
                                alt="<?= esc($owner['username']) ?>"
                                class="rounded-full w-full h-full object-cover border-4 border-gray-300" />
                        </div>
                        <p class="text-black font-bold mt-2 truncate"><?= '@' . esc($owner['username']) ?></p>
                        <p class="text-gray-600 font-medium truncate"><?= esc($owner['full_name']) ?></p>
                    </a>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
