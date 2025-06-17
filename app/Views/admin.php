<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengguna</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
</head>
<body class="bg-gray-200 min-h-screen min-v-screen">

    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <a href="<?= base_url("/")?>" class="flex space-x-2 ms-2 md:me-24">
                        <i class="fas fa-book-open text-purple-600 text-4xl"></i>
                        <span class="self-center text-4xl font-bold sm:text-2xl whitespace-nowrap dark:text-white">Librapopulus</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center space-x-4">
                        <div>
                            <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <img class="w-10 h-10 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"  src="<?= !empty($photoProfile) ? base_url("uploads/" . $photoProfile) : base_url("assets/images/default_admin.png") ?>" alt="logged user photo">
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm font-bold text-gray-900 dark:text-white" role="none">
                                    @<?= $masterUsername ?>
                                </p>
                                <p class="text-sm text-gray-900 truncate dark:text-gray-300" role="none">
                                    <?= $masterFullname ?>
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <form action="<?= base_url('auth/logout') ?>" method="POST" class="w-full">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" 
                                                class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 cursor-pointer whitespace-nowrap"
                                                style="background: none; border: none;">
                                            <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-10" id="mainContent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold mb-6">Laporan Pengguna</h1>

            <div class="flex justify-end mb-4">
                <div class="relative inline-block text-left">
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
                                <a href="<?= base_url('admin/report/export-excel') ?>" 
                                    class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <i class="fas fa-file-excel mr-2 text-green-600"></i> Excel
                                </a>
                            </li>
                            <li>
                                <a href="<?= base_url('admin/report/export-pdf') ?>" 
                                    class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <i class="fas fa-file-pdf mr-2 text-red-600"></i> PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-white uppercase bg-sky-600">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Judul Buku</th>
                            <th scope="col" class="px-6 py-3">Email Peminjam</th>
                            <th scope="col" class="px-6 py-3">Email Pemilik</th>
                            <th scope="col" class="px-6 py-3">Keterangan</th>
                            <th scope="col" class="px-6 py-3">Tanggal Laporan</th>
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
                                    <td class="px-6 py-4"><?= esc($report['borrower_email']) ?></td>
                                    <td class="px-6 py-4"><?= esc($report['owner_email']) ?></td>
                                    <td class="px-6 py-4"><?= esc($report['message']) ?></td>
                                    <td class="px-6 py-4"><?= date('d M Y, H:i', strtotime($report['created_at'])) ?></td>
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
