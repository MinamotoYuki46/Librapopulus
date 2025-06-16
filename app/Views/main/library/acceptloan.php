<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman</title>

    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        body {
            background-color: #f0f2f5;
        }
        #mainContent {
            padding: 2.5rem 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        @media (min-width: 768px) {
            .sticky-image {
                position: sticky;
                top: 2rem;
                align-self: flex-start;
            }
        }
        /* New style for static display fields to mimic Flowbite input look */
        .static-field-display {
            background-color: #f9fafb; /* bg-gray-50 */
            border: 1px solid #e5e7eb; /* border-gray-300 */
            color: #111827; /* text-gray-900 */
            font-size: 0.875rem; /* text-sm */
            line-height: 1.25rem; /* text-sm */
            border-radius: 0.5rem; /* rounded-lg */
            display: block;
            width: 100%;
            padding: 0.625rem 1rem; /* p-2.5, px-4 */
            font-weight: 700; /* font-bold */
        }
        .dark .static-field-display {
            background-color: #374151; /* dark:bg-gray-700 */
            border-color: #4b5563; /* dark:border-gray-600 */
            color: #f9fafb; /* dark:text-white */
        }
    </style>
</head>
<body class="relative overflow-x-hidden">

<?php include __DIR__ . '/../layout/layout.php'; ?>

<main id="mainContent">
    <div class="px-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-3">
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
                <?= ($loan['status'] ?? null) ? 'Detail Peminjaman' : 'Pengajuan Peminjaman Buku' ?>
            </h2>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-6 lg:gap-8 relative bg-white p-6 rounded-lg shadow-xl">
        <div class="w-full md:w-2/5 lg:w-1/3 mb-6 md:mb-0 sticky-image">
            <img src="<?= base_url('uploads/bookcover/' . esc($loan['book_cover'] ?? 'default.jpg')) ?>"
                alt="Cover of <?= esc($loan['book_title'] ?? 'Book') ?>"
                class="w-full h-auto object-cover rounded-lg shadow-lg max-h-[800px]">
        </div>

        <div class="w-full md:w-3/5 lg:w-2/3">
            <div class="space-y-6">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900"><?= esc($loan['book_title'] ?? 'Judul Buku Tidak Tersedia') ?></h1>
                <p class="text-lg lg:text-xl text-gray-700">oleh <span class="font-semibold text-gray-800"><?= esc($loan['book_author'] ?? 'Penulis Tidak Tersedia') ?></span></p>
                <hr class="border-gray-200">

                <?php
                if (isset($loan['status'])):
                ?>
                    <div class="space-y-4 pt-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dari</label>
                            <p class="static-field-display"><?= esc($loan['borrower_name']) ?></p>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kepada</label>
                            <p class="static-field-display"><?= esc($loan['owner_name']) ?></p>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai</label>
                            <p class="static-field-display"><?= date('d F Y', strtotime($loan['loan_start_date'])) ?></p>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai</label>
                            <p class="static-field-display"><?= date('d F Y', strtotime($loan['loan_end_date'])) ?></p>
                        </div>
                    </div>

                    <div class="flex justify-start items-center flex-wrap gap-4 pt-8">
                        <?php
                        switch ($loan['status']):
                            case \App\Models\BookLoanModel::STATUS_PENDING:
                        ?>
                                <form action="<?= base_url('library/loan/approve/' . $loan['id']) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition duration-200 ease-in-out shadow-md">
                                        <i class="fa-solid fa-check mr-2"></i> Terima
                                    </button>
                                </form>
                                <form action="<?= base_url('library/loan/decline/' . $loan['id']) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition duration-200 ease-in-out shadow-md">
                                        <i class="fa-solid fa-xmark mr-2"></i> Tolak
                                    </button>
                                </form>
                        <?php
                                break;

                            case \App\Models\BookLoanModel::STATUS_APPROVED:
                        ?>
                                <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-md shadow-md" role="alert">
                                    <div class="flex items-center mb-2">
                                        <i class="fa-solid fa-circle-check text-xl mr-3"></i>
                                        <p class="font-bold">Peminjaman Disetujui!</p>
                                    </div>
                                    <p class="text-sm">Buku ini sedang dipinjam oleh <?= esc($loan['borrower_name']) ?> hingga <?= date('d M Y', strtotime($loan['loan_end_date'])) ?>.</p>
                                </div>
                                <form action="<?= base_url('library/loan/return/' . $loan['id']) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 font-medium transition duration-200 ease-in-out shadow-md">
                                        <i class="fa-solid fa-check-double mr-2"></i> Tandai Sudah Kembali
                                    </button>
                                </form>
                        <?php
                                break;

                            case \App\Models\BookLoanModel::STATUS_DECLINED:
                        ?>
                                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-md shadow-md" role="alert">
                                    <div class="flex items-center mb-2">
                                        <i class="fa-solid fa-circle-xmark text-xl mr-3"></i>
                                        <p class="font-bold">Peminjaman Ditolak</p>
                                    </div>
                                    <p class="text-sm">Permintaan peminjaman ini telah ditolak.</p>
                                </div>
                        <?php
                                break;

                            case \App\Models\BookLoanModel::STATUS_RETURNED:
                        ?>
                                <div class="bg-gray-100 border-l-4 border-gray-400 text-gray-800 p-4 rounded-md shadow-md" role="alert">
                                    <div class="flex items-center mb-2">
                                        <i class="fa-solid fa-book-bookmark text-xl mr-3"></i>
                                        <p class="font-bold">Telah Dikembalikan</p>
                                    </div>
                                    <p class="text-sm">Buku ini telah berhasil dikembalikan pada <?= date('d F Y', strtotime($loan['returned_at'])) ?>.</p>
                                </div>
                        <?php
                                break;
                        endswitch;
                        ?>

                    </div>

                <?php else: ?>
                    <form action="<?= base_url('library/loan/request') ?>" method="POST" class="space-y-6 pt-6">
                        <?= csrf_field() ?>
                        <input type="hidden" name="book_collection_id" value="<?= esc($book['collection_id']) ?>">
                        <input type="hidden" name="owner_id" value="<?= esc($owner['id']) ?>">

                        <div>
                            <label for="from_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dari</label>
                            <input type="text" id="from_user" name="from_user" value="<?= esc($currentUser["username"]) ?>" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Peminjam">
                        </div>

                        <div>
                            <label for="to_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kepada</label>
                            <input type="text" id="to_user" name="to_user" value="<?= esc($owner["username"]) ?>" readonly class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama Pemilik Buku">
                        </div>

                        <div>
                            <label for="start_date_datepicker" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai Peminjaman</label>
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8H3a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm10 0h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm-5 0h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm5 5H3a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm10 0h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm-5 0h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                </div>
                                <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd"
                                       datepicker-min-date="<?= date('Y-m-d') ?>" type="text"
                                       id="start_date_datepicker" name="start_date"
                                       value="<?= esc($date_now) ?>" required
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="Pilih Tanggal Mulai">
                            </div>
                        </div>

                        <div>
                            <label for="end_date_datepicker" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai Peminjaman</label>
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8H3a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm10 0h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm-5 0h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm5 5H3a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm10 0h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm-5 0h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                </div>
                                <input datepicker datepicker-autohide datepicker-format="yyyy-mm-dd"
                                       datepicker-min-date="<?= date('Y-m-d', strtotime('+1 day')) ?>" type="text"
                                       id="end_date_datepicker" name="end_date" required
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="Pilih Tanggal Selesai">
                            </div>
                        </div>

                        <div class="flex justify-start gap-4 pt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-700 hover:bg-blue-800 border border-transparent rounded-lg font-semibold text-base text-white transition duration-200 ease-in-out shadow-md">
                                <i class="fa-solid fa-paper-plane mr-2"></i> Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
                <a href="<?= base_url('/library') ?>" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition duration-200 ease-in-out shadow-md mt-6">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</main>

<script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>