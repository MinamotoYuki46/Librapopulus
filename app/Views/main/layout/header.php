<?php

$photoProfile = session()->get('picture') ?? null;
$username = session()->get('username') ?? 'Guest';
// Dummy notifications for demo (replace with DB fetch)
$notifications = [
    [
        'id' => 1,
        'type' => 'friend_request',
        'sender' => [
            'name' => 'Jane Doe',
            'avatar' => 'https://i.pravatar.cc/150?u=jane_doe'
        ],
        'timestamp' => strtotime('-2 hours'),
        'read' => false
    ],
    [
        'id' => 2,
        'type' => 'loan_request',
        'sender' => [
            'name' => 'John Smith',
            'avatar' => 'https://i.pravatar.cc/150?u=john_smith'
        ],
        'details' => [
            'book_title' => "Lord of The Rings"
        ],
        'timestamp' => strtotime('-1 day'),
        'read' => false
    ],
    [
        'id' => 3,
        'type' => 'friend_request',
        'sender' => [
            'name' => 'Peter Jones',
            'avatar' => 'https://i.pravatar.cc/150?u=peter_jones'
        ],
        'timestamp' => strtotime('-3 days'),
        'read' => true
    ],
];




function time_ago($timestamp) {
    $diff = time() - $timestamp;
    if ($diff < 60) return $diff . 's ago';
    if ($diff < 3600) return floor($diff / 60) . 'm ago';
    if ($diff < 86400) return floor($diff / 3600) . 'h ago';
    return floor($diff / 86400) . 'd ago';
}

$notificationCount = count(array_filter($notifications, fn($n) => !$n['read']));
?>

<header class="fixed top-0 left-0 right-0 z-50 bg-blue-200/90 backdrop-blur-sm border-b border-white/40 shadow-sm px-6 py-4 flex justify-between items-center md:pl-20">
    <div>
        <h1 class="text-4xl font-bold text-gray-900">
            <?= $headerTitle ?? 'Librapopulus' ?>
        </h1>
    </div>
    <div class="flex items-center space-x-4 relative">
        <!-- Notification Button -->
        <button class="p-2 hover:bg-gray-300 rounded-lg transition-colors relative">
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

        <div class="relative">
            <button id="profileBtn" class="p-1 hover:bg-gray-300 rounded-full transition-colors">
                <img 
                    src="<?= base_url("uploads/" . $photoProfile) ?>"
                    alt="Foto Profil"
                    class="rounded-full w-10 h-10 object-cover"
                />
            </button>

            <div id="profileDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-300 rounded-lg shadow-lg">
                <p class="px-4 py-2 border-b border-gray-200 font-bold"><?= "@" . esc($username) ?></p>
                <form action="<?= base_url('auth/logout') ?>" method="POST" class="w-full">
                    <?= csrf_field() ?>
                    <input type ="hidden" name="_method" value="DELETE">
                    <button type="submit" 
                            class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 cursor-pointer"
                            style="background: none; border: none;">
                        <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
        
    </div>
</header>

<div id="notificationOverlay" class="fixed inset-0 bg-white/90 backdrop-blur-md z-40 hidden overflow-y-auto">
    <div class="max-w-2xl mx-auto py-25 px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 pt-10">Notifikasi</h1>

        <div id="notificationContent" class="space-y-4">
            <?php include __DIR__ . '/../components/notification_cards.php'; ?>
        </div>
    </div>
</div>



<div class="h-[88px]"></div>
<script src="<?= base_url("assets/js/header.js")?>"></script>
