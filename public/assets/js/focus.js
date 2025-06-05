document.addEventListener('DOMContentLoaded', () => {
    let timer = document.getElementById('timer');
    let startBtn = document.querySelector('button.bg-green-500');
    let pauseBtn = document.querySelector('button.bg-yellow-400');
    let continueBtn = document.querySelector('button.bg-blue-500');
    let endBtn = document.querySelector('button.bg-red-500');

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
        timer.textContent = formatTime(elapsedSeconds);
    }

    startBtn.style.display = 'inline-block';
    pauseBtn.style.display = 'none';
    continueBtn.style.display = 'none';
    endBtn.style.display = 'none';

    startBtn.addEventListener('click', () => {
        intervalId = setInterval(updateTimer, 1000);
        startBtn.style.display = 'none';
        pauseBtn.style.display = 'inline-block';
        continueBtn.style.display = 'none';
        endBtn.style.display = 'none';
    });

    pauseBtn.addEventListener('click', () => {
        clearInterval(intervalId);
        pauseBtn.style.display = 'none';
        continueBtn.style.display = 'inline-block';
        endBtn.style.display = 'inline-block';
    });

    continueBtn.addEventListener('click', () => {
        intervalId = setInterval(updateTimer, 1000);
        continueBtn.style.display = 'none';
        endBtn.style.display = 'none';
        pauseBtn.style.display = 'inline-block';
    });

    endBtn.addEventListener('click', () => {
        clearInterval(intervalId);
        alert(`Session ended.\nDuration: ${formatTime(elapsedSeconds)}\nPages Read: ${document.getElementById('pagesRead').value}`);

        elapsedSeconds = 0;
        timer.textContent = '00:00:00';
        startBtn.style.display = 'inline-block';
        pauseBtn.style.display = 'none';
        continueBtn.style.display = 'none';
        endBtn.style.display = 'none';
        document.getElementById('pagesRead').value = '';
    });
});
