<!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-300 px-6 py-3">
            <div class="flex justify-around items-center">
                <a href="<?= base_url('dashboard') ?>" class="flex flex-col items-center <?= ($currentPage ?? '') == 'dashboard' ? 'text-purple-600' : 'text-gray-500 hover:text-purple-600' ?> transition-colors">
                    <i class="fas fa-home text-lg mb-1"></i>
                    <span class="text-xs">Home</span>
                </a>
                <a href="<?= base_url('search') ?>" class="flex flex-col items-center <?= ($currentPage ?? '') == 'search' ? 'text-purple-600' : 'text-gray-500 hover:text-purple-600' ?> transition-colors">
                    <i class="fas fa-search text-lg mb-1"></i>
                    <span class="text-xs">Search</span>
                </a>
                <a href="<?= base_url('library') ?>" class="flex flex-col items-center <?= ($currentPage ?? '') == 'library' ? 'text-purple-600' : 'text-gray-500 hover:text-purple-600' ?> transition-colors">
                    <i class="fas fa-book text-lg mb-1"></i>
                    <span class="text-xs">Library</span>
                </a>
                <a href="<?= base_url('community') ?>" class="flex flex-col items-center <?= ($currentPage ?? '') == 'community' ? 'text-purple-600' : 'text-gray-500 hover:text-purple-600' ?> transition-colors">
                    <i class="fas fa-users text-lg mb-1"></i>
                    <span class="text-xs">Community</span>
                </a>
                <a href="<?= base_url('profile') ?>" class="flex flex-col items-center <?= ($currentPage ?? '') == 'profile' ? 'text-purple-600' : 'text-gray-500 hover:text-purple-600' ?> transition-colors">
                    <i class="fas fa-user text-lg mb-1"></i>
                    <span class="text-xs">Profile</span>
                </a>
            </div>
        </nav>
</html>
