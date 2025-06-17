<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undang Anggota: <?= esc($group['name']) ?></title>
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-hash" content="<?= csrf_hash() ?>">
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
    <?php include __DIR__ . '/../layout/layout.php' ?>

    <main class="max-w-3xl mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="<?= base_url('group/members/' . $group['slug']) ?>" class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Undang Anggota ke Grup: <?= esc($group['name']) ?></h1>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-xl font-semibold mb-4">Cari Pengguna untuk Diundang</h3>
            <form action="<?= base_url('group/invite-members/' . $group['slug']) ?>" method="GET" class="mb-4">
                <label for="search-user-input" class="block text-sm font-medium text-gray-700">Cari Pengguna (Username atau Email):</label>
                <div class="flex items-center mt-1">
                    <input type="text" id="search-user-input" name="q"
                           class="flex-grow border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Ketik username atau email..." value="<?= esc($searchQuery ?? '') ?>">
                    <button type="submit" class="ml-3 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <h3 class="text-xl font-semibold mt-6 mb-4">Hasil Pencarian</h3>
            <ul id="search-results-list" class="space-y-3">
                <?php if (empty($searchQuery)): ?>
                    <li class="text-center text-gray-500" id="initial-search-message">Ketik sesuatu untuk mencari pengguna.</li>
                <?php elseif (empty($foundUsers)): ?>
                    <li class="text-center text-gray-500">Tidak ada pengguna yang ditemukan dengan pencarian "<?= esc($searchQuery) ?>".</li>
                <?php else: ?>
                    <?php foreach ($foundUsers as $user): ?>
                        <li class="flex items-center justify-between bg-white p-4 rounded-lg shadow-sm">
                            <div class="flex items-center">
                                <img src="<?= base_url('uploads/' . $user['picture']) ?>" class="w-10 h-10 rounded-full mr-3 object-cover" alt="<?= esc($user['username']) ?>">
                                <div>
                                    <p class="font-medium text-gray-900"><?= esc($user['username']) ?></p>
                                    <p class="text-sm text-gray-500"><?= esc($user['full_name'] ?: $user['email']) ?></p>
                                </div>
                            </div>
                            <form action="<?= base_url('group/send-invitation') ?>" method="post">
                                <?= csrf_field() ?>
                                <input type="hidden" name="group_id" value="<?= esc($group['id']) ?>">
                                <input type="hidden" name="user_id" value="<?= esc($user['id']) ?>">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                                    Undang
                                </button>
                            </form>
                        </li>
                    <?php endforeach ?>
                <?php endif; ?>
            </ul>
        </div>
    </main>
    
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
    <script>
        const currentGroupId = <?= esc($group['id']) ?>;
        const currentGroupSlug = '<?= esc($group['slug']) ?>';

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof initFlowbite === 'function') {
                initFlowbite();
                console.log('Flowbite diinisialisasi pada group_invite_members_view.php (PHP biasa).');
            }
        });
    </script>
</body>
</html>