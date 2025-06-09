<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-200 min-h-screen">
    <?php include __DIR__ . '/../layout/header.php'; ?>
    <main class="px-6 pb-6 py-6" id="mainContent">
        <div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-semibold mb-4 text-center">Edit Profil</h2>
            <form action="<?= base_url('profile/update') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
                <?= csrf_field() ?>


                <div class="w-32 h-32 mx-auto relative group">
                    <label for="photoProfile" class="cursor-pointer block w-full h-full">
                        <img id="previewImage"
                            src="<?= base_url('uploads/' . $photoProfile) ?>"
                            alt="Foto Profil"
                            class="rounded-full w-full h-full object-cover border-4 border-gray-300 group-hover:opacity-80 transition duration-200" />
                        <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition">
                            <i class="fa fa-camera text-white text-xl"></i>
                        </div>
                    </label>
                    <input type="file" id="photoProfile" name="photoProfile" accept="image/*" class="hidden" onchange="previewFile()" />
                </div>



                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" value="<?= $user['username'] ?? '' ?>" placeholder="<?= $user['username'] ?? '' ?>" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="fullname" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname" value="<?= $user['fullname'] ?? '' ?>" placeholder="<?= $user['fullname'] ?? '' ?>" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Kota -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">Kota</label>
                    <input type="text" id="city" name="city" value="<?= $user['city'] ?? '' ?>" placeholder="<?= $user['city'] ?? '' ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Provinsi -->
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" id="province" name="province" value="<?= $user['province'] ?? '' ?>" placeholder="<?= $user['province'] ?? '' ?>"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Deskripsi Diri -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Diri</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tulis sesuatu tentang dirimu..."><?= old('description', $user['description'] ?? '') ?></textarea>
                    </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-center space-x-4 pt-4">
                    <a href="<?= base_url('profile/' . $user["username"]) ?>" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold py-2 px-4 rounded-lg shadow">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>
    <?php include __DIR__ . '/../layout/navbar.php'; ?>

    
    <script>
        function previewFile() {
            const file = document.getElementById('photoProfile').files[0];
            const preview = document.getElementById('previewImage');
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
