<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pesan dengan @<?= esc($recipient['username']) ?></title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
    <?php include 'layout/header.php'; ?>

    <main class="max-w-3xl mx-auto px-4 py-6">
        <header class="flex items-center mb-6">
            <img src="<?= base_url('uploads/' . $recipient['picture']) ?>" class="w-12 h-12 rounded-full mr-4" alt="Avatar of <?= esc($recipient['username']) ?>">
            <h1 class="text-2xl font-bold text-gray-800">@<?= esc($recipient['username']) ?></h1>
        </header>

        <section class="bg-white rounded-lg shadow p-4 max-h-[60vh] overflow-y-auto space-y-4 mb-6">
            <?php foreach ($messages as $msg): ?>
                <?php
                    $isSentByCurrentUser = $msg['sender_id'] == $currentUser['id'];
                    $sender = $isSentByCurrentUser ? $currentUser : $recipient;

                    $dt = new DateTime($msg['created_at'], new DateTimeZone('UTC'));
                    $dt -> setTimezone(new DateTimeZone('Asia/Makassar'));
                ?>
                <div class="flex <?= $isSentByCurrentUser ? 'justify-end' : 'justify-start' ?>">
                    <div class="flex items-start space-x-3 max-w-md <?= $isSentByCurrentUser ? 'flex-row-reverse text-right' : '' ?>">
                        <div>
                            <div class="<?= $isSentByCurrentUser ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900' ?> px-4 py-2 rounded-lg shadow-sm">
                                <?= nl2br(esc($msg['message_text'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>

        <form action="<?= base_url('message/send')?>" method="POST" class="flex items-center space-x-4">
            <?= csrf_field() ?> 
            <input type="hidden" name="receiverId" value="<?= $recipient['id'] ?>">
            <input type="hidden" name="username" value="<?= $recipient['username'] ?>">
            <input
                type="text"
                name="message"
                class="flex-grow border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                placeholder="Ketik pesan..."
                required
            />
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-paper-plane mr-1"></i> Kirim
            </button>
        </form>
    </main>

    <?php include  'layout/navbar.php'; ?>
</body>
</html>
