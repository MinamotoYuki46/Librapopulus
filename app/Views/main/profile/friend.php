<?php
$friends = [
    [
        'id' => 1,
        'name' => 'Alice Johnson',
        'avatar' => 'https://i.pravatar.cc/100?u=alice',
        'last_message' => [
            'content' => 'Hey! Are you still reading The Hobbit?',
            'timestamp' => '2025-06-07 10:35'
        ]
    ],
    [
        'id' => 2,
        'name' => 'Bob Smith',
        'avatar' => 'https://i.pravatar.cc/100?u=bob',
        'last_message' => [
            'content' => 'Sure, I’ll lend you the book tomorrow after lunch.',
            'timestamp' => '2025-06-07 08:20'
        ]
    ],
    [
        'id' => 3,
        'name' => 'Charlie Davis',
        'avatar' => 'https://i.pravatar.cc/100?u=charlie',
        'last_message' => [
            'content' => 'Can you recommend a fantasy book for this weekend?',
            'timestamp' => '2025-06-06 22:14'
        ]
    ],
];

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
    <?php include __DIR__ . '/../layout/header.php' ?>

    <main class="max-w-3xl mx-auto py-8 px-4">
        <h1 class="text-3xl font-bold mb-6">Friends</h1>

        <ul class="space-y-4">
            <?php foreach ($friends as $friend): ?>
                <li class="flex items-center bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <img src="<?= htmlspecialchars($friend['avatar']) ?>" alt="<?= htmlspecialchars($friend['name']) ?> avatar" class="w-12 h-12 rounded-full mr-4" />
                    <div class="flex-grow min-w-0">
                        <p class="font-semibold text-gray-900"><?= htmlspecialchars($friend['name']) ?></p>
                        <p class="text-gray-600 text-sm truncate"><?= htmlspecialchars($friend['last_message']['content']) ?></p>
                    </div>
                    <span class="text-gray-400 text-xs ml-4 whitespace-nowrap"><?= timeShort($friend['last_message']['timestamp']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

    <?php include __DIR__ . '/../layout/navbar.php' ?>
</body>
</html>
