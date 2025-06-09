<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Buku</title>
    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-200 min-h-screen font-inter">
    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6 mt-6">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">
            <i class="fa fa-book-medical mr-2"></i>Tambah Buku Baru
        </h1>

        

        <form action="<?= base_url('library/proceedAddBook') ?>" method="POST" enctype="multipart/form-data" class="space-y-5" id="bookForm">
            <?= csrf_field() ?>

        <!-- Title -->


            <div>
                <label for="title" class="block mb-1 font-medium text-gray-700">Judul Buku</label>
                <input type="text" id="title" name="title" required placeholder="Masukkan judul buku" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Author -->
            <div>
                <label for="author" class="block mb-1 font-medium text-gray-700">Penulis</label>
                <input type="text" id="author" name="author" required placeholder="Masukkan nama penulis" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Book Cover -->
            <div>
                <label for="cover" class="block mb-1 font-medium text-gray-700">Sampul Buku</label>
                <input type="file" id="cover" name="cover" accept="image/*" class="w-full text-gray-600" />
            </div>

            <!-- Published Date -->
            <div>
                <label for="published_date" class="block mb-1 font-medium text-gray-700">Tanggal Terbit</label>
                <input type="date" id="published_date" name="published_date" max="<?= date('Y-m-d') ?>" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Total Pages -->
            <div>
                <label for="total_pages" class="block mb-1 font-medium text-gray-700">Jumlah Halaman</label>
                <input type="number" id="total_pages" name="total_pages" min="1" placeholder="Masukkan jumlah halaman" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />
            </div>

            <!-- Total Pages Read -->
            <div>
                <label for="pages_read" class="block mb-1 font-medium text-gray-700">Halaman yang Sudah Dibaca</label>
                <input type="number" id="pages_read" name="pages_read" min="0" placeholder="Masukkan jumlah halaman yang sudah dibaca" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />
                <small class="text-gray-500">Tidak boleh lebih dari jumlah halaman.</small>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block mb-1 font-medium text-gray-700">Deskripsi Buku</label>
                <textarea id="description" name="description" rows="4" placeholder="Deskripsikan buku ini" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-y"></textarea>
            </div>

            <!-- Review -->
            <div>
                <label for="review" class="block mb-1 font-medium text-gray-700">Review</label>
                <textarea id="review" name="review" rows="4" placeholder="Tulis review kamu tentang buku ini" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-y"></textarea>
            </div>

            <!-- Rating -->
            <!-- Rating (numeric input) -->
            <div>
                <label for="rating" class="block mb-1 font-medium text-gray-700">Rating (1–5)</label>
                <input
                    type="number"
                    id="rating"
                    name="rating"
                    min="1"
                    max="5"
                    step="1"
                    required
                    placeholder="Masukkan rating"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
            </div>


            <!-- Genre -->
            <div>
                <label for="genre_id" class="block mb-1 font-medium text-gray-700">Genre</label>
                <select
                    id="genre_id"
                    name="genre_id"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required
                >
                    <option value="" disabled selected>Pilih genre</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= esc($genre['id']) ?>">
                            <?= esc($genre['genre_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex justify-end gap-4">
                <a href="<?= base_url('/library') ?>"
                class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300 transition">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    Simpan Buku
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
