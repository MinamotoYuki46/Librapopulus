<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Import Data Buku</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100 min-h-screen">
    <?= include 'layout.php' ?>

    <div class="h-20"></div>

    <div class="max-w-2xl mx-auto bg-white shadow p-6 rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Import Buku dari Excel</h2>

        <div class="mb-4">
            <a href="<?= base_url('assets/template/import_book_template.xlsx') ?>" 
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                <i class="fa-solid fa-download mr-2"></i> Unduh Template Excel
            </a>
        </div>


        <?php if (session()->has('message')): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                <?= session('message') ?>
            </div>
        <?php endif ?>
        <?php if (session()->has('error')): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <?= session('error') ?>
            </div>
        <?php endif ?>

        <form action="<?= base_url('admin/book-data/importExcel') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="mb-4">
                <label for="excel_file" class="block mb-2 font-medium">Pilih file Excel</label>
                <input type="file" name="excel_file" accept=".xls,.xlsx" required class="border rounded w-full p-2">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-sky-700">
                Impor
            </button>

            <a href="<?= base_url('admin/bookdata') ?>" 
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                Batal
            </a>
        </form>
    </div>
</body>
<script src="<?= base_url("flowbite.min.js") ?>"></script>
</html>
