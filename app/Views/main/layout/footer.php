<?php
$currentPage = $_GET['page'] ?? 'dashboard';
$navigationItems = [
    ['icon' => 'fas fa-home', 'label' => 'Home', 'page' => 'dashboard'],
    ['icon' => 'fas fa-search', 'label' => 'Search', 'page' => 'search'],
    ['icon' => 'fas fa-book', 'label' => 'Library', 'page' => 'library'],
    ['icon' => 'fas fa-users', 'label' => 'Community', 'page' => 'community'],
    ['icon' => 'fas fa-user', 'label' => 'Profile', 'page' => 'profile'],
];
?>

<style>
#sidebar {
    transition: width 0.3s ease;
}

.nav-collapsed {
    width: 4rem;
}

.nav-collapsed .nav-text {
    opacity: 0;
    pointer-events: none;
    width: 0;
    overflow: hidden;
    transition: opacity 0.3s ease;
}

.nav-collapsed .nav-item {
    justify-content: center;
}

.nav-collapsed .footer-text {
    display: none;
}
</style>

<!-- Desktop Sidebar Navigation -->
<nav id="sidebar" class="fixed top-21.5 bottom-0 left-0 w-48 bg-white px-4 py-6 hidden md:flex flex-col justify-between z-50">
    <div>
        <div class="flex items-center justify-between mb-8">
            <button id="toggleSidebar" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-bars text-gray-600"></i>
            </button>
        </div>
        
        <div class="space-y-2">
            <?php foreach ($navigationItems as $item): ?>
                <a href="?page=<?= $item['page'] ?>" 
                   class="nav-item flex items-center gap-3 px-3 py-3 rounded-lg transition-all duration-200 <?= $currentPage == $item['page'] ? 'bg-purple-100 text-purple-600' : 'text-gray-600 hover:bg-gray-100 hover:text-purple-600' ?>">
                    <i class="<?= $item['icon'] ?> text-lg flex-shrink-0"></i>
                    <span class="nav-text transition-opacity duration-300"><?= $item['label'] ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="footer-text text-xs text-gray-400 transition-opacity duration-300">© 2025 MyApp</div>
</nav>

<!-- Mobile Bottom Navigation -->
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-300 px-6 py-3 flex md:hidden justify-around items-center z-50">
    <?php foreach ($navigationItems as $item): ?>
        <a href="?page=<?= $item['page'] ?>" 
           class="flex flex-col items-center gap-1 <?= $currentPage == $item['page'] ? 'text-purple-600' : 'text-gray-500 hover:text-purple-600' ?> transition-colors">
            <i class="<?= $item['icon'] ?> text-lg"></i>
            <span class="text-xs"><?= $item['label'] ?></span>
        </a>
    <?php endforeach; ?>
</nav>

<script src="<?= base_url('assets/js/sideBarToggle.js') ?>"></script>
