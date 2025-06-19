<?php

$navigationItems = [
        ['icon' => 'fas fa-book', 'label' => 'Data Buku', 'page' => '/admin/bookdata'],
        ['icon' => 'fas fa-file-alt', 'label' => 'Laporan Pengguna', 'page' => '/admin/userreport']
    ];
?>

<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                </svg>
            </button>
            <div class="flex items-center justify-start rtl:justify-end">
                <a href="<?= base_url("/")?>" class="flex space-x-2 ms-2 md:me-24">
                    <i class="fas fa-book-open text-purple-600 text-4xl"></i>
                    <span class="self-center text-4xl font-bold sm:text-2xl whitespace-nowrap dark:text-white">Admin Librapopulus</span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center space-x-4">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <img class="w-10 h-10 rounded-full ring-2 ring-gray-300 dark:ring-gray-500"  src="<?= !empty($photoProfile) ? base_url("uploads/users/" . $photoProfile) : base_url("uploads/users/default_admin.png") ?>" alt="logged user photo">
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