<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku</title>

    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
    <style>
        .book-card {
                min-width: 140px;
                flex-shrink: 0;
                height: 400px;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        .text-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .text-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-200 min-h-screen">
    <?php include __DIR__ . '/../layout/header.php'; ?>
    <main class="px-6 pb-6 py-6" id="mainContent">

        <section class="mb-8">
            <div class="flex items-center justify-between mb-4 gap-4 flex-wrap">
                <h2 class="text-3xl font-bold text-gray-900">
                    <?php if ($isOwnProfile): ?>
                        Koleksi Bukuku
                    <?php else: ?>
                        Koleksi Buku <?= htmlspecialchars($fullname) ?>
                    <?php endif; ?>
                </h2>


                <?php if ($isOwnProfile): ?>
                    <div class="flex items-center gap-2 ml-auto">
                        <a href="<?= base_url('library/add') ?>" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow inline-flex items-center">
                            <i class="fas fa-plus mr-1"></i> Tambah Buku
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <?php if (!empty($userCollection)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($userCollection as $book): ?>
                    <a class="book-card bg-gray-100 rounded-lg p-4 hover:bg-gray-300 transition-colors cursor-pointer flex flex-col" 
                        data-book-id="<?= esc($book['collection_id']) ?> " href="<?= base_url('/library/' .$otherUsername . '/' . $book['slug']) ?>">
                        <div class="bg-gray-300 rounded-lg mb-3 aspect-[2/3] overflow-hidden">
                            <?php if ($book['book_cover']): ?>
                                <img src="<?= isset($book['book_cover']) 
                                    ? base_url('uploads/bookcover/' . esc($book['book_cover'])) 
                                    : 'https://via.placeholder.com/300x450.png?text=No+Image' ?>" alt="<?= esc($book['title']) ?>" 
                                    class="w-full h-full object-cover rounded-lg">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-gray-500 text-3xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex flex-col flex-grow">
                            <h3 class="font-semibold text-gray-900 text-xl mb-1 text-clamp-2 leading-tight">
                                <?= esc($book['title']) ?>
                            </h3>
                            <p class="text-gray-700 text-lg mb-2 text-clamp-1"><?= esc($book['author']) ?></p>
                            
                            <div class="mt-auto">
                                <div class="bg-gray-300 rounded-full h-1">
                                    <?php $progress = round(($book['read_page'] / $book['total_pages']) * 100, 2); ?>
                                    <div class="bg-purple-600 h-1 rounded-full" style="width: <?= esc($progress) ?>%"></div>
                                </div>
                                <p class="text-base text-gray-600 mt-1"><?= esc($progress) ?>% selesai</p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </section>
    </main>
    <?php include __DIR__ . '/../layout/navbar.php'; ?>
</body>
</html>