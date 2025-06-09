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
</head>
<body>
    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main class="px-6 pb-6 py-6" id="mainContent">
        <div class="max-w-screen-3xl w-full mx-auto px-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 mt-2 gap-3">
                <h2 class="text-6xl font-bold text-gray-900">Detail Buku</h2>

                <?php if (session() -> get('userId') === $user['id']) : ?>
                    <div class="flex gap-3">
                        <a aria-label="Focus Mode" title="Focus Mode" href="<?= base_url('/library/' . $user["username"] . '/' . $book['slug'] . '/focus') ?>"
                            class="p-3 rounded-full hover:bg-gray-200 transition text-gray-600 text-3xl">
                            <i class="fas fa-glasses"></i>
                        </a>

                        <a href="<?= base_url( '/library/'. $user["username"] . '/' . $book['slug'] . '/edit') ?>"
                            aria-label="Edit Book" title="Edit Book"
                            class="p-3 rounded-full hover:bg-gray-200 transition text-gray-600 text-3xl">
                            <i class="fas fa-pen"></i>
                        </a>

                        <form method="POST" action="<?= base_url('/library/' . $user["username"] . '/' . $book['slug'] . '/delete') ?>" 
                            onsubmit="return confirm('Apakah kamu yakin ingin menghapus buku ini?')">
                            <button type="submit"
                                aria-label="Delete Book" title="Delete Book"
                                class="p-3 rounded-full hover:bg-red-100 transition text-red-600 text-3xl">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                <?php else : ?>
                    <a href="<?= base_url('library/' . $user["username"] . '/' . $book['slug'] . '/requestloan') ?>">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                            <i class="fas fa-book-open-reader"></i> Pinjam Buku
                        </button>
                    </a>
                <?php endif; ?>
            </div>


            <div class="flex flex-col md:flex-row gap-x-6 lg:gap-x-8">

                <div class="w-full md:w-2/5 lg:w-1/3 flex-shrink-0 mb-6 md:mb-0">
                    <img src="<?= isset($book['book_cover']) 
                        ? base_url('uploads/bookcover/' . esc($book['book_cover'])) 
                        : 'https://via.placeholder.com/300x450.png?text=No+Image' ?>"
                        alt="Cover of <?= isset($book['title']) ? esc($book['title']) : 'Book Title' ?>"
                        class="w-full h-auto object-cover rounded-lg shadow-xl sticky top-6 md:max-h-[600px] lg:max-h-[800px]">
                </div>

                <div class="w-full md:w-3/5 lg:w-2/3">
                    <div class="space-y-5 md:max-h-[calc(100vh-8rem)] overflow-y-auto scrollbar-hide pr-2 pb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">
                            <?= isset($book['title']) ? esc($book['title']) : 'Book Title Not Available' ?>
                        </h1>

                        <p class="text-lg lg:text-xl text-gray-700">
                            oleh <strong><?= isset($book['author']) ? esc($book['author']) : 'Author Not Available' ?></strong>
                        </p>

                        <?php if (!empty(trim($book['genres']))): ?>
                            <p class="text-sm text-gray-600"><strong>Genre:</strong> <?= esc(trim($book['genres'])) ?></p>
                        <?php endif; ?>

                        <p class="text-sm text-gray-600">
                            <strong>Tanggal Publikasi:</strong> <?= !empty(trim($book['published_date'])) ? esc(trim($book['published_date'])) : 'N/A' ?>
                        </p>

                        <p class="text-sm text-gray-600">
                            <strong>Tanggal Ditambahkan:</strong> <?= !empty(trim($book['added_at'])) ? esc(trim($book['added_at'])) : 'N/A' ?>
                        </p>

                        <?php if (isset($book['total_pages']) && intval($book['total_pages']) > 0): ?>
                            <div class="my-4 pt-2">
                                <h3 class="text-md font-semibold text-gray-800 mb-1">Progres Membaca</h3>
                                <p class="text-sm text-gray-600">
                                    Terbaca: <?= isset($book['read_page']) ? esc(intval($book['read_page'])) : 0 ?> / <?= esc(intval($book['total_pages'])) ?> halaman
                                </p>
                                <?php
                                    $readPages = isset($book['read_page']) ? intval($book['read_page']) : 0;
                                    $totalPages = intval($book['total_pages']);
                                    $progressPercentage = ($totalPages > 0) ? ($readPages / $totalPages) * 100 : 0;
                                ?>
                                <div class="mt-2 w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-sky-600 h-2.5 rounded-full" style="width: <?= round($progressPercentage, 2) ?>%"></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(trim($book['description']))): ?>
                            <div class="pt-2">
                                <h3 class="text-md font-semibold text-gray-800 mb-1">Deskripsi</h3>
                                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                                    <?= nl2br(esc(trim($book['description']))) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(trim($book['rating']))): ?>
                            <div class="pt-2">
                                <?php if (session() -> get('userId') === $user['id']) : ?>
                                    <h3 class="text-md font-semibold text-gray-800 mb-1">Penilaianmu</h3>
                                <?php else : ?>
                                    <h3 class="text-md font-semibold text-gray-800 mb-1">Penilaian <?= $user["full_name"] ?></h3>
                                <?php endif; ?>
                                <div class="flex items-center">
                                    <?php $rating = intval($book['rating']); ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fa-star <?= $i <= $rating ? 'fas text-yellow-400' : 'far text-gray-300' ?> mr-1"></i>
                                    <?php endfor; ?>
                                    <span class="ml-2 text-sm text-gray-600">(<?= $rating ?> dari 5)</span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(trim($book['review']))): ?>
                            <div class="pt-2">
                                <?php if (session() -> get('userId') === $user['id']) : ?>
                                    <h3 class="text-md font-semibold text-gray-800 mb-1">Ulasanmu</h3>
                                <?php else : ?>
                                    <h3 class="text-md font-semibold text-gray-800 mb-1">Ulasan <?= $user["full_name"] ?></h3>
                                <?php endif; ?>
                                <blockquote class="border-l-4 border-gray-300 pl-4 py-2 my-2 bg-gray-50 rounded">
                                    <p class="text-gray-700 text-sm italic leading-relaxed">
                                        <?= nl2br(esc(trim($book['review']))) ?>
                                    </p>
                                </blockquote>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../layout/navbar.php'; ?>
</body>
</html>
