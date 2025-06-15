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
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
        
</head>
<body class="bg-gray-200 min-h-screen min-v-screen">
    <?php include __DIR__ . '/../layout/layout.php'; ?>
    
    <div class="container mx-auto px-4 sm:px-6 lg:px-8"> 
        <main class="py-6" id="mainContent">

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
                            <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                <a href="<?= base_url('/library/' .$otherUsername . '/' . $book['slug']) ?>">
                                    <?php if ($book['book_cover']): ?>
                                        <img class="rounded-t-lg aspect-[2/3] object-cover w-full" 
                                             src="<?= base_url('uploads/bookcover/' . esc($book['book_cover'])) ?>" 
                                             alt="<?= esc($book['title']) ?>" />
                                    <?php else: ?>
                                        <div class="rounded-t-lg bg-gray-300 aspect-[2/3] flex items-center justify-center">
                                            <i class="fas fa-image text-gray-500 text-5xl"></i>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="p-5 flex flex-col flex-grow">
                                    <a href="<?= base_url('/library/' .$otherUsername . '/' . $book['slug']) ?>">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-clamp-2 leading-tight">
                                            <?= esc($book['title']) ?>
                                        </h5>
                                    </a>
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 text-lg text-clamp-1">
                                        <?= esc($book['author']) ?>
                                    </p>

                                    <div class="mt-auto">
                                        <?php $progress = round(($book['read_page'] / $book['total_pages']) * 100, 2); ?>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= esc($progress) ?>%"></div>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><?= esc($progress) ?>% selesai</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-gray-600 dark:text-gray-400 text-center py-10">Belum ada buku dalam koleksi ini.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script src="<?= base_url("flowbite.min.js") ?>"></script>
    </body>
</html>