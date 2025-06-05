<?php

$book = [
    'id' => 10,
    'title' => 'Wuthering Heights',
    'author' => 'Emily Brontë',
    'genre' => 'Gothic Fiction',
    'readPages' => 10,
    'totalPages' => 416,
    'image' => 'https://m.media-amazon.com/images/I/81-8dCuxEsL._SY466_.jpg',
    'desc' => 'Wuthering Heights is a classic novel of intense passion and revenge, set on the bleak Yorkshire moors. It tells the tragic story of Heathcliff and Catherine Earnshaw, and explores themes of love, class, and destiny.',
    'rate' => '5',
    'review' => 'A haunting and powerful story with unforgettable characters. A must-read for fans of classic literature.',
    'date_published' => '1847-12-01',
    'date_added' => date('Y-m-d'),
];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    

</head>
<body>
    <?php include 'layout/header.php' ?>
    <main class="px-6 pb-6 py-6" id="mainContent">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col md:flex-row gap-x-6 lg:gap-x-8">

                <div class="w-full md:w-2/5 lg:w-1/3 flex-shrink-0 mb-6 md:mb-0">
                    <img src="<?= isset($book['image']) ? htmlspecialchars($book['image']) : 'https://via.placeholder.com/300x450.png?text=No+Image' ?>"
                        alt="Cover of <?= isset($book['title']) ? htmlspecialchars($book['title']) : 'Book Title' ?>"
                        class="w-full h-auto object-cover rounded-lg shadow-xl sticky top-6 md:max-h-[500px] lg:max-h-[600px]">
                </div>

                <div class="w-full md:w-3/5 lg:w-2/3">
                    <div class="space-y-5 md:max-h-[calc(100vh-8rem)] overflow-y-auto scrollbar-hide pr-2 pb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">
                            <?= isset($book['title']) ? htmlspecialchars($book['title']) : 'Book Title Not Available' ?>
                        </h1>

                        <p class="text-lg lg:text-xl text-gray-700">
                            by <strong><?= isset($book['author']) ? htmlspecialchars($book['author']) : 'Author Not Available' ?></strong>
                        </p>

                        <?php if (isset($book['genre']) && trim($book['genre']) !== ''): ?>
                            <p class="text-sm text-gray-600">
                                <strong>Genre:</strong> <?= htmlspecialchars(trim($book['genre'])) ?>
                            </p>
                        <?php endif; ?>

                        <?php if (isset($book['date_published']) && trim($book['date_published']) !== ''): ?>
                            <p class="text-sm text-gray-600"><strong>Date Published:</strong> <?= htmlspecialchars(trim($book['date_published'])) ?></p>
                        <?php else: ?>
                            <p class="text-sm text-gray-600"><strong>Date Published:</strong> N/A</p>
                        <?php endif; ?>

                        <?php if (isset($book['date_added']) && trim($book['date_added']) !== ''): ?>
                            <p class="text-sm text-gray-600"><strong>Date Added to Library:</strong> <?= htmlspecialchars(trim($book['date_added'])) ?></p>
                        <?php else: ?>
                            <p class="text-sm text-gray-600"><strong>Date Added to Library:</strong> N/A</p>
                        <?php endif; ?>

                        <?php if (isset($book['totalPages']) && intval($book['totalPages']) > 0): ?>
                        <div class="my-4 pt-2">
                            <h3 class="text-md font-semibold text-gray-800 mb-1">Reading Progress</h3>
                            <p class="text-sm text-gray-600">
                                Read: <?= isset($book['readPages']) ? intval($book['readPages']) : 0 ?> / <?= intval($book['totalPages']) ?> pages
                            </p>
                            <?php
                                $readPages = isset($book['readPages']) ? intval($book['readPages']) : 0;
                                $totalPages = intval($book['totalPages']);
                                $progressPercentage = ($totalPages > 0) ? ($readPages / $totalPages) * 100 : 0;
                            ?>
                            <div class="mt-2 w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div class="bg-sky-600 h-2.5 rounded-full" style="width: <?= round($progressPercentage, 2) ?>%"></div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($book['desc']) && trim($book['desc']) !== ''): ?>
                        <div class="pt-2">
                            <h3 class="text-md font-semibold text-gray-800 mb-1">Description</h3>
                            <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                                <?= nl2br(htmlspecialchars(trim($book['desc']))) ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($book['rate']) && trim($book['rate']) !== ''): ?>
                        <div class="pt-2">
                            <h3 class="text-md font-semibold text-gray-800 mb-1">Your Rating</h3>
                            <div class="flex items-center">
                                <?php $rating = intval($book['rate']); ?>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa-star <?= $i <= $rating ? 'fas text-yellow-400' : 'far text-gray-300' ?> mr-1"></i>
                                <?php endfor; ?>
                                <span class="ml-2 text-sm text-gray-600">(<?= $rating ?> out of 5)</span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (isset($book['review']) && trim($book['review']) !== ''): ?>
                        <div class="pt-2">
                            <h3 class="text-md font-semibold text-gray-800 mb-1">Your Review</h3>
                            <blockquote class="border-l-4 border-gray-300 pl-4 py-2 my-2 bg-gray-50 rounded">
                                <p class="text-gray-700 text-sm italic leading-relaxed">
                                    <?= nl2br(htmlspecialchars(trim($book['review']))) ?>
                            </p>
                            </blockquote>
                        </div>
                        <?php endif; ?>

                        

                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'layout/footer.php' ?>
</body>
</html>