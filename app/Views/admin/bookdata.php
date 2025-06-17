<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Buku</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
</head>
<body class="bg-gray-200 min-h-screen">
    <?= include 'layout.php'?>

    <main class="w-full max-w-screen-2xl mx-auto px-6 py-10" id="mainContent">
        <div class="w-full px-6 py-8">

            <h1 class="text-3xl font-bold mb-6">Data Buku</h1>

            
            <div class="flex justify-end mb-4">
                <a href="<?= base_url('admin/bookdata/add') ?>"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition mr-3">
                    <i class="fas fa-plus mr-2"></i> Tambah Buku
                </a>

                <div class="relative inline-block text-left px-5">
                    <button id="printDropdownButton" data-dropdown-toggle="printDropdown" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-print mr-2"></i> Cetak
                        <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" 
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div id="printDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="printDropdownButton">
                            <li>
                                <a href="<?= base_url('admin/book-data/export-excel') ?>" 
                                    class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <i class="fas fa-file-excel mr-2 text-green-600"></i> Excel
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/book-data/export-pdf') ?>" 
                                    class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <i class="fas fa-file-pdf mr-2 text-red-600"></i> PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <a href="<?= base_url('admin/book-data/importExcelForm') ?>" 
                    class="inline-flex items-center px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition">
                    <i class="fas fa-upload mr-2"></i> Import Excel
                </a>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-white uppercase bg-sky-600">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Judul</th>
                            <th class="px-6 py-3">Penulis</th>
                            <th class="px-6 py-3">Tanggal Terbit</th>
                            <th class="px-6 py-3">Total Halaman</th>
                            <th class="px-6 py-3">Deskripsi</th>
                            <th class="px-6 py-3">Genre</th>
                            <th class="px-6 py-3">Cover</th>
                            <th class="px-6 py-3">Ditambahkan</th>
                            <th class="px-6 py-3">Diubah</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($books)): ?>
                            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data buku.</td></tr>
                        <?php else: ?>
                            <?php foreach ($books as $book): ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4"><?= esc($book['id']) ?></td>
                                    <td class="px-6 py-4"><?= esc($book['title']) ?></td>
                                    <td class="px-6 py-4"><?= esc($book['author']) ?></td>
                                    <td class="px-6 py-4"><?= date('d M Y', strtotime($book['published_date'])) ?></td>
                                    <td class="px-6 py-4"><?= esc($book['total_pages']) ?></td>
                                    <td class="px-6 py-4"><?= esc($book['description']) ?></td>
                                    <td class="px-6 py-4">
                                        <?php 
                                            $genres = array_map('trim', explode(',', $book['genres'] ?? ''));
                                            foreach ($genres as $i => $genre): ?>
                                                <?= esc($genre) ?><?= $i < count($genres) - 1 ? ', ' : '' ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if (!empty($book['book_cover'])): ?>
                                            <img src="<?= base_url('uploads/bookcover/' . $book['book_cover']) ?>" alt="Cover" class="w-16 h-24 object-cover rounded">
                                        <?php else: ?>
                                            <span class="text-gray-400 italic">Tidak ada</span>
                                        <?php endif ?>
                                    </td>
                                    <td class="px-6 py-4"><?= date('d M Y H:i', strtotime($book['created_at'])) ?></td>
                                    <td class="px-6 py-4"><?= date('d M Y H:i', strtotime($book['updated_at'])) ?></td>
                                    <td class="px-6 py-4 flex gap-2">
                                        <a href="<?= base_url('admin/bookdata/edit/' . $book['id']) ?>"
                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-400 text-white text-xs font-medium rounded hover:bg-yellow-500 transition">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="<?= base_url('admin/bookdata/delete/' . $book['id']) ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700 transition">
                                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
