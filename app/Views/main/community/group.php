<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat: <?= esc($group['name']) ?></title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
    <?php include __DIR__ . '/../layout/header.php' ?>
    <div class="max-w-3xl mx-auto px-4 py-6">
        <div class="flex-grow overflow-y-auto">
            <header class="bg-white p-4 border-b border-gray-200 shadow-sm sticky top-0 z-10 flex items-center space-x-4">
    
                <img src="<?= base_url('uploads/groups/' . $group['icon']) ?>" 
                    alt="<?= esc($group['name']) ?>"
                    class="w-24 h-24 rounded-full object-cover flex-shrink-0">

                <div>
                    <h1 class="text-3xl font-bold text-gray-800"><?= esc($group['name']) ?></h1>
                    <?php if (!empty($group['description'])): ?>
                        <p class="text-md text-gray-500 truncate mt-1"><?= esc($group['description']) ?></p>
                    <?php endif; ?>
                </div>
                
            </header>

            <div class="bg-white p-3 border-b border-gray-200">
                <div class="flex items-center text-sm font-semibold text-gray-600 mb-2">
                    <i class="fas fa-users mr-2"></i>
                    <?= count($members) ?> Anggota
                </div>
                <div class="flex space-x-4 overflow-x-auto pb-2">
                    <?php foreach ($members as $member): ?>
                        <a href="<?= base_url('profile/' . $member['username']) ?>" class="flex flex-col items-center text-center flex-shrink-0 w-20">
                            <img src="<?= base_url('uploads/' . $member['picture']) ?>" 
                                 alt="<?= esc($member['username']) ?>"
                                 class="w-12 h-12 rounded-full object-cover border-2 border-gray-300">
                            <span class="text-xs mt-1 text-gray-700 truncate font-bold"> @<?= esc($member['username']) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <section class="bg-white rounded-lg shadow p-4 max-h-[60vh] overflow-y-auto space-y-4 mb-6">
                <?php if (empty($messages)): ?>
                    <p class="text-center text-gray-500">Jadilah yang pertama mengirim pesan di grup ini! 🚀</p>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <?php
                            $isOwnMessage = ($msg['sender_id'] == session() -> get("userId"));

                            $dt = new DateTime($msg['created_at'], new DateTimeZone('UTC'));
                            $dt -> setTimezone(new DateTimeZone('Asia/Makassar'));
                        ?>
                        
                        <div class="flex <?= $isOwnMessage ? 'justify-end' : 'justify-start' ?>">
                            <div class="flex items-start space-x-3 max-w-md <?= $isOwnMessage ? 'flex-row-reverse space-x-reverse' : '' ?>">
                                
                                <img src="<?= base_url('uploads/' . ($isOwnMessage ? $photoProfile : $msg['sender_picture'])) ?>" 
                                    class="w-10 h-10 rounded-full" 
                                    alt="<?= esc($isOwnMessage ? $username : $msg['sender_username']) ?> avatar">
                                
                                <div>
                                    <div class="px-4 py-2 rounded-lg shadow-sm <?= $isOwnMessage ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900' ?>">
                                        <?php if (!$isOwnMessage): ?>
                                            <p class="font-bold text-sm text-blue-600"><?= esc($msg['sender_username']) ?></p>
                                        <?php endif; ?>
                                        
                                        <p class="text-base">
                                            <?= nl2br(esc($msg['message_text'])) ?>
                                        </p>
                                    </div>
                                    
                                    <div class="text-xs text-gray-500 mt-1">
                                        <?= $dt->format('H:i') ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>

        <footer class="bg-white p-4 border-t border-gray-200 flex-shrink-0">
            <form action="<?= base_url('group/send') ?>" method="POST" class="max-w-3xl mx-auto flex items-center space-x-3">
                <?= csrf_field() ?>

                <input type="hidden" name="group_id" value="<?= $group['id'] ?>">
                <input type="hidden" name="group_slug" value="<?= $group['slug'] ?>">
                
                <input
                    type="text"
                    name="message_text"
                    class="flex-grow border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Ketik pesan..."
                    required
                    autocomplete="off"
                />
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        </footer>

        <?php include __DIR__ . '/../layout/navbar.php' ?>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatArea = document.querySelector('.overflow-y-auto'); // Targetkan area scroll utama
            if (chatArea) {
                chatArea.scrollTop = chatArea.scrollHeight;
            }
        });
    </script>

</body>
</html>