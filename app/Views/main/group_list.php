<?php
// Dummy group list
$groups = [
    [
        'id' => 1,
        'name' => 'Book Lovers Club',
        'description' => 'A group of friends who love reading and lending books.',
        'avatar' => 'https://i.pravatar.cc/100?u=bookclub1',
        'member_count' => 5,
        'last_message' => 'Alice: Just finished 1984!',
    ],
    [
        'id' => 2,
        'name' => 'Fantasy Fanatics',
        'description' => 'Discussing all things magic and dragons.',
        'avatar' => 'https://i.pravatar.cc/100?u=fantasy2',
        'member_count' => 8,
        'last_message' => 'Bob: The Hobbit is amazing!',
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Group List</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'layout/header.php'; ?>

    <main class="max-w-3xl mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Your Groups</h1>

        <div class="space-y-4">
            <?php foreach ($groups as $group): ?>
                <a href="group.php?id=<?= $group['id'] ?>" class="flex items-center bg-white p-4 rounded-lg shadow hover:bg-gray-50 transition">
                    <img src="<?= htmlspecialchars($group['avatar']) ?>" alt="Group avatar" class="w-14 h-14 rounded-full mr-4">
                    <div class="flex-grow">
                        <h2 class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($group['name']) ?></h2>
                        <p class="text-gray-600 text-sm"><?= htmlspecialchars($group['description']) ?></p>
                        <div class="text-sm text-gray-500 mt-1">
                            <?= $group['member_count'] ?> members &middot; <?= htmlspecialchars($group['last_message']) ?>
                        </div>
                    </div>
                    <i class="fas fa-users text-gray-400 text-xl ml-4"></i>
                </a>
            <?php endforeach; ?>
        </div>
    </main>

    <?php include 'layout/footer.php'; ?>
</body>
</html>
