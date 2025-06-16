<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku Pinjaman</title>

    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        body {
            background-color: #f0f2f5; /* Light grey background similar to Instagram */
        }
        /* Styles for centered content, similar to Instagram */
        #mainContent {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            margin: 0 auto; /* Ensure horizontal centering */
            max-width: 935px; /* Instagram-like max width for the wrapper */
        }
        .main-content-area {
            width: 100%; /* Take full width of its parent (#mainContent) */
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            overflow: hidden;
        }
        .tab-content-section {
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../layout/layout.php'; ?>
    <main id="mainContent" class="container mx-auto px-4 sm:px-6 lg:px-8 py-10"> 
        <div class="main-content-area">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center tab-flex-wrap" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="requests-tab" data-tabs-target="#requests" type="button" role="tab" aria-controls="requests" aria-selected="false">Permintaan Peminjaman</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="lent-out-tab" data-tabs-target="#lent-out" type="button" role="tab" aria-controls="lent-out" aria-selected="false">Buku Dipinjamkan</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="history-lender-tab" data-tabs-target="#history-lender" type="button" role="tab" aria-controls="history-lender" aria-selected="false">Riwayat Pinjaman</button>
                    </li>
                </ul>
            </div>

            <div id="default-tab-content">
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tab-content-section" id="requests" role="tabpanel" aria-labelledby="requests-tab">
                    <h3 class="text-lg font-bold mb-4">Permintaan Peminjaman Buku</h3>
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4">
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">The Great Gatsby</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Diminta oleh: John Doe</p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Tanggal Permintaan: 15 Juni 2025</p>
                            <button type="button" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Setuju</button>
                            <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Tolak</button>
                        </div>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-center">Belum ada permintaan peminjaman baru dari pengguna.</p>
                </div>

                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tab-content-section" id="lent-out" role="tabpanel" aria-labelledby="lent-out-tab">
                    <h3 class="text-lg font-bold mb-4">Buku Dipinjamkan</h3>
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4">
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">1984</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Peminjam: Jane Smith</p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Tanggal Pinjam: 1 Juni 2025</p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Jatuh Tempo: 14 Juni 2025</p>
                            <button type="button" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Tandai Dikembalikan</button>
                        </div>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-center">Tidak ada buku yang sedang dipinjamkan.</p>
                </div>

                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tab-content-section" id="history-lender" role="tabpanel" aria-labelledby="history-lender-tab">
                    <h3 class="text-lg font-bold mb-4">Riwayat Pinjaman</h3>
                    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4">
                        <div class="p-5">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">To Kill a Mockingbird</h5>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Peminjam: Bob Johnson</p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Tanggal Pinjam: 10 Mei 2025</p>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Tanggal Kembali: 25 Mei 2025</p>
                        </div>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400 text-center">Belum ada riwayat peminjaman.</p>
                </div>



            </div>
        </div>
    </main>
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
    </body>
</html>