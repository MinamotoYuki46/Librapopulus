<?php
function timeShort($datetime) {
    return date('H:i', strtotime($datetime));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Friends</title>
    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <?php include __DIR__ . '/../layout/layout.php' ?>

    <main class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Friends</h1>

        <ul class="space-y-4">
            <?php foreach ($friends as $friend): ?>
                <li class="flex items-center bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <a href="<?= base_url('message/' . $friend['username']) ?>" class="flex items-center p-4 w-full h-full">
                        <img src="<?= base_url('uploads/' . $friend['picture']) ?>" alt="<?= esc($friend['username']) ?> avatar" class="w-12 h-12 rounded-full mr-4" />
                        <div class="flex-grow min-w-0">
                            <p class="font-semibold text-gray-900"><?= esc($friend['username']) ?></p>
                            <p class="text-gray-600 text-sm truncate"><?= esc($friend['last_message']) ?></p>
                        </div>
                        <span class="text-gray-400 text-xs ml-4 whitespace-nowrap"><?= timeShort($friend['last_message_time']) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
