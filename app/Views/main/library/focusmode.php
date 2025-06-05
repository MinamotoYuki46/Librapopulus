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
    <title>Mode Fokus</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        /* Removed #focusOverlay styles */
    </style>
</head>
<body class="relative overflow-x-hidden">

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main class="px-6 py-6" id="mainContent">
        <div class="max-w-screen-3xl mx-auto px-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 mt-2 gap-3">
                <h2 class="text-6xl font-bold text-gray-900">Mode Fokus</h2>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-x-6 lg:gap-x-8 relative">
            <div class="w-full md:w-2/5 lg:w-1/3 mb-6">
                <img src="<?= htmlspecialchars($book['image']) ?>"
                    alt="Cover of <?= htmlspecialchars($book['title']) ?>"
                    class="w-full h-auto object-cover rounded-lg shadow-xl sticky top-6 max-h-[800px]">
            </div>

            <div class="w-full md:w-3/5 lg:w-2/3">
                <div class="space-y-5 md:max-h-[calc(100vh-8rem)] overflow-y-auto scrollbar-hide pr-2 pb-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900"><?= htmlspecialchars($book['title']) ?></h1>
                    <p class="text-lg lg:text-xl text-gray-700">by <strong><?= htmlspecialchars($book['author']) ?></strong></p>

                    <div class="my-4 pt-2">
                        <h3 class="text-md font-semibold text-gray-800 mb-1">Reading Progress</h3>
                        <p class="text-sm text-gray-600">Read: <?= $book['readPages'] ?> / <?= $book['totalPages'] ?> pages</p>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-sky-600 h-2.5 rounded-full" style="width: <?= round($book['readPages'] /  $book['totalPages'] * 100, 2) ?>%"></div>
                        </div>
                    </div>
                </div>

                <!-- Focus Area -->
                <div id="focusBox" class="bg-gray-100 w-full p-6 rounded-xl shadow-inner text-center relative">
                    <h2 class="text-6xl font-bold" id="timer">00:00:00</h2>

                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <button id="startBtn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Start</button>
                        <button id="pauseBtn" class="px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500">Pause</button>
                        <button id="resumeBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Continue</button>
                        <button id="endBtn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">End</button>
                    </div>

                    <div class="mt-6">
                        <label for="pagesRead" class="block text-sm font-medium text-gray-700">Pages Read:</label>
                        <input type="number" id="pagesRead" class="mt-1 w-24 text-center border border-gray-300 rounded-md p-2" min="0" value="<?= $book['readPages'] ?>">
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include __DIR__ . '/../layout/footer.php'; ?>
    <script src="<?= base_url(relativePath: 'assets/js/main.js')?>"></script>
    <script src="<?= base_url(relativePath: 'assets/js/focus.js')?>"></script>
</body>
</html>