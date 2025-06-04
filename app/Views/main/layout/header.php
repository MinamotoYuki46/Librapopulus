<header class="bg-gray-200 px-6 py-4 flex justify-between items-center md:pl-20 bg-white relative z-40">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">
            <?= $headerTitle ?? 'Librapopulus' ?>
        </h1>
    </div>
    <div class="flex items-center space-x-4 relative">
        <!-- Notification Button -->
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

        <!-- Profile Button -->
        <div class="relative">
            <button id="profileBtn" class="p-2 hover:bg-gray-300 rounded-lg transition-colors">
                <i class="fas fa-user-circle text-gray-700 text-4xl"></i>
            </button>

            <!-- Dropdown Menu -->
            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-300 rounded-lg shadow-lg">
                <a href="?page=profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="<?= base_url('auth/logout') ?>" 
                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    profileBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent closing immediately
        profileDropdown.classList.toggle('hidden');
    });

    // Close dropdown on click outside
    document.addEventListener('click', () => {
        profileDropdown.classList.add('hidden');
    });
});
</script>