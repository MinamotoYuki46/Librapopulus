<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Grup</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-200 min-h-screen">
    <?php include __DIR__ . '/../layout/header.php' ?>
    
    <main class="px-6 pb-6 py-6" id="mainContent">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md mt-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Buat Grup Baru</h1>

            <?php if (session()->has('errors')): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Oops! Ada kesalahan:</p>
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li>- <?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('group/proceedCreateGroup') ?>" method="POST" enctype="multipart/form-data" class="space-y-5" id="groupForm">
                <?= csrf_field() ?>

                <div class="mb-6">
                    <label for="group_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Grup</label>
                    <input type="text" name="group_name" id="group_name" value="<?= old('group_name') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"><?= old('description') ?></textarea>
                </div>
                
                <div class="mb-8">
                    <label for="group_icon" class="block text-gray-700 text-sm font-bold mb-2">Ikon Grup (Opsional)</label>
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            <img id="icon_preview" class="h-20 w-20 object-cover rounded-full" src="https://via.placeholder.com/150" alt="Pratinjau Ikon Grup" />
                        </div>
                        <label class="block">
                            <span class="sr-only">Pilih ikon grup</span>
                            <input type="file" name="group_icon" id="group_icon" onchange="previewIcon(event)" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        </label>
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="w-full bg-blue-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-600 transition-colors duration-200">
                        Buat Grup
                    </button>
                </div>

            </form>
        </div>
    </main>
    <?php include __DIR__ . '/../layout/navbar.php' ?>
</body>
</html>