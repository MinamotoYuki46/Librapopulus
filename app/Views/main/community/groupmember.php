<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Anggota Grup</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-100">
    <?php include __DIR__ . '/../layout/layout.php' ?>
    <div class="flex justify-center py-6">
        
        <div class="w-full max-w-md bg-white rounded-xl shadow-md p-4">
            <div class="mb-4">
                <a href="<?= base_url('group/' . $group['slug']) ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>


            <div class="flex flex-col items-center text-center mb-6">
                <img src="<?= base_url('uploads/groups/' . $group['icon']) ?>" alt="Logo Grup"
                    class="w-28 h-28 rounded-full object-cover shadow-md mb-3">

                <h2 class="text-3xl font-bold text-gray-800"><?= esc($group['name']) ?></h2>

                <p class="text-lg text-gray-500 mt-1"><?= count($members) ?> anggota</p>

                <p class="text-lg text-gray-600 mt-2 px-4"><?= esc($group['description']) ?></p>
            </div>

            <?php if ($isCurrentUserAdmin): ?>
                <div class="flex justify-center my-6">
                    <a href="<?= base_url('group/invite-members/' . $group['slug']) ?>"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-blue-700 transition">
                        <i class="fa-solid fa-user-plus mr-2"></i> Tambah Anggota
                    </a>
                </div>
            <?php endif ?>

            <div class="space-y-5">
                <?php foreach ($members as $member): ?>
                    <div class="flex items-center justify-between hover:bg-gray-100 px-4 py-4 rounded-xl shadow-sm transition">
                        <a href="<?= base_url('profile/' . $member['username']) ?>" class="flex items-center gap-4">
                            <img src="<?= base_url('uploads/' . $member['picture']) ?>" alt="Foto Profil"
                                class="w-14 h-14 rounded-full object-cover shadow-md">

                            <div class="flex flex-col">
                                <span class="text-base font-semibold text-gray-800"><?= esc($member['username']) ?></span>
                                <span class="text-sm text-gray-500"><?= esc($member['full_name']) ?></span>
                            </div>
                        </a>

                        <div class="flex items-center gap-3">
                            <?php if ($member['role'] == 'admin'): ?>
                                <span class="bg-yellow-200 text-yellow-800 text-sm px-3 py-1 rounded-full font-semibold shadow-sm">Admin</span>
                            <?php endif ?>

                            <?php if ($isCurrentUserAdmin && $member['user_id'] !== $masterUserId): ?>
                                <button id="dropdownButton-<?= $member['user_id'] ?>" data-dropdown-toggle="dropdown-<?= $member['user_id'] ?>"
                                        class="text-gray-700 hover:text-gray-900 text-xl font-bold px-2">
                                    ⋮
                                </button>

                                <div id="dropdown-<?= $member['user_id'] ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-md w-48">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <?php if ($member['role'] !== 'admin'): ?>
                                            <li>
                                                <form action="<?= base_url('group/' . $group['id'] . '/promote/' . $member['user_id']) ?>" method="post" class="px-4 py-2 hover:bg-gray-100">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="text-left w-full">
                                                        Promosikan jadi Admin
                                                    </button>
                                                </form>
                                            </li>
                                        <?php endif ?>
                                        <li>
                                            <form action="<?= base_url('group/' . $group['id'] . '/kick/' . $member['user_id']) ?>" method="post" class="px-4 py-2 hover:bg-gray-100">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="text-red-600 text-left w-full">
                                                    Keluarkan
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</body>
</html>
