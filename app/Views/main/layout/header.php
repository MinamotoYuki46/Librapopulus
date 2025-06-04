<header class="bg-gray-200 px-6 py-4 flex justify-between items-center md:pl-20 bg-white">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">
            <?= $headerTitle ?? 'Librapopulus' ?>
        </h1>
    </div>
    <div class="flex items-center space-x-4">
        <button class="p-2 hover:bg-gray-300 rounded-lg transition-colors relative" onclick="handleNotifications()">
            <i class="fas fa-bell text-gray-700 text-4xl"></i>
            <?php 
            $notificationCount = $notificationCount ?? 3;
            if ($notificationCount > 0): 
            ?>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                    <?= $notificationCount > 9 ? '9+' : $notificationCount ?>
                </span>
            <?php endif; ?>
        </button>
        <button class="p-2 hover:bg-gray-300 rounded-lg transition-colors" onclick="handleProfile()">
            <i class="fas fa-user-circle text-gray-700 text-4xl"></i>
        </button>
    </div>
</header>