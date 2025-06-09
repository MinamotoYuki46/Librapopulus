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
        <section class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
            <div>
                <h2 class="text-2xl font-semibold mb-4">Daftar Teman (<?= count($friends) ?>)</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <?php foreach ($friends as $friend): ?>
                        <a href="<?= base_url('profile/' . $friend['username']) ?>" class="block bg-white p-4 rounded-lg shadow text-center hover:shadow-lg transition duration-200 max-w-xs mx-auto">
                            <div class="w-28 h-28 mx-auto">
                                <img src="<?= base_url('uploads/' . $friend['picture']) ?>"
                                    alt="<?= htmlspecialchars($friend['username']) ?>"
                                    class="rounded-full w-full h-full object-cover border-4 border-gray-300" />
                            </div>
                            <p class="text-black font-bold mt-2"><?= '@' . htmlspecialchars($friend['username']) ?></p>
                            <p class="text-gray-600 font-medium"><?= htmlspecialchars($friend['full_name']) ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php include __DIR__ . '/../layout/navbar.php' ?>
    </main>
</body>
</html>
