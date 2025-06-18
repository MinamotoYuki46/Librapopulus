<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode Fokus</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen">

    <?php include __DIR__ . '/../layout/layout.php'; ?>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <main id="mainContent">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 mt-2 gap-3">
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white">Mode Fokus</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-start">
                <div class="md:col-span-1">
                    <?php if ($book['book_cover']): ?>
                        <img src="<?= base_url('uploads/bookcover/' . esc($book['book_cover'])) ?>"
                            alt="Cover of <?= esc($book['title']) ?>"
                            class="w-full h-auto object-cover rounded-lg shadow-xl md:sticky md:top-8" 
                            style="max-height: 600px;">
                    <?php else: ?>
                        <div class="w-full bg-gray-300 aspect-[2/3] flex items-center justify-center rounded-lg shadow-xl md:sticky md:top-8" 
                            style="max-height: 600px;">
                            <i class="fas fa-image text-gray-500 text-6xl"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="md:col-span-2">
                    <div class="space-y-6 pb-8">
                        <h1 class="text-3xl lg:text-5xl font-extrabold text-gray-900 dark:text-white">
                            <?= esc($book['title']) ?>
                        </h1>
                        <p class="text-xl lg:text-2xl text-gray-700 dark:text-gray-400">
                            oleh <strong class="font-semibold"><?= esc($book['author']) ?></strong>
                        </p>

                        <div class="my-4 pt-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Progres Membaca</h3>
                            <p id="progress-text" class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                Terbaca: <?= esc($book['read_page']) ?> / <?= esc($book['total_pages']) ?> halaman
                            </p>
                            <?php
                                $currentReadPage = isset($book['read_page']) ? intval($book['read_page']) : 0;
                                $totalPages = intval($book['total_pages']);
                                $progressPercentage = ($totalPages > 0) ? ($currentReadPage / $totalPages) * 100 : 0;
                            ?>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                <div id="progress-bar" class="bg-blue-600 h-2.5 rounded-full" 
                                    style="width: <?= round($progressPercentage, 2) ?>%">
                                </div>
                            </div>
                            
                            <?php 
                            $totalDuration = isset($book['total_read_duration']) ? intval($book['total_read_duration']) : 0;
                            
                            function formatTotalReadingTime($seconds) {
                                $hrs = floor($seconds / 3600);
                                $mins = floor(($seconds % 3600) / 60);
                                $secs = $seconds % 60;
                                
                                $parts = [];
                                if ($hrs > 0) $parts[] = $hrs . ' jam';
                                if ($mins > 0) $parts[] = $mins . ' menit';
                                if ($secs > 0 || empty($parts)) $parts[] = $secs . ' detik'; 
                                
                                return implode(' ', $parts);
                            }

                            function formatTimestampTime($seconds) {
                                $hrs = floor($seconds / 3600);
                                $mins = floor(($seconds % 3600) / 60);
                                $secs = $seconds % 60;
                                
                                return sprintf("%02d:%02d:%02d", $hrs, $mins, $secs);
                            }
                            ?>
                            <?php if ($totalDuration > 0): ?>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-2 flex items-center gap-2">
                                    <i class="far fa-clock text-base"></i>
                                    <span id="total-reading-time-timestamp" class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                        <?= formatTimestampTime($totalDuration) ?>
                                    </span>
                                </p>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div id="focusBox" class="block max-w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 relative text-center">
                        <h2 class="mb-4 text-5xl font-extrabold text-gray-900 dark:text-white" id="timer">00:00:00</h2>

                        <div class="mt-6 flex flex-wrap justify-center gap-3">
                            <button id="startBtn" type="button" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Mulai</button>
                            <button id="pauseBtn" type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:focus:ring-yellow-900">Istirahat</button>
                            <button id="resumeBtn" type="button" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Lanjutkan</button>
                            <button id="endBtn" type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Akhiri</button>
                        </div>

                        <div class="mt-6">
                            <label for="pagesRead" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Halaman terbaca:</label>
                            <input type="number" id="pagesRead" aria-describedby="helper-text-pages" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center mx-auto" min="0" max="<?= $book['total_pages']?>" value="1">
                            <p id="helper-text-pages" class="mt-2 text-sm text-gray-500 dark:text-gray-400">Masukkan jumlah halaman yang kamu baca dalam sesi ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <div id="toast-success" class="hidden fixed bottom-5 right-5 flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <i class="fas fa-check"></i>
            </div>
            <div class="ms-3 text-sm font-normal" id="toast-message">Sesi membaca berhasil disimpan!</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="hideToast()">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l12 12M13 1L1 13"/>
                </svg>
            </button>
        </div>
    </div>
    
</body>
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const masterUsername = '<?= esc($masterUsername, 'js') ?>';
            const bookSlug = '<?= esc($book['slug'], 'js') ?>';
            let csrfToken = '<?= csrf_hash() ?>';

            const initialReadPage = <?= esc($book['read_page']) ?>;
            const totalPages = <?= esc($book['total_pages']) ?>;
            const remainingPages = parseInt(totalPages) - parseInt(initialReadPage);
            const progressText = document.getElementById('progress-text');
            const progressBar = document.getElementById('progress-bar');
            
            const totalReadingTimeTimestampSpan = document.getElementById('total-reading-time-timestamp');

            const timerDisplay = document.getElementById('timer');
            const startBtn = document.getElementById('startBtn');
            const pauseBtn = document.getElementById('pauseBtn');
            const resumeBtn = document.getElementById('resumeBtn');
            const endBtn = document.getElementById('endBtn');
            const pagesReadInput = document.getElementById('pagesRead');

            let elapsedSeconds = 0;
            let intervalId = null;
            let currentTotalDuration = <?= isset($book['total_read_duration']) ? intval($book['total_read_duration']) : 0 ?>;

            pagesReadInput.value = 1;

            function formatTime(seconds) {
                const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
                const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
                const secs = String(seconds % 60).padStart(2, '0');
                return `${hrs}:${mins}:${secs}`;
            }

            function formatTotalReadingTimeJS(seconds) {
                const hrs = Math.floor(seconds / 3600);
                const mins = Math.floor((seconds % 3600) / 60);
                const secs = seconds % 60;
                
                const parts = [];
                if (hrs > 0) parts.push(`${hrs} jam`);
                if (mins > 0) parts.push(`${mins} menit`);
                if (secs > 0 || parts.length === 0) parts.push(`${secs} detik`); 
                
                return parts.join(' ');
            }

            function formatTimestampTimeJS(seconds) {
                const hrs = Math.floor(seconds / 3600);
                const mins = Math.floor((seconds % 3600) / 60);
                const secs = seconds % 60;
                
                return `${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
            }

            function updateTimer() {
                elapsedSeconds++;
                timerDisplay.textContent = formatTime(elapsedSeconds);
            }
            
            function setButtonState(state) {
                startBtn.style.display = (state === 'initial') ? 'inline-flex' : 'none';
                pauseBtn.style.display = (state === 'running') ? 'inline-flex' : 'none';
                resumeBtn.style.display = (state === 'paused') ? 'inline-flex' : 'none';
                endBtn.style.display = (state === 'paused') ? 'inline-flex' : 'none';
                pagesReadInput.disabled = (state === 'running');
            }
            setButtonState('initial');

            function showToast(message) {
                const toast = document.getElementById('toast-success');
                const toastMsg = document.getElementById('toast-message');
                
                toastMsg.textContent = message;
                toast.classList.remove('hidden');

                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 5000);
            }

            function hideToast() {
                const toast = document.getElementById('toast-success');
                toast.classList.add('hidden');
            }


            startBtn.addEventListener('click', () => {
                if (intervalId === null) {
                    intervalId = setInterval(updateTimer, 1000);
                }
                setButtonState('running');
            });

            pauseBtn.addEventListener('click', () => {
                clearInterval(intervalId);
                intervalId = null;
                setButtonState('paused');
            });

            resumeBtn.addEventListener('click', () => {
                if (intervalId === null) {
                    intervalId = setInterval(updateTimer, 1000);
                }
                setButtonState('running');
            });

            endBtn.addEventListener('click', async () => {
                clearInterval(intervalId);
                intervalId = null;
                
                const duration = elapsedSeconds;
                const pagesRead = parseInt(pagesReadInput.value);

                if (isNaN(pagesRead) || pagesRead < 0 || pagesRead > remainingPages) {
                    alert(`Jumlah halaman yang dibaca harus antara 0 dan ${remainingPages}.`);
                    endBtn.disabled = false;
                    endBtn.textContent = 'Akhiri';
                    setButtonState('paused');
                    return;
                }

                const saveUrl = `<?= base_url('/library/' . $masterUsername . '/' . $book['slug'] . '/focus/update') ?>`;

                endBtn.disabled = true;
                endBtn.textContent = 'Menyimpan...';

                try {
                    const response = await fetch(saveUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken 
                        },
                        body: JSON.stringify({
                            duration: duration,
                            pagesRead: pagesRead
                        })
                    });

                    const data = await response.json();

                    console.log('Data yang diterima dari server:', data);

                    if (data.csrf_token) {
                        csrfToken = data.csrf_token;
                    }

                    if (!response.ok) {
                        throw new Error(data.error || 'Terjadi kesalahan server yang tidak diketahui.');
                    }

                    if (data.new_read_page !== undefined) {
                        progressText.textContent = `Terbaca: ${ data.new_read_page} / ${totalPages} halaman`;
                        const newPercentage = (data.new_read_page / totalPages) * 100;
                        progressBar.style.width = `${newPercentage}%`;
                        pagesReadInput.value = data.new_read_page; 
                    }

                    if (data.new_total_duration !== undefined) {
                        currentTotalDuration = data.new_total_duration;
                        if (totalReadingTimeTimestampSpan) {
                            totalReadingTimeTimestampSpan.textContent = formatTimestampTimeJS(currentTotalDuration);
                        }
                    }

                    showToast(`Sesi membaca berhasil disimpan! Durasi: ${formatTime(duration)}, Halaman: ${pagesRead}`);

                    const newToken = data.csrf_token;
                    csrfHash = newToken;

                    const csrfTokenName = '<?= csrf_token() ?>'; 
                    document.querySelectorAll(`input[name="${csrfTokenName}"]`).forEach(input => {
                        input.value = newToken;
                    });

                    console.log('Semua token CSRF di form HTML telah diperbarui.');

                    
                } catch (error) {
                    console.error('Gagal menyimpan sesi:', error);
                    showToast('Gagal menyimpan sesi. Silakan coba lagi.\nError: ' + error.message);
                } finally {
                    elapsedSeconds = 0;
                    timerDisplay.textContent = '00:00:00';
                    pagesReadInput.value = 1;
                    
                    endBtn.disabled = false;
                    endBtn.textContent = 'Akhiri';
                    setButtonState('initial');
                }
            });
        });
    </script>
</html>