<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-hash" content="<?= csrf_hash() ?>">
    <title>Pesan dengan @<?= esc($recipient['username']) ?></title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
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
            const options = {
                month: 'short',    
                day: '2-digit',    
                hour: '2-digit',
                minute: '2-digit', 
                hour12: false
            };
            
            const formatter = new Intl.DateTimeFormat('en-GB', options);
            return formatter.format(date).replace(/\//g, ' ');
        }

        function createMessageElement(msg) {
            const isSentByCurrentUser = msg.sender_id == currentUserId;
            const userPicture = '<?= base_url('uploads/')?>' + msg.sender_picture;

            const messageWrapper = document.createElement('div');
            messageWrapper.className = `w-full flex mb-3 ${isSentByCurrentUser ? 'justify-end' : 'justify-start'}`;

            const messageContainer = document.createElement('div');
            messageContainer.className = `flex items-start gap-2 max-w-md ${isSentByCurrentUser ? 'flex-row-reverse' : ''}`;

            const userImg = document.createElement('img');
            userImg.src = userPicture;
            userImg.alt = msg.sender_username;
            userImg.className = 'w-10 h-10 rounded-full flex-shrink-0';

            const bubbleWrapper = document.createElement('div');

            const messageBubble = document.createElement('div');
            messageBubble.className = `px-4 py-2 rounded-lg shadow-sm ${isSentByCurrentUser ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-900'}`;
            messageBubble.style.overflowWrap = 'break-word';
            messageBubble.innerHTML = msg.message_text.replace(/\n/g, '<br>');

            const metaInfo = document.createElement('div');
            metaInfo.className = `text-xs text-gray-400 mt-1 px-1 ${isSentByCurrentUser ? 'text-right' : 'text-left'}`;
            const localTime = formatTime(msg.created_at);
            metaInfo.textContent = `${isSentByCurrentUser ? 'Anda' : msg.sender_username} • ${localTime}`;

            bubbleWrapper.appendChild(messageBubble);
            bubbleWrapper.appendChild(metaInfo);
                
            messageContainer.appendChild(userImg);
            messageContainer.appendChild(bubbleWrapper);
                
            messageWrapper.appendChild(messageContainer);
            return messageWrapper;
        }

        async function fetchAndLoadMessages(options = {}) {
            const { offset = 0, sinceId = 0, prepend = false, isInitialLoad = false } = options;

            if (isLoading || (prepend && noMoreMessages)) {
                return;
            }

            isLoading = true;
            const oldScrollHeight = chatBox.scrollHeight;

            let url = (sinceId > 0)
                ? `<?= base_url('message/fetch_new/') ?>${recipientId}?since=${sinceId}`
                : `<?= base_url('message/fetch/') ?>${recipientId}?offset=${offset}`;

            try {
                const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await response.json();

                if (data.messages.length === 0) {
                    if (prepend) {
                        noMoreMessages = true;
                    }
                    return;
                }

                if (!prepend) {
                    const latestMessageInBatch = data.messages[data.messages.length - 1];
                    if (latestMessageInBatch.id > lastMessageId) {
                        lastMessageId = latestMessageInBatch.id;
                    }
                }

                const shouldAutoScroll = chatBox.scrollHeight - chatBox.clientHeight <= chatBox.scrollTop + 10;
                if (isInitialLoad) chatBox.innerHTML = '';

                const messagesToRender = prepend ? data.messages.reverse() : data.messages;

                messagesToRender.forEach(msg => {
                    const messageElement = createMessageElement(msg);
                    if (prepend) { 
                        chatBox.prepend(messageElement);
                    } else { 
                        chatBox.appendChild(messageElement);
                    }
                });

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
            if (chatBox.scrollTop < 5 && !isLoading && !noMoreMessages)  {
                const currentMessageCount = chatBox.children.length;
                fetchAndLoadMessages({ offset: currentMessageCount, prepend: true });
            }
        });

        chatForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const messageText = messageInput.value;
            if (messageText.trim() === '') return;

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

        fetchAndLoadMessages ({offset: 0, isInitialLoad: true });

        setInterval(() => {
            if (!isLoading) {
                fetchAndLoadMessages({ sinceId: lastMessageId });
            }   
        }, 3000);
    </script>
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
</body>
</html>
