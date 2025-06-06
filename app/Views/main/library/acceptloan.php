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
 
$owner = "Fulan";
$currentUser = "Alice";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuan Peminjaman</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="relative overflow-x-hidden">

<?php include __DIR__ . '/../layout/header.php'; ?>

<main class="px-6 py-6" id="mainContent">
    <div class="max-w-screen-3xl mx-auto px-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 mt-2 gap-3">
            <h2 class="text-6xl font-bold text-gray-900">Ajukan Peminjaman Buku</h2>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-x-6 lg:gap-x-8 relative">
        <!-- Book Image -->
        <div class="w-full md:w-2/5 lg:w-1/3 mb-6">
            <img src="<?= htmlspecialchars($book['image']) ?>"
                alt="Cover of <?= htmlspecialchars($book['title']) ?>"
                class="w-full h-auto object-cover rounded-lg shadow-xl sticky top-6 max-h-[800px]">
        </div>

        <!-- Book Details and Form -->
        <div class="w-full md:w-3/5 lg:w-2/3">
            <div class="space-y-5 md:max-h-[calc(100vh-8rem)] overflow-y-auto scrollbar-hide pr-2 pb-8">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900"><?= htmlspecialchars($book['title']) ?></h1>
                <p class="text-lg lg:text-xl text-gray-700">by <strong><?= htmlspecialchars($book['author']) ?></strong></p>


                <!-- Loan Request Form -->
                <form action="<?= base_url('/loan/request') ?>" method="POST" class="space-y-4 pt-6">
                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

                    <div>
                        <label for="from_user" class="block text-3xl font-bold text-gray-700">Dari</label>
                        <input type="text" id="from_user" name="from_user" value="<?= htmlspecialchars($currentUser) ?>" readonly
                            class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm text-2xl font-bold">
                    </div>

                    <div>
                        <label for="to_user" class="block text-3xl font-bold text-gray-700">Kepada</label>
                        <input type="text" id="to_user" name="to_user" value="<?= htmlspecialchars($owner) ?>" readonly
                            class="mt-1 block w-full rounded-md bg-gray-100 border-gray-300 shadow-sm text-2xl font-bold">
                    </div>

                    <div>
                        <label for="start_date" class="block text-3xl font-bold text-gray-700">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-2xl font-bold">
                    </div>

                    <div>
                        <label for="end_date" class="block text-3xl font-bold text-gray-700">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-2xl font-bold">
                    </div>

                    <div class="flex justify-start gap-4 pt-4">
                        <button type="submit" name="action" value="accept"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-white hover:bg-green-700 transition">
                            <i class="fa-solid fa-check mr-2"></i> Terima
                        </button>

                        <button type="submit" name="action" value="suggest"
                            class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-bold text-white hover:bg-yellow-600 transition">
                            <i class="fa-solid fa-pen mr-2"></i> Sarankan Perubahan
                        </button>

                        <button type="submit" name="action" value="reject"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-bold text-white hover:bg-red-700 transition">
                            <i class="fa-solid fa-xmark mr-2"></i> Tolak
                        </button>

                        <a href="<?= base_url('/books') ?>"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 font-bold rounded-md hover:bg-gray-400 transition">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>
</body>
</html>