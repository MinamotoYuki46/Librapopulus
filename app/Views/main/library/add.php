<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Buku</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100 font-inter min-h-screen">
    <?php include __DIR__ . '/../layout/layout.php'; ?>

    <main class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6 mt-6">
        <h1 class="text-2xl font-semibold mb-4 text-gray-800">
            <i class="fa fa-book-medical mr-2"></i>Tambah Buku Baru
        </h1>

        <form action="<?= base_url('library/proceedAddBook') ?>" method="POST" enctype="multipart/form-data" class="space-y-5" id="bookForm">
            <?= csrf_field() ?>

            <div class="relative">
                <label for="book_search" class="block mb-1 font-medium text-gray-700">Cari Buku dari Sistem</label>
                <input type="text" id="book_search" name="book_search" autocomplete="off" placeholder="Ketik judul, penulis, atau tahun terbit"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                <ul id="search_results" class="absolute z-10 w-full bg-white border border-gray-300 rounded-md mt-1 hidden max-h-60 overflow-y-auto shadow-lg">
                </ul>
            </div>

            <input type="hidden" name="existing_book_id" id="existing_book_id" value="">

            <div>
                <label for="title" class="block mb-1 font-medium text-gray-700">Judul Buku</label>
                <input type="text" id="title" name="title" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="author" class="block mb-1 font-medium text-gray-700">Penulis</label>
                <input type="text" id="author" name="author" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="cover" class="block mb-1 font-medium text-gray-700">Sampul Buku</label>
                <input type="file" id="cover" name="cover" accept="image/*" class="w-full text-gray-600" />
            </div>

            <div>
                <label for="published_date" class="block mb-1 font-medium text-gray-700">Tanggal Terbit</label>
                <input type="date" id="published_date" name="published_date" max="<?= date('Y-m-d') ?>" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div>
                <label for="total_pages" class="block mb-1 font-medium text-gray-700">Jumlah Halaman</label>
                <input type="number" id="total_pages" name="total_pages" min="1" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />
            </div>

            <div>
                <label for="pages_read" class="block mb-1 font-medium text-gray-700">Halaman yang Sudah Dibaca</label>
                <input type="number" id="pages_read" name="pages_read" min="0" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required />
                <small class="text-gray-500">Tidak boleh lebih dari jumlah halaman.</small>
            </div>

            <div>
                <label for="description" class="block mb-1 font-medium text-gray-700">Deskripsi Buku</label>
                <textarea id="description" name="description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-y"></textarea>
            </div>

            <div>
                <label for="review" class="block mb-1 font-medium text-gray-700">Review</label>
                <textarea id="review" name="review" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-y"></textarea>
            </div>

            <div>
                <label for="rating" class="block mb-1 font-medium text-gray-700">Rating (1–5)</label>
                <input type="number" id="rating" name="rating" min="1" max="5" step="1" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <div>
                <p class="block mb-1 font-medium text-gray-700">Genre</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    <?php foreach ($genres as $genre): ?>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="genres[]" value="<?= esc($genre['id']) ?>" class="text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <span class="ml-2 text-gray-700"><?= esc($genre['genre_name']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="<?= base_url('/library') ?>" class="px-4 py-2 rounded-md bg-gray-200 text-gray-800 hover:bg-gray-300 transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Simpan Buku</button>
            </div>
        </form>
    </main>

    <script>
        const searchInput = document.getElementById('book_search');
        const resultsBox = document.getElementById('search_results');
        const bookIdInput = document.getElementById('existing_book_id');

        searchInput.addEventListener('input', async function () {
            const query = this.value.trim();
            resultsBox.innerHTML = '';
            resultsBox.classList.add('hidden');
            bookIdInput.value = '';

            if (query.length < 2) return;

            try {
                const response = await fetch(`/library/api/search-book?q=${encodeURIComponent(query)}`);
                const books = await response.json();

                if (!Array.isArray(books)) throw new Error("Invalid response");

                if (books.length === 0) {
                    resultsBox.innerHTML = `<li class="px-4 py-2 text-gray-500">Tidak ada hasil</li>`;
                } else {
                    books.forEach(book => {
                        const li = document.createElement('li');
                        li.className = 'px-4 py-2 hover:bg-indigo-100 cursor-pointer';
                        li.textContent = `${book.title} - ${book.author} (${book.published_date})`;
                        li.addEventListener('click', () => {
                            document.getElementById('title').value = book.title;
                            document.getElementById('author').value = book.author;
                            document.getElementById('published_date').value = book.published_date;
                            document.getElementById('description').value = book.description ?? '';
                            document.getElementById('total_pages').value = book.total_pages ?? '';
                            bookIdInput.value = book.id;

                            resultsBox.innerHTML = '';
                            resultsBox.classList.add('hidden');
                        });
                        resultsBox.appendChild(li);
                    });
                }

                resultsBox.classList.remove('hidden');
            } catch (err) {
                console.error('Gagal fetch buku:', err);
            }
        });

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                resultsBox.classList.add('hidden');
            }
        });

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
