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