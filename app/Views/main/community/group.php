<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-hash" content="<?= csrf_hash() ?>">
    <title>Chat: <?= esc($group['name']) ?></title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
    <?php include __DIR__ . '/../layout/layout.php' ?>
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

                <?php if ($isAdmin): ?>
                    <form action="<?= base_url('group/delete/' . $group['id']) ?>" method="POST" class="ml-auto">
                        <?= csrf_field() ?>
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus grup ini?')"
                                class="bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 transition-colors duration-200">
                            <i class="fa fa-trash mr-2"></i>Hapus Grup
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($isAdmin): ?>
                    <a href="<?= base_url('group/editgroup/' . $group['slug']) ?>" 
                        class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-600 transition-colors duration-200">
                        Edit Group
                    </a>
                <?php endif; ?>

                <?php if ($isAdmin): ?>
                    <a href="<?= base_url('group/members/' . $group['slug']) ?>" 
                        class="bg-purple-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors duration-200 ml-2">
                        <i class="fas fa-users-cog mr-2"></i>Atur Anggota
                    </a>
                <?php endif; ?>
                
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
            
            <section id="chat-messages" class="bg-white rounded-lg shadow p-4 max-h-[60vh] overflow-y-auto space-y-4 mb-6">
                <div id="loading-indicator" class="text-center py-2" style="display: none;"><p class="text-gray-500">Memuat pesan lama...</p></div>
                
                <?php if (empty($messages)): ?>
                    <p id="empty-placeholder" class="text-center text-gray-500">Jadilah yang pertama mengirim pesan di grup ini! 🚀</p>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <?php
                            $isOwnMessage = ($msg['sender_id'] == $masterUserId);
                            $dt = new DateTime($msg['created_at'], new DateTimeZone('UTC'));
                            $dt->setTimezone(new DateTimeZone('Asia/Makassar'));
                        ?>
                        <div class="flex <?= $isOwnMessage ? 'justify-end' : 'justify-start' ?>" data-message-id="<?= $msg['id'] ?>">
                            <div class="flex items-start gap-2.5 mb-4 <?= $isOwnMessage ? 'flex-row-reverse' : '' ?>">

                                <img src="<?= base_url('uploads/' . ($isOwnMessage ? $photoProfile : $msg['sender_picture'])) ?>"
                                    alt="avatar"
                                    class="w-8 h-8 rounded-full">

                                <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200
                                    <?= $isOwnMessage
                                        ? 'bg-blue-500 text-white rounded-s-xl rounded-ee-xl ml-auto'
                                        : 'bg-gray-100 text-gray-900 rounded-e-xl rounded-es-xl' ?>">

                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-semibold ..."><?= $isOwnMessage ? 'Anda' : esc($msg['sender_username']) ?></span>
                                            <span class="text-sm font-normal ..."><?= $dt->format('d M H:i') ?></span>
                                        </div>

                                        <?php if ($isOwnMessage || $isAdmin): ?>
                                            <button id="dropdown-button-<?= $msg['id'] ?>" data-dropdown-toggle="dropdown-<?= $msg['id'] ?>" class="inline-flex self-center items-center p-2 text-sm font-medium text-center <?= $isOwnMessage ? 'text-white hover:bg-blue-600' : 'text-gray-900 bg-white hover:bg-gray-100' ?> rounded-lg focus:outline-none" type="button">
                                                <svg class="w-4 h-4 text-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15"><path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                                            </button>
                                            <div id="dropdown-<?= $msg['id'] ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40">
                                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown-button-<?= $msg['id'] ?>">
                                                    <li>
                                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 delete-message-btn" data-message-id="<?= $msg['id'] ?>">
                                                            <i class="fas fa-trash w-4 h-4 mr-2 text-red-600 hover:bg-red-100"></i>
                                                            Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm font-normal py-2.5">
                                        <?= nl2br(esc($msg['message_text'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>

        <footer class="bg-white p-4 border-t border-gray-200 flex-shrink-0">
            <form id="chat-form" class="max-w-3xl mx-auto flex items-center space-x-3">
                <?= csrf_field() ?>

                <input type="hidden" name="group_id" id="group_id" value="<?= $group['id'] ?>">
                <input type="hidden" name="group_slug" id="group_slug" value="<?= $group['slug'] ?>">
                
                <input
                    type="text"
                    id="message_text"
                    name="message_text"
                    class="flex-grow border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                    placeholder="Ketik pesan..."
                    required
                    autocomplete="off"
                />
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-paper-plane"></i> Kirim
                </button>
            </form>
        </footer>
    </div>
    <div id="delete-message-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-message-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda yakin ingin menghapus pesan ini?</h3>
                    <button id="confirm-delete-btn" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Ya, saya yakin
                    </button>
                    <button data-modal-hide="delete-message-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Tidak, batalkan
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chat-form');
            const loadingIndicator = document.getElementById('loading-indicator');
            const messageText = document.getElementById('message_text');
            const chatMessages = document.getElementById('chat-messages');
            const groupId = document.getElementById('group_id').value;

            const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
            let csrfHash = document.querySelector('meta[name="csrf-token-hash"]').getAttribute('content');
        
            let isLoadingPrevious = false;
            let hasMoreMessages = <?= $hasMoreMessages ? 'true' : 'false' ?>;
            let lastMessageId = <?= !empty($messages) ? json_encode(end($messages)['id']) : 0?>;

            const deleteModalElement = document.getElementById('delete-message-modal');
            const deleteModal = new Modal(deleteModalElement);
            let messageIdToDelete = null;
            
            chatMessages.scrollTop = chatMessages.scrollHeight;

            async function loadPreviousMessages() {
                if (!hasMoreMessages) return; 

                isLoadingPrevious = true;
                loadingIndicator.style.display = 'block';

                const firstMessageDiv = chatMessages.querySelector('div[data-message-id]');
                if (!firstMessageDiv) {
                    isLoadingPrevious = false;
                    loadingIndicator.style.display = 'none';
                    return;
                }

                const oldestId = firstMessageDiv.getAttribute('data-message-id');
                try {
                    const response = await fetch(`<?= base_url('group/fetch-old-messages/') ?>${groupId}/${oldestId}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const result = await response.json();

                    if (result.messages.length > 0) {
                        const oldScrollHeight = chatMessages.scrollHeight; 

                        result.messages.forEach(msg => {
                            const messageElement = createMessageElement(msg);
                            loadingIndicator.after(messageElement);
                        });

                
                        const newScrollHeight = chatMessages.scrollHeight;
                        chatMessages.scrollTop = newScrollHeight - oldScrollHeight;

                        initFlowbite();
                    }
            
                    hasMoreMessages = result.hasMore;

                } catch (error) {
                    console.error('Gagal memuat pesan lama:', error);
                } finally {
                    isLoadingPrevious = false;
                    loadingIndicator.style.display = 'none';
                }
            }

            chatMessages.addEventListener('scroll', () => {
                if (chatMessages.scrollTop < 5 && !isLoadingPrevious) {
                    loadPreviousMessages();
                }
            });

            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault(); 

                
                if (messageText.value.trim() === '') {
                    return; 
                }

                const formData = new FormData(chatForm);
                formData.append(csrfName, csrfHash);

                try {
                    const response = await fetch('<?= base_url('group/send') ?>', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const result = await response.json();

                    if (result.success) {
                        messageText.value = '';
                        csrfHash = result.csrf_hash; 
                        document.querySelector('meta[name="csrf-token-hash"]').setAttribute('content', csrfHash);
                    } else {
                        console.error('Gagal mengirim pesan:', result.error);
                        alert('Gagal mengirim pesan.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan koneksi.');
                }
            });

            setInterval(async function() {
                try {
                    const response = await fetch(`<?= base_url('group/fetch-message/') ?>${groupId}/${lastMessageId}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const newMessages = await response.json();

                    if(newMessages.length > 0) {
                        const placeholder = document.getElementById('empty-placeholder');
                        if (placeholder) placeholder.remove();
                        newMessages.forEach(msg => {
                            const messageElement = createMessageElement(msg);
                            chatMessages.appendChild(messageElement);
                            lastMessageId = msg.id;
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                        initFlowbite();
                    }
                } catch (error) {
                    console.error('Error fetching new messages: ', error);
                }
            }, 1000);

            function formatTime(utcDateTimeString) {
                if (!utcDateTimeString) return '';
                const date = new Date(utcDateTimeString.replace(' ', 'T') + 'Z');
                const options = { month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false };
                return new Intl.DateTimeFormat('en-GB', options).format(date);
            }

            async function performDeleteMessage() {
                if (!messageIdToDelete) return;

                const formData = new FormData();
                formData.append(csrfName, csrfHash);
                
                try {
                    const response = await fetch(`<?=  base_url('group/delete-message/')?>${messageIdToDelete}`, {
                        method: 'POST',
                        body: formData,
                        headers: {'X-Requested-With': 'XMLHttpRequest'}
                    });
                    const result = await response.json();

                    if(result.success) {
                        csrfHash = result.csrf_hash;
                        document.querySelector('meta[name="csrf-token-hash"]').setAttribute('content', csrfHash);

                        const messageElement = document.querySelector(`div[data-message-id="${messageIdToDelete}"]`);
                        if (messageElement) {
                            messageElement.style.transition = 'opacity 0.3s ease-out';
                            messageElement.style.opacity = '0';
                            setTimeout(() => messageElement.remove(), 300);
                        }
                    } else {
                        alert(result.error || 'Gagal hapus pesan');
                    }
                } catch(error) {
                    console.error('error', error);
                    alert('terjadi kesalahan koneksi')
                } finally {
                    messageIdToDelete = null;
                    deleteModal.hide();
                }
            } 

            chatMessages.addEventListener('click', function(e) {
                const deleteButton = e.target.closest('.delete-message-btn');
                if(deleteButton) {
                    e.preventDefault();
                    messageIdToDelete = deleteButton.dataset.messageId;
                    deleteModal.show();
                }
            });

            document.getElementById('confirm-delete-btn').addEventListener('click', function() {
                performDeleteMessage();
            })

            function createMessageElement(msg) {
                const ownMessage = msg.sender_id == <?= $masterUserId?>;
                const isAdmin = <?= $isAdmin ? 'true' : 'false' ?>;
                const div = document.createElement('div');
                
                const time = formatTime(msg.created_at);
                const sanitizedMessage = msg.message_text.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\n/g, '<br>');
                const deleteButtonHTML = (ownMessage || isAdmin) ?
                    `<button id="dropdown-button-${msg.id}" data-dropdown-toggle="dropdown-${msg.id}" class="inline-flex self-center items-center p-2 text-sm font-medium text-center ${ownMessage ? 'text-white hover:bg-blue-600' : 'text-gray-900 bg-white hover:bg-gray-100'} rounded-lg focus:outline-none" type="button">
                        <svg class="w-4 h-4 text-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15"><path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                    </button>
                    <div id="dropdown-${msg.id}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40">
                        <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown-button-${msg.id}">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 delete-message-btn" data-message-id="${msg.id}">
                                    <i class="fas fa-trash w-4 h-4 mr-2 text-red-600 hover:bg-red-100"></i>
                                    Hapus
                                </a>
                            </li>
                        </ul>
                    </div>` : '';


                
                div.className = `flex ${ownMessage ? 'justify-end' : 'justify-start'}`;
                div.setAttribute('data-message-id', msg.id);
                div.innerHTML = `
                    <div class="flex items-start gap-2.5 mb-4 ${ownMessage ? 'flex-row-reverse' : ''}">
                        <img src="<?= base_url('uploads/') ?>${ownMessage ? '<?= $photoProfile ?>' : msg.sender_picture}" alt="avatar" class="w-8 h-8 rounded-full">
                        <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 ${ownMessage ? 'bg-blue-500 text-white rounded-s-xl rounded-ee-xl ml-auto' : 'bg-gray-100 text-gray-900 rounded-e-xl rounded-es-xl'}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-semibold ${ownMessage ? 'text-white' : 'text-blue-600'}">${ownMessage ? 'Anda' : msg.sender_username}</span>
                                    <span class="text-sm font-normal ${ownMessage ? 'text-blue-100' : 'text-gray-500'}">${time}</span>
                                </div>
                                ${deleteButtonHTML}
                            </div>
                            <p class="text-sm font-normal py-2.5">${sanitizedMessage}</p>
                        </div>
                    </div>
                `;
                return div;
            }
        });
    </script>
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>