<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengguna</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
</head>
<body class="bg-gray-50 text-gray-900">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold mb-6">Laporan Pengguna</h1>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-sky-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Judul Buku</th>
                        <th scope="col" class="px-6 py-3">Peminjam</th>
                        <th scope="col" class="px-6 py-3">Pemilik</th>
                        <th scope="col" class="px-6 py-3">Pesan</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reports)): ?>
                        <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada laporan.</td></tr>
                    <?php else: ?>
                        <?php foreach ($reports as $report): ?>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4"><?= esc($report['id']) ?></td>
                                <td class="px-6 py-4"><?= esc($report['book_title']) ?></td>
                                <td class="px-6 py-4"><?= esc($report['borrower_username']) ?></td>
                                <td class="px-6 py-4"><?= esc($report['owner_username']) ?></td>
                                <td class="px-6 py-4"><?= esc($report['message']) ?></td>
                                <td class="px-6 py-4"><?= date('d M Y, H:i', strtotime($report['created_at'])) ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
