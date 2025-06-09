<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mode Fokus</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="relative overflow-x-hidden">

    <?php include __DIR__ . '/../layout/header.php'; ?>

    <main class="px-6 py-6" id="mainContent">
        <div class="max-w-screen-3xl mx-auto px-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 mt-2 gap-3">
                <h2 class="text-6xl font-bold text-gray-900">Mode Fokus</h2>
            </div>
        </div>

        <div class="flex flex-col md:flex-row gap-x-6 lg:gap-x-8 relative">
            <div class="w-full md:w-2/5 lg:w-1/3 mb-6">
                <img src="<?= base_url('uploads/bookcover/' . esc(  $book['book_cover'])) ?>"
                    alt="Cover of <?= esc($book['title']) ?>"
                    class="w-full h-auto object-cover rounded-lg shadow-xl sticky top-6 max-h-[800px]">
            </div>

            <div class="w-full md:w-3/5 lg:w-2/3">
                <div class="space-y-5 md:max-h-[calc(100vh-8rem)] overflow-y-auto scrollbar-hide pr-2 pb-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900"><?= esc($book['title']) ?></h1>
                    <p class="text-lg lg:text-xl text-gray-700">oleh <strong><?= esc($book['author']) ?></strong></p>

                    <div class="my-4 pt-2">
                        <h3 class="text-md font-semibold text-gray-800 mb-1">Progres Membaca</h3>
                        <p id="progress-text" class="text-sm text-gray-600">
                            Terbaca: <?= esc($book['read_page']) ?> / <?= esc($book['total_pages']) ?> halaman
                        </p>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2.5">
                            <div id="progress-bar" class="bg-sky-600 h-2.5 rounded-full" 
                                style="width: <?= round($book['read_page'] / $book['total_pages'] * 100, 2) ?>%">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Focus Area -->
                <div id="focusBox" class="bg-gray-100 w-full p-6 rounded-xl shadow-inner text-center relative">
                    <h2 class="text-6xl font-bold" id="timer">00:00:00</h2>

                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <button id="startBtn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Mulai</button>
                        <button id="pauseBtn" class="px-4 py-2 bg-yellow-400 text-white rounded-md hover:bg-yellow-500">Istirahat</button>
                        <button id="resumeBtn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Lanjutkan</button>
                        <button id="endBtn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Akhiri</button>
                    </div>

                    <div class="mt-6">
                        <label for="pagesRead" class="block text-sm font-medium text-gray-700">Halaman terbaca:</label>
                        <input type="number" id="pagesRead" class="mt-1 w-24 text-center border border-gray-300 rounded-md p-2" min="0" max="<?= $book['total_pages']?>" value="1">
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const username = '<?= esc($username, 'js') ?>'; 
            const bookSlug = '<?= esc($book['slug'], 'js') ?>';
            let csrfToken = '<?= csrf_hash() ?>';

            const totalPages = <?= $book['total_pages'] ?>;
            const progressText = document.getElementById('progress-text');
            const progressBar = document.getElementById('progress-bar');

            const timerDisplay = document.getElementById('timer');
            const startBtn = document.getElementById('startBtn');
            const pauseBtn = document.getElementById('pauseBtn');
            const resumeBtn = document.getElementById('resumeBtn');
            const endBtn = document.getElementById('endBtn');
            const pagesReadInput = document.getElementById('pagesRead');

            let elapsedSeconds = 0;
            let intervalId = null;

            function formatTime(seconds) {
                const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
                const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
                const secs = String(seconds % 60).padStart(2, '0');
                return `${hrs}:${mins}:${secs}`;
            }

            function updateTimer() {
                elapsedSeconds++;
                timerDisplay.textContent = formatTime(elapsedSeconds);
            }
            
            function setButtonState(state) {
                startBtn.style.display = (state === 'initial') ? 'inline-block' : 'none';
                pauseBtn.style.display = (state === 'running') ? 'inline-block' : 'none';
                resumeBtn.style.display = (state === 'paused') ? 'inline-block' : 'none';
                endBtn.style.display = (state === 'paused') ? 'inline-block' : 'none';
            }
            setButtonState('initial');

            startBtn.addEventListener('click', () => {
                intervalId = setInterval(updateTimer, 1000);
                setButtonState('running');
            });

            pauseBtn.addEventListener('click', () => {
                clearInterval(intervalId);
                setButtonState('paused');
            });

            resumeBtn.addEventListener('click', () => {
                intervalId = setInterval(updateTimer, 1000);
                setButtonState('running');
            });

            endBtn.addEventListener('click', async () => {
                clearInterval(intervalId);
                
                const duration = elapsedSeconds;
                const pagesRead = pagesReadInput.value;

                const saveUrl = `<?= base_url('/library/' . $username . '/' . $book['slug'] . '/focus/update') ?>`;

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
                        throw new Error(data.error || 'An unknown server error occurred.');
                    }

                    if (data.new_read_page !== undefined) {
                        progressText.textContent = `Terbaca: ${ data.new_read_page} / ${totalPages} halaman`;

                        const newPercentage = (data.new_read_page / totalPages) * 100;

                        progressBar.style.width = `${newPercentage}%`;
                    }

                    alert(`Sesi membaca berhasil disimpan!\nDurasi: ${formatTime(duration)}\nHalaman terbaca: ${pagesRead}`);
                    
                } catch (error) {
                    console.error('Failed to save session:', error);
                    alert('Gagal menyimpan sesi. Silakan coba lagi.\nError: ' + error.message);
                } finally {
                    
                    elapsedSeconds = 0;
                    timerDisplay.textContent = '00:00:00';
                    pagesReadInput.value = '1';
                    
                    // Reset the button
                    endBtn.disabled = false;
                    endBtn.textContent = 'Akhiri';
                    setButtonState('initial');
                }
            });
        });
    </script>
    <?php include __DIR__ . '/../layout/navbar.php'; ?>
</body>
</html>