<?php
// Dummy group info
$group = [
    'id' => 1,
    'name' => 'Book Lovers Club',
    'description' => 'A group of friends who love reading and lending books.'
];

// Dummy members
$members = [
    1 => ['name' => 'Alice Johnson', 'avatar' => 'https://i.pravatar.cc/100?u=alice'],
    2 => ['name' => 'Bob Smith', 'avatar' => 'https://i.pravatar.cc/100?u=bob'],
    3 => ['name' => 'Charlie Davis', 'avatar' => 'https://i.pravatar.cc/100?u=charlie'],
];

// Dummy messages
$messages = [
    ['user_id' => 1, 'text' => 'Hey everyone! What book should we read next?', 'timestamp' => '2025-06-06 09:15'],
    ['user_id' => 2, 'text' => 'I vote for *To Kill a Mockingbird*!', 'timestamp' => '2025-06-06 09:20'],
    ['user_id' => 3, 'text' => 'Sounds good! I haven’t read it yet.', 'timestamp' => '2025-06-06 09:22'],
    ['user_id' => 1, 'text' => 'Great! Let’s start tomorrow.', 'timestamp' => '2025-06-06 09:25'],
];

// Dummy current user
$currentUserId = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($group['name']) ?> - Messages</title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
    <?php include 'layout/header.php'; ?>
    
    <main class="max-w-4xl mx-auto px-4 py-6">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($group['name']) ?> - Messages</h1>
            <p class="text-gray-600 mt-1"><?= htmlspecialchars($group['description']) ?></p>
        </header>

        <section class="bg-white rounded-lg shadow p-4 max-h-[70vh] overflow-y-auto space-y-4 mb-6">
            <?php foreach ($messages as $msg): ?>
                <?php
                    $isCurrentUser = $msg['user_id'] === $currentUserId;
                    $sender = $members[$msg['user_id']];
                ?>
                <div class="flex <?= $isCurrentUser ? 'justify-end' : 'justify-start' ?>">
                    <div class="flex items-start space-x-3 max-w-md <?= $isCurrentUser ? 'flex-row-reverse text-right' : '' ?>">
                        <img src="<?= $sender['avatar'] ?>" alt="Avatar" class="w-10 h-10 rounded-full">
                        <div>
                            <div class="bg-<?= $isCurrentUser ? 'blue-500 text-white' : 'gray-200 text-gray-800' ?> px-4 py-2 rounded-lg shadow-sm">
                                <?= nl2br(htmlspecialchars($msg['text'])) ?>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <?= htmlspecialchars($sender['name']) ?> • <?= date('M d, H:i', strtotime($msg['timestamp'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <form action="#" method="POST" class="flex items-center space-x-4">
            <input
                type="text"
                name="message"
                class="flex-grow border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Type your message..."
                required
            />
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-paper-plane mr-1"></i> Send
            </button>
        </form>
    </main>

    <?php include 'layout/footer.php'; ?>
</body>
</html>
