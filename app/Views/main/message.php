<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pesan dengan @<?= esc($recipient['username']) ?></title>
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-hash" content="<?= csrf_hash() ?>">
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">

<?php include 'layout/layout.php'; ?>
<main class="max-w-3xl mx-auto px-4 py-6">
    <header class="flex items-center mb-6">
        <img src="<?= base_url('uploads/' . $recipient['picture']) ?>" class="w-12 h-12 rounded-full mr-4" alt="Avatar of <?= esc($recipient['username']) ?>">
        <h1 class="text-2xl font-bold text-gray-800">@<?= esc($recipient['username']) ?></h1>
    </header>

    <section id="chat-box" class="bg-white rounded-lg shadow p-4 max-h-[60vh] overflow-y-auto space-y-4 mb-6">
    </section>

    <form id="chat-form" class="flex items-center space-x-4">
        <?= csrf_field() ?>
        <input type="hidden" name="receiverId" value="<?= $recipient['id'] ?>">
        <input type="hidden" name="username" value="<?= $recipient['username'] ?>">
        <input
            id="chat-input"
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

<div id="delete-confirm-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Konfirmasi Penghapusan
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="delete-confirm-modal">
                    <i class="fas fa-times"></i>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <p class="text-base leading-relaxed text-gray-600">
                    Apakah Anda yakin ingin menghapus pesan ini? Aksi ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                <button id="confirm-delete-button"  data-modal-hide="delete-confirm-modal" type="button" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Ya, saya yakin
                </button>
                <button data-modal-hide="delete-confirm-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    const recipientId = <?= $recipient['id'] ?>;
    const currentUserId = <?= $currentUser['id'] ?>;
    let isLoading = false;
    let noMoreMessages = false;
    let lastMessageId = 0;

    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('chat-input');

    function formatTime(utcDateTimeString) {
        if (!utcDateTimeString) return '';
        const date = new Date(utcDateTimeString.replace(' ', 'T') + 'Z');
        const options = { month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: false };
        return new Intl.DateTimeFormat('en-GB', options).format(date);
    }

    function createMessageElement(msg) {
        const isSentByCurrentUser = msg.sender_id == currentUserId;
        const userPicture = '<?= base_url('uploads/') ?>' + msg.sender_picture;
        const localTime = formatTime(msg.created_at);

        const wrapper = document.createElement('div');
        wrapper.className = `flex items-start gap-2.5 mb-4 ${isSentByCurrentUser ? 'justify-end' : ''}`;

        const avatar = document.createElement('img');
        avatar.className = 'w-8 h-8 rounded-full';
        avatar.src = userPicture;
        avatar.alt = msg.sender_username;

        const bubble = document.createElement('div');
        bubble.className = `flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 ${
            isSentByCurrentUser ? 'bg-blue-500 text-white rounded-s-xl rounded-ee-xl ml-auto' : 'bg-gray-100 text-gray-900 rounded-e-xl rounded-es-xl'
        } relative`;
        bubble.setAttribute('data-message-id', msg.id);

        const dropdownId = `dropdown-for-${msg.id}`;
        const dropdownButtonId = `button-for-${msg.id}`;
        const dropdownHTML = isSentByCurrentUser ? `
            <button id="${dropdownButtonId}" data-dropdown-toggle="${dropdownId}" class="absolute top-2 right-2 inline-flex self-center items-center p-2 text-sm font-medium text-center text-blue-100 hover:bg-blue-600 rounded-lg focus:ring-4 focus:outline-none focus:ring-gray-50" type="button">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div id="${dropdownId}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="${dropdownButtonId}">
                    <li>
                        <a href="#" 
                        data-modal-target="delete-confirm-modal" 
                        data-modal-toggle="delete-confirm-modal"
                        onclick="prepareDelete(${msg.id}); return false;" 
                        class="block px-4 py-2 hover:bg-gray-100 text-red-600">
                            <i class="fas fa-trash-alt w-4 mr-2"></i>Hapus
                        </a>
                    </li>
                </ul>
            </div>
        ` : '';

        bubble.innerHTML = `
            <div class="flex flex-col">
                <div class="flex items-center space-x-2 rtl:space-x-reverse">
                    <span class="text-sm font-semibold ${isSentByCurrentUser ? 'text-white' : 'text-gray-900'}">${isSentByCurrentUser ? 'Anda' : msg.sender_username}</span>
                    <span class="text-sm font-normal ${isSentByCurrentUser ? 'text-blue-100' : 'text-gray-500'}">${localTime}</span>
                </div>
                <p class="text-sm font-normal py-2.5 ${isSentByCurrentUser ? 'text-white' : 'text-gray-900'}">
                    ${msg.message_text.replace(/\n/g, '<br>')}
                </p>
                <span class="text-xs font-normal ${isSentByCurrentUser ? 'text-blue-100' : 'text-gray-500'}">Terkirim</span>
            </div>
        
            ${dropdownHTML}
        `;

        if (isSentByCurrentUser) {
            wrapper.appendChild(bubble);
            wrapper.appendChild(avatar);
        } else {
            wrapper.appendChild(avatar);
            wrapper.appendChild(bubble);
        }

        return wrapper;
    }

    function prepareDelete(messageId) {
        const confirmButton = document.getElementById('confirm-delete-button');
        confirmButton.setAttribute('data-message-id', messageId);
    }

    async function executeDelete(messageId) {
        if (!messageId) return;
        
        const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
        const csrfHash = document.querySelector('meta[name="csrf-token-hash"]').getAttribute('content');
        const formData = new FormData();
        formData.append(csrfName, csrfHash);

        try {
            const response = await fetch(`<?= base_url('message/delete/') ?>${messageId}`, {
                method: 'POST', 
                body: formData, 
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            });
            const data = await response.json();
            if (response.ok && data.status === 'success') {
                const messageElement = document.querySelector(`div[data-message-id='${messageId}']`);
                if (messageElement) {
                    messageElement.parentElement.remove();
                }

                document.querySelector('meta[name="csrf-token-hash"]').setAttribute('content', data.csrf_hash);

            } else {
                alert(data.message || 'Gagal menghapus pesan.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mencoba menghapus pesan.');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const confirmButton = document.getElementById('confirm-delete-button');
        if(confirmButton) {
            confirmButton.addEventListener('click', function() {
                const messageId = this.getAttribute('data-message-id');
                executeDelete(messageId);
            });
        }
    });

    async function fetchAndLoadMessages(options = {}) {
        const { offset = 0, sinceId = 0, prepend = false, isInitialLoad = false } = options;
        if (isLoading || (prepend && noMoreMessages)) return;
        isLoading = true;
        const oldScrollHeight = chatBox.scrollHeight;

        const url = (sinceId > 0)
            ? `<?= base_url('message/fetch_new/') ?>${recipientId}?since=${sinceId}`
            : `<?= base_url('message/fetch/') ?>${recipientId}?offset=${offset}`;

        try {
            const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await response.json();

            if (data.messages.length === 0) {
                if (prepend) noMoreMessages = true;
                return;
            }

            if (!prepend) {
                const latest = data.messages[data.messages.length - 1];
                if (latest.id > lastMessageId) lastMessageId = latest.id;
            }

            const shouldAutoScroll = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 10;
            if (isInitialLoad) chatBox.innerHTML = '';

            const messagesToRender = prepend ? data.messages.reverse() : data.messages;
            messagesToRender.forEach(msg => {
                const el = createMessageElement(msg);
                prepend ? chatBox.prepend(el) : chatBox.appendChild(el);
            });

            if (typeof initFlowbite === 'function') {
                initFlowbite();
            }

            if (prepend) {
                chatBox.scrollTop = chatBox.scrollHeight - oldScrollHeight;
            } else if (shouldAutoScroll) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            document.querySelector('meta[name="csrf-token-hash"]').setAttribute('content', data.csrf_hash);
        } finally {
            isLoading = false;
        }
    }

    chatBox.addEventListener('scroll', () => {
        if (chatBox.scrollTop < 5 && !isLoading && !noMoreMessages) {
            const count = chatBox.children.length;
            fetchAndLoadMessages({ offset: count, prepend: true });
        }
    });

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const text = messageInput.value.trim();
        if (text === '') return;

        const formData = new FormData(chatForm);
        const csrfName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
        const csrfHash = document.querySelector('meta[name="csrf-token-hash"]').getAttribute('content');
        formData.append(csrfName, csrfHash);

        messageInput.value = '';

        await fetch('<?= base_url('message/send') ?>', {
            method: 'POST',
            body: formData,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        });

        fetchAndLoadMessages({ sinceId: lastMessageId });
    });

    fetchAndLoadMessages({ offset: 0, isInitialLoad: true });

    setInterval(() => {
        if (!isLoading) {
            fetchAndLoadMessages({ sinceId: lastMessageId });
        }
    }, 3000);
</script>

<script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
