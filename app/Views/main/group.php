<?php
// Dummy group info
$group = [
    'id' => 1,
    'name' => 'Book Lovers Club',
    'description' => 'A group of friends who love reading and lending books.'
];

// Dummy members
$members = [
    ['id' => 1, 'name' => 'Alice Johnson', 'avatar' => 'https://i.pravatar.cc/100?u=alice'],
    ['id' => 2, 'name' => 'Bob Smith', 'avatar' => 'https://i.pravatar.cc/100?u=bob'],
    ['id' => 3, 'name' => 'Charlie Davis', 'avatar' => 'https://i.pravatar.cc/100?u=charlie'],
];

// Dummy books
$books = [
    ['id' => 101, 'title' => '1984', 'author' => 'George Orwell'],
    ['id' => 102, 'title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien'],
];

// Reading progress with both total and daily progress
$readingProgress = [
    101 => [ // 1984
        [
            'user_id' => 1,
            'name' => 'Alice Johnson',
            'avatar' => 'https://i.pravatar.cc/100?u=alice',
            'total_pages_read' => 150,
            'total_time_minutes' => 300,
            'daily' => [
                '2025-06-05' => ['pages' => 80, 'minutes' => 150],
                '2025-06-06' => ['pages' => 70, 'minutes' => 150],
            ]
        ],
        [
            'user_id' => 2,
            'name' => 'Bob Smith',
            'avatar' => 'https://i.pravatar.cc/100?u=bob',
            'total_pages_read' => 200,
            'total_time_minutes' => 420,
            'daily' => [
                '2025-06-06' => ['pages' => 120, 'minutes' => 260],
                '2025-06-07' => ['pages' => 80, 'minutes' => 160],
            ]
        ],
    ],
    102 => [ // The Hobbit
        [
            'user_id' => 3,
            'name' => 'Charlie Davis',
            'avatar' => 'https://i.pravatar.cc/100?u=charlie',
            'total_pages_read' => 50,
            'total_time_minutes' => 120,
            'daily' => [
                '2025-06-07' => ['pages' => 50, 'minutes' => 120],
            ]
        ],
        [
            'user_id' => 1,
            'name' => 'Alice Johnson',
            'avatar' => 'https://i.pravatar.cc/100?u=alice',
            'total_pages_read' => 100,
            'total_time_minutes' => 220,
            'daily' => [
                '2025-06-06' => ['pages' => 60, 'minutes' => 120],
                '2025-06-07' => ['pages' => 40, 'minutes' => 100],
            ]
        ],
    ],
];

foreach ($books as &$book) {
    $book['progress'] = $readingProgress[$book['id']] ?? [];
}
unset($book);

function formatTimeSpent($minutes) {
    $hours = floor($minutes / 60);
    $mins = $minutes % 60;
    return $hours > 0 ? "{$hours}h {$mins}m" : "{$mins}m";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($group['name']) ?> - Group</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-200 min-h-screen font-[Inter]">
    <?php include 'layout/header.php' ?>
    <main class="px-6 pb-6 py-6" id="mainContent">
        <header class="max-w-5xl mx-auto mb-8">
            <h1 class="text-4xl font-bold text-gray-900"><?= htmlspecialchars($group['name']) ?></h1>
            <p class="text-gray-700 mt-2"><?= htmlspecialchars($group['description']) ?></p>
        </header>

        <section class="max-w-5xl mx-auto mb-12">
            <h2 class="text-2xl font-semibold mb-4">Members (<?= count($members) ?>)</h2>
            <div class="flex space-x-6 overflow-x-auto">
                <?php foreach ($members as $member): ?>
                    <div class="flex flex-col items-center min-w-[100px]">
                        <img src="<?= htmlspecialchars($member['avatar']) ?>" alt="<?= htmlspecialchars($member['name']) ?> avatar" class="w-20 h-20 rounded-full shadow-md mb-2" />
                        <span class="text-gray-800 font-medium text-center"><?= htmlspecialchars($member['name']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="max-w-5xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6">Books & Reading Progress</h2>

            <?php foreach ($books as $book): ?>
                <div class="bg-white p-6 rounded-lg shadow mb-8">
                    <h3 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($book['title']) ?></h3>
                    <p class="text-gray-700 mb-4">Author: <?= htmlspecialchars($book['author']) ?></p>

                    <?php if (empty($book['progress'])): ?>
                        <p class="text-gray-500 italic">No reading progress yet.</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($book['progress'] as $progress): ?>
                                <div class="flex items-start space-x-4 border rounded p-3 shadow-sm bg-gray-50">
                                    <img src="<?= htmlspecialchars($progress['avatar']) ?>" alt="<?= htmlspecialchars($progress['name']) ?> avatar" class="w-12 h-12 rounded-full" />
                                    <div class="flex-grow">
                                        <p class="font-semibold text-gray-800"><?= htmlspecialchars($progress['name']) ?></p>
                                        <p class="text-gray-600 text-sm">
                                            <strong>Total:</strong><br />
                                            Pages read: <span class="font-medium"><?= $progress['total_pages_read'] ?></span><br />
                                            Time spent: <span class="font-medium"><?= formatTimeSpent($progress['total_time_minutes']) ?></span>
                                        </p>
                                        <?php if (!empty($progress['daily'])): ?>
                                            <details class="mt-2 text-sm text-gray-700">
                                                <summary class="cursor-pointer text-blue-600 underline">View daily breakdown</summary>
                                                <ul class="mt-2 list-disc ml-6 space-y-1">
                                                    <?php foreach ($progress['daily'] as $date => $entry): ?>
                                                        <li>
                                                            <span class="font-medium"><?= $date ?>:</span>
                                                            <?= $entry['pages'] ?> pages,
                                                            <?= formatTimeSpent($entry['minutes']) ?>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </details>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>

        <?php include 'layout/footer.php' ?>
    </main>
</body>
</html>
