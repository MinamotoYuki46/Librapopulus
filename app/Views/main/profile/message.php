<?php
// Dummy current user
// $currentUser = [
//     'id' => 1,
//     'name' => 'Alice Johnson',
//     'avatar' => 'https://i.pravatar.cc/100?u=alice',
// ];

// // Dummy recipient
// $recipient = [
//     'id' => 2,
//     'name' => 'Bob Smith',
//     'avatar' => 'https://i.pravatar.cc/100?u=bob',
// ];

// // Dummy private messages between Alice and Bob
// $messages = [
//     ['from_id' => 1, 'to_id' => 2, 'text' => 'Hey Bob! Have you finished reading *1984*?', 'timestamp' => '2025-06-06 10:00'],
//     ['from_id' => 2, 'to_id' => 1, 'text' => 'Almost! Just 2 chapters left. Amazing read so far.', 'timestamp' => '2025-06-06 10:05'],
//     ['from_id' => 1, 'to_id' => 2, 'text' => 'Let me know when you’re done, I want to lend you *Animal Farm* next!', 'timestamp' => '2025-06-06 10:08'],
// ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat with <?= esc($recipient['username']) ?></title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
    <?php __DIR__ . '/../layout/header.php'; ?>

    <main class="max-w-3xl mx-auto px-4 py-6">
        <header class="flex items-center mb-6">
            <img src="<?= Base_url('uploads/' . $recipient['picture']) ?>" class="w-12 h-12 rounded-full mr-4" alt="Avatar of <?= esc($recipient['username']) ?>">
            <h1 class="text-2xl font-bold text-gray-800">Chat with <?= esc($recipient['username']) ?></h1>
        </header>

        <section class="bg-white rounded-lg shadow p-4 max-h-[60vh] overflow-y-auto space-y-4 mb-6">
            <?php foreach ($messages as $msg): ?>
                <?php
                    $isSentByCurrentUser = $msg['sender_id'] === $currentUser['id'];
                    $sender = $isSentByCurrentUser ? $currentUser : $recipient;
                ?>
                <div class="flex <?= $isSentByCurrentUser ? 'justify-end' : 'justify-start' ?>">
                    <div class="flex items-start space-x-3 max-w-md <?= $isSentByCurrentUser ? 'flex-row-reverse text-right' : '' ?>">
                        <img src="<?= Base_url('uploads/' . $sender['picture']) ?>" class="w-10 h-10 rounded-full" alt="<?= $sender['username'] ?> avatar">
                        <div>
                            <div class="bg-<?= $isSentByCurrentUser ? 'blue-500 text-white' : 'gray-200 text-gray-900' ?> px-4 py-2 rounded-lg shadow-sm">
                                <?= nl2br(esc($msg['message_text'])) ?>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <?= esc($sender['username']) ?> • <?= date('M d, H:i', strtotime($msg['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <form action="<?= base_url('profile/message/send')?>" method="POST" class="flex items-center space-x-4">
            <?= csrf_field() ?> 
            <input type="hidden" name="receiverId" value="<?= $recipient['id'] ?>">
            <input type="hidden" name="username" value="<?= $recipient['username'] ?>">
            <input
                type="text"
                name="message"
                class="flex-grow border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Type a message..."
                required
            />
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-paper-plane mr-1"></i> Send
            </button>
        </form>
    </main>

    <?php include __DIR__ . '/../layout/navbar.php'; ?>
</body>
</html>
