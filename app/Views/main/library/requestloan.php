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
    </style>
</head>
<body class="relative overflow-x-hidden">

<?php include __DIR__ . '/../layout/layout.php'; ?>

<main id="mainContent">
    <div class="px-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-3">
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
                <?= ($activeLoan && $activeLoan['status'] == \App\Models\BookLoanModel::STATUS_PENDING) ? 'Status Permintaan Peminjaman' : 'Ajukan Peminjaman Buku' ?>
            </h2>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-6 lg:gap-8 relative bg-white p-6 rounded-lg shadow-xl">
        <div class="w-full md:w-2/5 lg:w-1/3 mb-6 md:mb-0 sticky-image">
            <img src="<?= base_url('uploads/bookcover/' . esc($book['book_cover'])) ?>"
                alt="Cover of <?= esc($book['title']) ?>"
                class="w-full h-auto object-cover rounded-lg shadow-lg max-h-[800px]">
        </div>

        <div class="w-full md:w-3/5 lg:w-2/3">
            <div class="space-y-6">
                <h1 class="text-3xl lg:text-4xl font-bold text-gray-900"><?= esc($book['title']) ?></h1>
                <p class="text-lg lg:text-xl text-gray-700">oleh <span class="font-semibold text-gray-800"><?= esc($book['author']) ?></span></p>
                <hr class="border-gray-200">

                <?php if ($activeLoan): ?>

                    <?php if ($activeLoan['status'] == \App\Models\BookLoanModel::STATUS_PENDING): ?>
                        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-5 rounded-lg mt-6 shadow-md" role="alert">
                            <div class="flex items-center mb-2">
                                <i class="fa-solid fa-hourglass-half text-2xl mr-3"></i>
                                <p class="font-bold text-xl">Permintaan Peminjaman Dikirim!</p>
                            </div>
                            <p class="text-base">Anda telah mengajukan peminjaman buku ini pada tanggal <?= date('d M Y', strtotime($activeLoan['loan_start_date'])) ?> hingga <?= date('d M Y', strtotime($activeLoan['loan_end_date'])) ?>.</p>
                            <p class="text-base mt-1">Mohon tunggu persetujuan dari <?= esc($owner['username']) ?>. Anda akan menerima notifikasi setelah status berubah.</p>
                        </div>
                        <div class="flex justify-start gap-4 pt-4">
                            <form action="<?= site_url('/library/loan/cancel/' . $activeLoan['id']) ?>" method="POST">
                                <?= csrf_field() ?>
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition duration-200 ease-in-out shadow-md">
                                    <i class="fa-solid fa-xmark mr-2"></i> Batalkan Permintaan
                                </button>
                            </form>
                        </div>

                    <?php elseif ($activeLoan['status'] == \App\Models\BookLoanModel::STATUS_APPROVED): ?>
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-lg mt-6 shadow-md" role="alert">
                            <div class="flex items-center mb-2">
                                <i class="fa-solid fa-circle-check text-2xl mr-3"></i>
                                <p class="font-bold text-xl">Peminjaman Telah Disetujui!</p>
                            </div>
                            <p class="text-base">Peminjaman buku ini telah disetujui oleh <?= esc($owner['username']) ?>.</p>
                            <p class="text-base mt-1">Periode peminjaman Anda adalah dari tanggal <?= date('d M Y', strtotime($activeLoan['loan_start_date'])) ?> hingga <?= date('d M Y', strtotime($activeLoan['loan_end_date'])) ?>.</p>
                            <p class="text-base mt-1">Silakan hubungi <?= esc($owner['username']) ?> untuk mengatur pengambilan buku.</p>
                        </div>

                    <?php elseif ($activeLoan['status'] == \App\Models\BookLoanModel::STATUS_DECLINED): ?>
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-5 rounded-lg mt-6 shadow-md" role="alert">
                            <div class="flex items-center mb-2">
                                <i class="fa-solid fa-circle-xmark text-2xl mr-3"></i>
                                <p class="font-bold text-xl">Peminjaman Ditolak</p>
                            </div>
                            <p class="text-base">Maaf, permintaan peminjaman buku ini telah ditolak oleh <?= esc($owner['username']) ?>.</p>
                            <p class="text-base mt-1">Silakan hubungi pemilik buku untuk informasi lebih lanjut atau coba ajukan kembali nanti.</p>
                        </div>

                    <?php elseif ($activeLoan['status'] == \App\Models\BookLoanModel::STATUS_APPROVED): ?>
                         <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-5 rounded-lg mt-6 shadow-md" role="alert">
                            <div class="flex items-center mb-2">
                                <i class="fa-solid fa-book-open-reader text-2xl mr-3"></i>
                                <p class="font-bold text-xl">Buku Sedang Anda Pinjam</p>
                            </div>
                            <p class="text-base">Anda sedang meminjam buku ini. Periode peminjaman Anda adalah dari tanggal <?= date('d M Y', strtotime($activeLoan['loan_start_date'])) ?> hingga <?= date('d M Y', strtotime($activeLoan['loan_end_date'])) ?>.</p>
                            <p class="text-base mt-1">Jangan lupa mengembalikan buku tepat waktu!</p>
                            <div class="flex justify-start gap-3 mt-4">
                                <button type="button" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition duration-200 ease-in-out shadow-md">
                                    <i class="fa-solid fa-calendar-plus mr-2"></i> Ajukan Perpanjangan
                                </button>
                                <button type="button" class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition duration-200 ease-in-out shadow-md">
                                    <i class="fa-solid fa-check-double mr-2"></i> Tandai Sudah Dikembalikan
                                </button>
                            </div>
                        </div>

                    <?php endif; ?>

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
                            <label for="start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai Peminjaman</label>
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="start_date" name="start_date" value="<?= esc($date_now) ?>" required datepicker datepicker-buttons datepicker datepicker-format="dd-mm-yyyy"  datepicker-autoselect-today type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pilih tanggal mulai">
                            </div>
                        </div>

                        <div>
                            <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai Peminjaman</label>
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="end_date" name="end_date" required datepicker datepicker-buttons datepicker datepicker-format="dd-mm-yyyy"  datepicker-autoselect-today type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pilih tanggal selesai">
                            </div>
                        </div>

                        <div class="flex justify-start gap-4 pt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-700 hover:bg-blue-800 border border-transparent rounded-lg font-semibold text-base text-white hover:bg-sky-700 transition duration-200 ease-in-out shadow-md">
                                <i class="fa-solid fa-paper-plane mr-2"></i> Ajukan Peminjaman
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
                <a href="<?= base_url('/library/' . $owner["username"] . '/' . $book["slug"]) ?>" class="inline-flex items-center px-5 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-gray-300 transition duration-200 ease-in-out shadow-md mt-6">
                    <i class="fa fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</main>

<script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>