<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Komunitas</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-200 min-h-screen font-[Inter]">
    <?php include __DIR__ . '/../layout/header.php' ?>
    
    <main class="px-6 pb-6 py-6" id="mainContent">
        <section class="max-w-5xl mx-auto mt-10 flex flex-col space-y-12">
            
            <div>
                <h2 class="text-2xl font-semibold mb-4">Daftar Teman (<?= count($friends) ?>)</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php if (empty($friends)): ?>
                        <p class="text-gray-500">Anda belum berteman dengan siapapun.</p>
                    <?php else: ?>
                        <?php foreach ($friends as $friend): ?>
                            <a href="<?= base_url('profile/' . $friend['username']) ?>" class="block bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition duration-200">
                                <div class="w-28 h-28 mx-auto">
                                    <img src="<?= base_url('uploads/' . $friend['picture']) ?>"
                                        alt="<?= esc($friend['username']) ?>"
                                        class="rounded-full w-full h-full object-cover border-4 border-gray-300" />
                                </div>
                                <p class="text-black font-bold mt-2 truncate"><?= '@' . esc($friend['username']) ?></p>
                                <p class="text-gray-600 font-medium truncate"><?= esc($friend['full_name']) ?></p>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold">Daftar Grup (<?= count($groups) ?>)</h2>
                    
                    <a href="<?= base_url('group/create') ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition-colors font-semibold text-sm flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Grup
                    </a>
                </div>
                <div class="bg-white p-4 rounded-lg shadow space-y-4">
                    <?php if (empty($groups)): ?>
                        <p class="text-gray-500">Anda belum bergabung dengan grup manapun.</p>
                    <?php else: ?>
                        <?php foreach ($groups as $group): ?>
                            <a href="<?= base_url('group/' . $group['slug']) ?>" class="flex items-center p-3 rounded-lg hover:bg-gray-100 transition duration-200">
                                <div class="w-16 h-16 mr-4 flex-shrink-0">
                                    <img src="<?= base_url('uploads/groups/' . $group['icon']) ?>"
                                        alt="<?= esc($group['group_name']) ?>"
                                        class="rounded-full w-full h-full object-cover" />
                                </div>
                                <div class="flex-grow">
                                    <p class="text-black font-bold text-lg"><?= esc($group['group_name']) ?></p>
                                    
                                    <?php if (!empty($group['description'])): ?>
                                        <p class="text-gray-600 text-sm mt-1 truncate">
                                            <?= esc($group['description']) ?>
                                        </p>
                                    <?php endif; ?>

                                    <div class="flex items-center text-xs text-gray-500 mt-2">
                                        <i class="fas fa-users mr-1.5"></i>
                                        <span><?= $group['member_count'] ?> Anggota</span>
                                    </div>

                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </section>

        <?php include __DIR__ . '/../layout/navbar.php' ?>
    </main>
</body>
</html>