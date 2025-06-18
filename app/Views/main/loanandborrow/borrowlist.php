<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku yang Pinjam</title>

    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        body { background-color: #f0f2f5; }
        #mainContent {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            margin: 0 auto;
            max-width: 935px;
        }
        .main-content-area {
            width: 100%;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            overflow: hidden;
        }
        .tab-content-section {
            padding: 20px;
        }
        .tab-flex-wrap {
            flex-wrap: wrap; /* Allows tabs to wrap if screen is too small */
            justify-content: center; /* Center tabs if they wrap */
        }
        /* Style for the book cover image */
        .book-cover {
            width: 100%;
            height: 200px; /* Fixed height for consistent card appearance */
            object-fit: cover; /* Ensures image covers the area without distortion */
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        /* Adjust card padding for image */
        .flowbite-card-with-image .p-5 {
            padding-top: 0; /* Remove top padding if image is at the very top */
        }
    </style>
</head>
<body>
<?php include __DIR__ . '/../layout/layout.php'; ?>


<div class="w-full max-w-7xl mx-auto mb-4">
    <a href="<?= base_url() ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
        <i class="fas fa-arrow-left mr-2"></i>
        Kembali Ke Koleksi Buku
    </a>
</div>
<main id="mainContent" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="main-content-area">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center tab-flex-wrap" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="requests-tab" data-tabs-target="#requests" type="button" role="tab" aria-controls="requests" aria-selected="true">Permintaan Peminjaman</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="lent-out-tab" data-tabs-target="#lent-out" type="button" role="tab" aria-controls="lent-out" aria-selected="false">Buku yang Saya Pinjam</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="history-lender-tab" data-tabs-target="#history-lender" type="button" role="tab" aria-controls="history-lender" aria-selected="false">Riwayat Pinjaman Saya</button>
                </li>
            </ul>
        </div>

        <div id="default-tab-content">
            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tab-content-section" id="requests" role="tabpanel" aria-labelledby="requests-tab">
                <h3 class="text-lg font-bold mb-4">Permintaan Peminjaman Buku</h3>
                <?php if (!empty($requests)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($requests as $borrow): ?>
                            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flowbite-card-with-image">
                                <?php $coverPath = isset($borrow['book_cover']) && !empty($borrow['book_cover']) ? base_url($borrow['book_cover']) : 'https://flowbite.com/docs/images/blog/image-1.jpg'; ?>
                                <img class="book-cover" src="<?= base_url(  'uploads/bookcover/'. esc($borrow['book_cover']))?>" alt="<?= esc($borrow['book_title']) ?> cover" />
                                <div class="p-5">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"><?= esc($borrow['book_title']) ?></h5>
                                    <p class="mb-1 text-sm font-normal text-gray-700 dark:text-gray-400">Diminta oleh: <strong><?= esc($borrow['owner_name']) ?></strong></p>
                                    <p class="mb-3 text-sm font-normal text-gray-700 dark:text-gray-400">Tanggal Permintaan: <?= date('d M Y', strtotime($borrow['created_at'])) ?></p>
                                    <a href="<?= base_url('library/requested-loan/' . $borrow['id']) ?>"
                                        class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-5">Belum ada permintaan peminjaman baru dari Anda.</p>
                <?php endif; ?>
            </div>

            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tab-content-section" id="lent-out" role="tabpanel" aria-labelledby="lent-out-tab">
                <h3 class="text-lg font-bold mb-4">Buku yang Saya Pinjam</h3>
                <?php if (!empty($borrowOut)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($borrowOut as $borrow): ?>
                            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flowbite-card-with-image">
                                <?php $coverPath = isset($borrow['book_cover']) && !empty($borrow['book_cover']) ? base_url($borrow['book_cover']) : 'https://flowbite.com/docs/images/blog/image-1.jpg'; ?>
                                <img class="book-cover" src="<?= base_url(  'uploads/bookcover/'. esc($borrow['book_cover']))?>" alt="<?= esc($borrow['book_title']) ?> cover" />
                                <div class="p-5">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"><?= esc($borrow['book_title']) ?></h5>
                                    <p class="mb-1 text-sm font-normal text-gray-700 dark:text-gray-400">pemilik: <strong><?= esc($borrow['owner_name']) ?></strong></p>
                                    <p class="mb-1 text-sm font-normal text-gray-700 dark:text-gray-400">Tanggal Pinjam: <?= date('d M Y', strtotime($borrow['loan_start_date'])) ?></p>
                                    <p class="mb-3 text-sm font-normal text-gray-700 dark:text-gray-400">Jatuh Tempo: <?= date('d M Y', strtotime($borrow['loan_end_date'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-5">Tidak ada buku yang sedang dipinjamkan.</p>
                <?php endif; ?>
            </div>

            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tab-content-section" id="history-lender" role="tabpanel" aria-labelledby="history-lender-tab">
                <h3 class="text-lg font-bold mb-4">Riwayat Pinjaman</h3>
                <?php if (!empty($history)): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php foreach ($history as $borrow): ?>
                            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flowbite-card-with-image">
                                <?php $coverPath = isset($borrow['book_cover']) && !empty($borrow['book_cover']) ? base_url($borrow['book_cover']) : 'https://flowbite.com/docs/images/blog/image-1.jpg'; ?>
                                <img class="book-cover" src="<?= base_url(  'uploads/bookcover/'. esc($borrow['book_cover']))?>" alt="<?= esc($borrow['book_title']) ?> cover" />
                                <div class="p-5">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white"><?= esc($borrow['book_title']) ?></h5>
                                    <p class="mb-1 text-sm font-normal text-gray-700 dark:text-gray-400">pemilik: <strong><?= esc($borrow['owner_name']) ?></strong></p>
                                    <p class="mb-1 text-sm font-normal text-gray-700 dark:text-gray-400">Tanggal Pinjam: <?= date('d M Y', strtotime($borrow['loan_start_date'])) ?></p>
                                    <p class="mb-3 text-sm font-normal text-gray-700 dark:text-gray-400">Tanggal Kembali: <?= date('d M Y', strtotime($borrow['returned_at'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 dark:text-gray-400 text-center py-5">Belum ada riwayat peminjaman.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>