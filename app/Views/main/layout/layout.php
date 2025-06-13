<?php

function timeElapsed($timestamp){
    $diff = time() - $timestamp;
    if ($diff < 60) return $diff . ' detik yang lalu';
    if ($diff < 3600) return floor($diff / 60) . ' menit yang lalu';
    if ($diff < 86400) return floor($diff / 3600) . ' jam yang lalu';
    return floor($diff / 86400) . ' hari yang lalu';
}

$navigationItems = [
        ['icon' => 'fas fa-book', 'label' => 'Katalog', 'page' => '/library'],
        ['icon' => 'fas fa-search', 'label' => 'Cari', 'page' => '/search'],
        ['icon' => 'fas fa-users', 'label' => 'Komunitas', 'page' => '/community'],
        ['icon' => 'fas fa-user', 'label' => 'Profil', 'page' => '/profile/' . $masterUsername],
    ];
?>

<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <a href="<?= base_url("/")?>" class="flex space-x-2 ms-2 md:me-24">
                    <i class="fas fa-book-open text-purple-600 text-4xl"></i>
                    <span class="self-center text-4xl font-bold sm:text-2xl whitespace-nowrap dark:text-white">Librapopulus</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center space-x-4">
                    <button id="notificationBtn" type="button" class="relative inline-flex items-center p-3 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                            <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z"/>
                            <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z"/>
                        </svg>
                        <?php if($notificationCount > 0): ?>
                        <div class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900"><?= $notificationCount ?></div>
                        <?php endif; ?>
                    </button>
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <img class="w-10 h-10 rounded-full ring-2 ring-gray-300 dark:ring-gray-500" src="<?= base_url("uploads/" . $photoProfile) ?>" alt="logged user photo">
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
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Koleksi Buku</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Profil</a>
                            </li>
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

<div id="notificationOverlay" class="fixed inset-0 bg-white/90 backdrop-blur-md z-40 hidden overflow-y-auto">
    <div class="max-w-2xl mx-auto py-25 px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 pt-10">Notifikasi</h1>

        <div id="notificationContent" class="space-y-4">
            <?php include __DIR__ . '/../components/notification_cards.php'; ?>
        </div>
    </div>
</div>

<div class="h-[88px]"></div>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <?php foreach ($navigationItems as $item): ?>
                <li>
                    <a href="<?= base_url( $item['page']) ?>"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <i class="<?= $item['icon'] ?> text-lg shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20"></i>
                        <span class="flex-1 ms-3 whitespace-nowrap"><?= $item['label'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>


<script>
    function toggleNotifications(event) {
        event?.stopPropagation();
        const overlay = document.getElementById('notificationOverlay');
        if (overlay) {
            overlay.classList.toggle('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationOverlay = document.getElementById('notificationOverlay');

        const csrfHeaderName = '<?= csrf_header() ?>';
        let csrfHash = '<?= csrf_hash() ?>';

        notificationBtn.addEventListener('click', async function (event) {
            event.stopPropagation();
            console.log('Notifications clicked');
            const isHidden = notificationOverlay.classList.toggle('hidden');


            if (!isHidden){
                const payload = {}; 
                
                try {
                    const response = await fetch("<?= base_url('notification/mark-read') ?>", {
                        method: "POST",
                        headers: {
                            [csrfHeaderName]: csrfHash,
                            "Content-Type": "application/x-www-form-urlencoded",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        body: new URLSearchParams(payload)
                    });
                    
                    console.log("fetch done, status:", response.status);
                    const data = await response.json();

                    const newToken = data.csrf_token;
                    csrfHash = newToken;

                    const csrfTokenName = '<?= csrf_token() ?>'; 
                    document.querySelectorAll(`input[name="${csrfTokenName}"]`).forEach(input => {
                        input.value = newToken;
                    });
                    
                    console.log('Semua token CSRF di form HTML telah diperbarui.');
                    
                    if (response.ok && data.success){
                        console.log("Notifikasi telah dibaca");
                        
                        const badge = notificationBtn.querySelector("div");
                        if (badge) badge.remove();
                    } else {
                        console.error("Gagal menandai notifikasi");
                    }
                
                } catch (error) {
                    console.error("Gagal fetch", error);
                }
            }
        });



        document.addEventListener('click', function (e) {
            if (!notificationOverlay.contains(e.target) && !notificationBtn.contains(e.target)) {
                notificationOverlay.classList.add('hidden');
            }
        });
    });

</script>