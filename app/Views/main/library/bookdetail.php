<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title> 

    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .prose {
            color: #374151; /* gray-700 */
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            color: #111827; /* gray-900 */
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen min-v-screen">
    <?php include __DIR__ . '/../layout/layout.php'; ?>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <main class="py-6" id="mainContent">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 mt-2 gap-3">
                
                <a href="<?= base_url('/library/' . $user["username"])?>" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Koleksi
                </a>
                
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">Detail Buku</h2>

                <?php if ($masterUserId == $user['id']) : ?>
                    

                    <div class="flex gap-3 items-center">
                        <a href="<?= base_url('/library/' . $user["username"] . '/' . $book['slug'] . '/focus') ?>"
                            type="button" 
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
                            <i class="fas fa-glasses mr-2"></i> Fokus
                        </a>
                        <a href="<?= base_url('/library/'. $user["username"] . '/' . $book['slug'] . '/edit') ?>"
                            type="button"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
                            <i class="fas fa-pen mr-2"></i> Edit
                        </a>
                        <form method="POST" action="<?= base_url('/library/' . esc($user['username']) . '/' . esc($book['slug']) . '/delete') ?>" 
                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus buku ini?')" class="inline-block">
                            <?= csrf_field() ?>
                            <button type="submit"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 inline-flex items-center">
                                <i class="fas fa-trash mr-2"></i> Hapus
                            </button>
                        </form>
                    </div>
                <?php else : ?>
                    <?php if ($isFriend && $isFriend['status'] == \App\Models\FriendshipModel::STATUS_ACCEPTED) : ?>
                        <a href="<?= base_url('library/' . $user["username"] . '/' . $book['slug'] . '/requestloan') ?>">
                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 inline-flex items-center">
                                <i class="fas fa-book-open-reader mr-2"></i> Pinjam Buku
                            </button>
                        </a>
                    <?php else : ?>
                        <div class="text-right">
                            <button type="button"
                                class="text-white bg-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex items-center cursor-not-allowed dark:bg-gray-600"
                                disabled>
                                <i class="fas fa-book-open-reader mr-2"></i> Pinjam Buku
                            </button>
                            <p class="text-red-600 text-xs mt-1 dark:text-red-400">Anda harus berteman dengan <?= esc($user['username']) ?> untuk meminjam buku ini.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-start">
                <a href="<?= base_url('library/book/' . esc($book['slug']))?>">
                    <div class="md:col-span-1">
                        <?php if ($book['book_cover']): ?>
                            <img src="<?= base_url('uploads/bookcover/' . esc($book['book_cover'])) ?>"
                                alt="Cover of <?= isset($book['title']) ? esc($book['title']) : 'Book Title' ?>"
                                class="w-full h-auto object-cover rounded-lg shadow-xl md:sticky md:top-8" 
                                style="max-height: 600px;">
                        <?php else: ?>
                            <div class="w-full bg-gray-300 aspect-[2/3] flex items-center justify-center rounded-lg shadow-xl md:sticky md:top-8" 
                                style="max-height: 600px;">
                                <i class="fas fa-image text-gray-500 text-6xl"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>

                <div class="md:col-span-2">
                    <div class="space-y-6 pb-8">
                        <h1 class="text-3xl lg:text-5xl font-extrabold text-gray-900 dark:text-white">
                            <?= isset($book['title']) ? esc($book['title']) : 'Judul Buku Tidak Tersedia' ?>
                        </h1>

                        <p class="text-xl lg:text-2xl text-gray-700 dark:text-gray-400">
                            oleh <strong class="font-semibold"><?= isset($book['author']) ? esc($book['author']) : 'Penulis Tidak Tersedia' ?></strong>
                        </p>

                        <?php if (!empty($book['genres'])): ?>
                            <p class="text-lg text-gray-700 dark:text-gray-300">
                                <strong class="font-medium">Genre:</strong>
                                <?php foreach ($book['genres'] as $i => $genre): ?>
                                    <?= esc($genre['genre_name']) ?><?= $i < count($book['genres']) - 1 ? ', ' : '' ?>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>

                        <p class="text-lg text-gray-700 dark:text-gray-300">
                            <strong class="font-medium">Tanggal Publikasi:</strong> <?= !empty(trim($book['published_date'])) ? esc(trim($book['published_date'])) : 'N/A' ?>
                        </p>

                        <p class="text-lg text-gray-700 dark:text-gray-300">
                            <strong class="font-medium">Tanggal Ditambahkan:</strong> <?= !empty(trim($book['added_at'])) ? esc(trim($book['added_at'])) : 'N/A' ?>
                        </p>

                        <?php if (isset($book['total_pages']) && intval($book['total_pages']) > 0): ?>
                            <div class="my-4 pt-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Progres Membaca</h3>
                                <p class="text-lg text-gray-700 dark:text-gray-300 mb-2">
                                    Terbaca: <?= isset($book['read_page']) ? esc(intval($book['read_page'])) : 0 ?> / <?= esc(intval($book['total_pages'])) ?> halaman
                                </p>
                                <?php
                                    $readPages = isset($book['read_page']) ? intval($book['read_page']) : 0;
                                    $totalPages = intval($book['total_pages']);
                                    $progressPercentage = ($totalPages > 0) ? ($readPages / $totalPages) * 100 : 0;
                                ?>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= round($progressPercentage, 2) ?>%"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(trim($book['description']))): ?>
                            <div class="pt-2">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Deskripsi</h3>
                                <div class="text-medium text-lg prose max-w-none text-gray-700 dark:text-gray-400 leading-relaxed">
                                    <p><?= nl2br(esc(trim($book['description']))) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(trim($book['rating']))): ?>
                            <div class="pt-2">
                                <?php if ($masterUserId === $user['id']) : ?>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Penilaianmu</h3>
                                <?php else : ?>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Penilaian <?= $user["full_name"] ?></h3>
                                <?php endif; ?>
                                <div class="flex items-center text-xl">
                                    <?php $rating = intval($book['rating']); ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa-star <?= $i <= $rating ? 'fas text-yellow-400' : 'far text-gray-300 dark:text-gray-600' ?> mr-1"></i>
                                    <?php endfor; ?>
                                    <span class="ml-2 text-md text-gray-700 dark:text-gray-400">(<?= $rating ?> dari 5)</span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(trim($book['review']))): ?>
                            <div class="pt-2">
                                <?php if ($masterUserId === $user['id']) : ?>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Ulasanmu</h3>
                                <?php else : ?>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Ulasan <?= $user["full_name"] ?></h3>
                                <?php endif; ?>
                                <blockquote>
                                    <p class="text-lg text-justify text-gray-700 dark:text-white">
                                        <?= nl2br(esc(trim($book['review']))) ?>
                                    </p>
                                </blockquote>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
    </body>
</html>