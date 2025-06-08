<?php


// $books = [
//     [
//         'id' => 1,
//         'title' => 'The Great Gatsby',
//         'author' => 'F. Scott Fitzgerald',
//         'progress' => 65,
//         'image' => 'https://m.media-amazon.com/images/I/81af+MCATTL.jpg'
//     ],
//     [
//         'id' => 2,
//         'title' => 'To Kill a Mockingbird',
//         'author' => 'Harper Lee',
//         'progress' => 32,
//         'image' => 'https://m.media-amazon.com/images/I/71FxgtFKcQL._SY522_.jpg'
//     ],
//     [
//         'id' => 3,
//         'title' => '1984',
//         'author' => 'George Orwell',
//         'progress' => 78,
//         'image' => 'https://m.media-amazon.com/images/I/71kxa1-0mfL.jpg'
//     ],
//     [
//         'id' => 4,
//         'title' => 'Pride and Prejudice',
//         'author' => 'Jane Austen',
//         'progress' => 45,
//         'image' => 'https://m.media-amazon.com/images/I/81a3sr-RgdL._SY425_.jpg'
//     ],
//     [
//         'id' => 5,
//         'title' => 'The Catcher in the Rye',
//         'author' => 'J.D. Salinger',
//         'progress' => 12,
//         'image' => 'https://m.media-amazon.com/images/I/81OthjkJBuL.jpg'
//     ],
//     [
//         'id' => 6,
//         'title' => 'Moby Dick',
//         'author' => 'Herman Melville',
//         'progress' => 50,
//         'image' => 'https://m.media-amazon.com/images/I/61cGr2j9KFL._SY522_.jpg'
//     ],
//     [
//         'id' => 7,
//         'title' => 'Jane Eyre',
//         'author' => 'Charlotte Brontë',
//         'progress' => 38,
//         'image' => 'https://m.media-amazon.com/images/I/81eB+7+CkUL.jpg'
//     ],
//     [
//         'id' => 8,
//         'title' => 'Brave New World',
//         'author' => 'Aldous Huxley',
//         'progress' => 80,
//         'image' => 'https://m.media-amazon.com/images/I/71GNqqXuN3L._SY466_.jpg'
//     ],
//     [
//         'id' => 9,
//         'title' => 'Frankenstein',
//         'author' => 'Mary Shelley',
//         'progress' => 27,
//         'image' => 'https://m.media-amazon.com/images/I/81z7E0uWdtL._SY466_.jpg'
//     ],
//     [
//         'id' => 10,
//         'title' => 'Wuthering Heights',
//         'author' => 'Emily Brontë',
//         'progress' => 59,
//         'image' => 'https://m.media-amazon.com/images/I/81-8dCuxEsL._SY466_.jpg'
//     ]
// ]



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku</title>

    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Inter Font -->
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
                <h2 class="text-3xl font-bold text-gray-900">Koleksi Bukuku</h2>

                <div class="flex items-center gap-2 ml-auto">
                    <a href="<?= base_url('library/add') ?>" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow inline-flex items-center">
                        <i class="fas fa-plus mr-1"></i> Tambah Buku
                    </a>
                </div>
            </div>

            <?php if (!empty($userCollection)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($userCollection as $book): ?>
                    <a class="book-card bg-gray-100 rounded-lg p-4 hover:bg-gray-300 transition-colors cursor-pointer flex flex-col" 
                        data-book-id="<?= esc($book['collection_id']) ?> " href="<?= base_url('/library/book/' . $book['collection_id'] . '/' . $book['slug']) ?>">
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

    <script src="<?= base_url(relativePath: 'assets/js/main.js')?>"></script>
</body>
</html>