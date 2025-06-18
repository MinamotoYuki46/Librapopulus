<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Buku</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-inter min-h-screen">

<?php include __DIR__ . '/layout.php'; ?>

<div class="h-[88px]"></div>

<main class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6 mt-6">
    <h1 class="text-2xl font-semibold mb-4 text-gray-800">
        <i class="fa fa-pen-to-square mr-2"></i>Edit Buku
    </h1>

    <form action="<?= base_url('admin/bookdata/editing/' . $book['id']) ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
        <?= csrf_field() ?>

        <div>
            <label for="title" class="block mb-1 font-medium text-gray-700">Judul Buku</label>
            <input type="text" id="title" name="title" value="<?= esc($book['title']) ?>" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label for="author" class="block mb-1 font-medium text-gray-700">Penulis</label>
            <input type="text" id="author" name="author" value="<?= esc($book['author']) ?>" required class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Sampul Saat Ini</label>
            <?php if ($book['book_cover']): ?>
                <img src="<?= base_url('uploads/bookcover/' . $book['book_cover']) ?>" alt="Cover" class="w-32 h-auto mb-2 rounded shadow" />
            <?php else: ?>
                <p class="text-sm text-gray-500 italic">Tidak ada sampul</p>
            <?php endif; ?>
            <input type="file" name="book_cover" accept="image/*" class="w-full text-gray-600" />
        </div>

        <div>
            <label for="published_date" class="block mb-1 font-medium text-gray-700">Tanggal Terbit</label>
            <input type="date" id="published_date" name="published_date" value="<?= esc($book['published_date']) ?>" max="<?= date('Y-m-d') ?>" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label for="total_pages" class="block mb-1 font-medium text-gray-700">Jumlah Halaman</label>
            <input type="number" id="total_pages" name="total_pages" value="<?= esc($book['total_pages']) ?>" min="1" class="w-full border rounded px-3 py-2" />
        </div>

        <div>
            <label for="description" class="block mb-1 font-medium text-gray-700">Deskripsi</label>
            <textarea id="description" name="description" rows="4" class="w-full border rounded px-3 py-2"><?= esc($book['description']) ?></textarea>
        </div>

        <div>
            <p class="block mb-1 font-medium text-gray-700">Genre</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <?php foreach ($genres as $genre): ?>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="genres[]" value="<?= esc($genre['id']) ?>" 
                            <?= in_array($genre['id'], $bookGenreIds) ? 'checked' : '' ?> 
                            class="text-indigo-600 border-gray-300 rounded" />
                        <span class="ml-2 text-gray-700"><?= esc($genre['genre_name']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="<?= base_url('/admin/bookdata') ?>" class="px-4 py-2 bg-gray-200 rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan Perubahan</button>
        </div>
    </form>
</main>
<script src="<?= base_url("flowbite.min.js") ?>"></script>

</body>
</html>
