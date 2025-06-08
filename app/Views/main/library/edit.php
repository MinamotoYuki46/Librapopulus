<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Buku</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-200 min-h-screen font-inter">
    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6 mt-6">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">
            <i class="fa fa-pen-to-square mr-2"></i>Edit Koleksi Buku
        </h1>

        <form action="<?= base_url('library/proceedEditBook/' . esc($book['collection_id'])) ?>" method="POST">
            <?= csrf_field() ?>

            <!-- Judul buku (readonly sebagai informasi) -->
            <div>
                <label class="block mb-1 font-medium text-gray-700">Judul Buku</label>
                <input type="text" readonly value="<?= esc($book['title']) ?>" class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2" />
            </div>

            <!-- Halaman Dibaca -->
            <div class="mt-4">
                <label for="read_page" class="block mb-1 font-medium text-gray-700">Halaman yang Sudah Dibaca</label>
                <input type="number" id="read_page" name="read_page" required min="0" max="<?= esc($book['total_pages']) ?>" value="<?= esc($book['read_page']) ?>" class="w-full border border-gray-300 rounded-md px-3 py-2" />
                <small class="text-gray-500">Maksimal <?= esc($book['total_pages']) ?> halaman</small>
            </div>

            <!-- Review -->
            <div class="mt-4">
                <label for="review" class="block mb-1 font-medium text-gray-700">Review</label>
                <textarea id="review" name="review" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2"><?= esc($book['review']) ?></textarea>
            </div>

            <!-- Rating -->
            <div class="mt-4">
                <label for="rating" class="block mb-1 font-medium text-gray-700">Rating (1–5)</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required value="<?= esc($book['rating']) ?>" class="w-full border border-gray-300 rounded-md px-3 py-2" />
            </div>

            <!-- Tombol aksi -->
            <div class="flex justify-end gap-4 mt-6">
                <a href="<?= base_url('/library') ?>" class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </main>


    <?php include __DIR__ . '/../layout/navbar.php'; ?>

    <script>
        const totalPagesInput = document.getElementById('total_pages');
        const pagesReadInput = document.getElementById('pages_read');

        function validatePagesRead() {
            const total = parseInt(totalPagesInput.value) || 0;
            const read = parseInt(pagesReadInput.value) || 0;
            pagesReadInput.setCustomValidity(read > total ? 'Halaman yang dibaca tidak boleh lebih dari jumlah halaman buku.' : '');
        }

        totalPagesInput.addEventListener('input', validatePagesRead);
        pagesReadInput.addEventListener('input', validatePagesRead);
    </script>
</body>
</html>
