<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Anggota: <?= esc($group['name']) ?></title>
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">
    <meta name="csrf-token-hash" content="<?= csrf_hash() ?>">
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-[Inter]">
    <?php include __DIR__ . '/../layout/layout.php' ?>

    <main class="max-w-3xl mx-auto px-4 py-6">
        <div class="flex items-center mb-6">
            <a href="<?= base_url('group/chat/' . $group['slug']) ?>" class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left text-2xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Atur Anggota Grup: <?= esc($group['name']) ?></h1>
        </div>

        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="members-tabs" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="current-members-tab" data-tabs-target="#current-members" type="button" role="tab" aria-controls="current-members" aria-selected="true">Anggota Saat Ini</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="add-new-member-tab" data-tabs-target="#add-new-member" type="button" role="tab" aria-controls="add-new-member" aria-selected="false">Tambah Anggota</button>
                </li>
            </ul>
        </div>

        <div id="members-tabs-content">
            <div class="hidden p-4 rounded-lg bg-white shadow" id="current-members" role="tabpanel" aria-labelledby="current-members-tab">
                <div id="group-members-list" class="max-h-[70vh] overflow-y-auto">
                    <p class="text-center text-gray-500">Memuat anggota...</p>
                </div>
            </div>

            <div class="hidden p-4 rounded-lg bg-white shadow" id="add-new-member" role="tabpanel" aria-labelledby="add-new-member-tab">
                <form id="add-member-form">
                    <?= csrf_field() ?>
                    <div class="mb-4">
                        <label for="search-member-username-input" class="block text-sm font-medium text-gray-700">Cari Pengguna (Username):</label>
                        <input type="text" id="search-member-username-input" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Ketik username...">
                        <input type="hidden" id="selected-add-user-id" name="user_id">
                        <div id="search-username-suggestions" class="absolute bg-white border border-gray-300 rounded-md shadow-lg w-full z-20 hidden"></div>
                    </div>
                    <div class="flex justify-end mt-4">
                        <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <i class="fas fa-user-plus mr-2"></i> Tambah ke Grup
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <div id="confirm-remove-member-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Konfirmasi Pengeluaran Anggota
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="confirm-remove-member-modal">
                        <i class="fas fa-times"></i>
                        <span class="sr-only">Tutup</span>
                    </button>
                </div>
                <div class="p-4 md:p-5">
                    <p class="text-base leading-relaxed text-gray-600">
                        Apakah Anda yakin ingin mengeluarkan <strong id="member-to-remove-username"></strong> dari grup ini? Aksi ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                    <button id="confirm-remove-member-button" data-modal-hide="confirm-remove-member-modal" type="button" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Ya, saya yakin
                    </button>
                    <button data-modal-hide="confirm-remove-member-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="<?= base_url("flowbite.min.js") ?>"></script>
    <script>
        // Data PHP yang diteruskan ke JavaScript
        const currentGroupId = <?= esc($group['id']) ?>;
        const currentGroupSlug = '<?= esc($group['slug']) ?>'; // Pastikan ini tersedia
        const currentUserId = <?= esc($masterUserId) ?>;
        const currentUserRole = '<?= esc($currentUserRole) ?>'; // Peran user saat ini di grup ini (member/admin/creator)

        // Elemen DOM
        const groupMembersList = document.getElementById('group-members-list');
        const searchMemberUsernameInput = document.getElementById('search-member-username-input');
        const selectedAddUserIdInput = document.getElementById('selected-add-user-id');
        const searchUsernameSuggestions = document.getElementById('search-username-suggestions');
        const addMemberForm = document.getElementById('add-member-form');

        // Modal konfirmasi hapus anggota
        const confirmRemoveMemberModalElement = document.getElementById('confirm-remove-member-modal');
        const confirmRemoveMemberButton = document.getElementById('confirm-remove-member-button');
        const memberToRemoveUsernameSpan = document.getElementById('member-to-remove-username');

        // CSRF Token Global
        const csrfTokenName = document.querySelector('meta[name="csrf-token-name"]').getAttribute('content');
        let csrfHash = document.querySelector('meta[name="csrf-token-hash"]').getAttribute('content');

        // --- GLOBAL UTILITIES ---
        function updateAllCsrfTokens(newToken) {
            const csrfMetaTag = document.querySelector('meta[name="csrf-token-hash"]');
            if (csrfMetaTag) {
                csrfMetaTag.setAttribute('content', newToken);
            }
            document.querySelectorAll(`input[name="${csrfTokenName}"]`).forEach(input => {
                input.value = newToken;
            });
            csrfHash = newToken;
            console.log('Semua token CSRF di form HTML dan meta tag telah diperbarui:', newToken);
        }

        // --- GROUP MEMBER CRUD RELATED FUNCTIONS ---

        // READ: Mengambil dan Menampilkan Anggota Grup
        async function fetchGroupMembers() {
            groupMembersList.innerHTML = '<p class="text-center text-gray-500">Memuat anggota...</p>';
            try {
                const response = await fetch(`<?= base_url('api/groups/') ?>${currentGroupId}/members`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();

                if (data.csrf_hash) {
                    updateAllCsrfTokens(data.csrf_hash);
                }

                if (response.ok && data.status === 'success') {
                    renderGroupMembers(data.data);
                } else {
                    groupMembersList.innerHTML = `<p class="text-red-500 text-center">${data.message || 'Gagal memuat anggota.'}</p>`;
                }
            } catch (error) {
                console.error('Error fetching group members:', error);
                groupMembersList.innerHTML = `<p class="text-red-500 text-center">Terjadi kesalahan saat memuat anggota.</p>`;
            }
        }

        function renderGroupMembers(members) {
            groupMembersList.innerHTML = '';
            if (members.length === 0) {
                groupMembersList.innerHTML = '<p class="text-center text-gray-500">Belum ada anggota di grup ini.</p>';
                return;
            }

            members.forEach(member => {
                const memberElement = document.createElement('div');
                memberElement.className = 'flex items-center justify-between p-3 border-b border-gray-200 last:border-b-0';
                memberElement.innerHTML = `
                    <div class="flex items-center">
                        <img src="<?= base_url('uploads/') ?>${member.picture}" class="w-10 h-10 rounded-full mr-3 object-cover" alt="${member.username}">
                        <div>
                            <p class="font-semibold text-gray-900">${member.username} ${member.user_id == currentUserId ? '<span class="text-blue-500">(Anda)</span>' : ''}</p>
                            <span class="text-sm text-gray-500 capitalize">${member.role}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        ${(currentUserRole === 'admin' || currentUserRole === 'creator') && member.user_id != currentUserId && member.role !== 'creator' ? `
                            <div class="relative inline-block text-left">
                                <button type="button" data-dropdown-toggle="role-dropdown-${member.user_id}" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                                    Ubah Peran <i class="fas fa-chevron-down ml-2 -mr-1 text-sm"></i>
                                </button>
                                <div id="role-dropdown-${member.user_id}" class="origin-top-right absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10 hidden">
                                    <div class="py-1" role="none">
                                        <a href="#" onclick="updateMemberRole(${member.user_id}, 'member'); return false;" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 ${member.role === 'member' ? 'font-bold' : ''}">Member</a>
                                        ${currentUserRole === 'creator' ? `
                                            <a href="#" onclick="updateMemberRole(${member.user_id}, 'admin'); return false;" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100 ${member.role === 'admin' ? 'font-bold' : ''}">Admin</a>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                            <button onclick="prepareRemoveMember(${member.user_id}, '${member.username}'); return false;" 
                                    data-modal-target="confirm-remove-member-modal"
                                    data-modal-toggle="confirm-remove-member-modal"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                <i class="fas fa-times mr-1"></i>Keluarkan
                            </button>
                        ` : ''}
                    </div>
                `;
                groupMembersList.appendChild(memberElement);
            });

            // Re-inisialisasi Flowbite untuk dropdown yang baru ditambahkan
            if (typeof initFlowbite === 'function') {
                initFlowbite();
            }
        }

        // --- CREATE: Menambahkan Anggota ---

        let searchUserTimeout;
        searchMemberUsernameInput.addEventListener('input', () => {
            clearTimeout(searchUserTimeout);
            const query = searchMemberUsernameInput.value.trim();
            if (query.length < 3) {
                searchUsernameSuggestions.innerHTML = '';
                searchUsernameSuggestions.classList.add('hidden');
                selectedAddUserIdInput.value = '';
                return;
            }

            searchUserTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`<?= base_url('api/users/search') ?>?q=${encodeURIComponent(query)}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();

                    if (data.csrf_hash) {
                        updateAllCsrfTokens(data.csrf_hash);
                    }

                    if (response.ok && data.status === 'success') {
                        renderUserSuggestions(data.data);
                    } else {
                        searchUsernameSuggestions.innerHTML = '<div class="p-2 text-gray-500">Tidak ada hasil.</div>';
                        searchUsernameSuggestions.classList.remove('hidden');
                    }
                } catch (error) {
                    console.error('Error searching users:', error);
                    searchUsernameSuggestions.innerHTML = '<div class="p-2 text-red-500">Terjadi kesalahan.</div>';
                    searchUsernameSuggestions.classList.remove('hidden');
                }
            }, 300); // Debounce
        });

        function renderUserSuggestions(users) {
            searchUsernameSuggestions.innerHTML = '';
            if (users.length === 0) {
                searchUsernameSuggestions.innerHTML = '<div class="p-2 text-gray-500">Tidak ada hasil.</div>';
                searchUsernameSuggestions.classList.remove('hidden');
                return;
            }

            users.forEach(user => {
                const suggestionItem = document.createElement('div');
                suggestionItem.className = 'p-2 cursor-pointer hover:bg-gray-100';
                suggestionItem.textContent = `${user.username} (${user.email || 'No Email'})`;
                suggestionItem.setAttribute('data-user-id', user.id);
                suggestionItem.addEventListener('click', () => {
                    searchMemberUsernameInput.value = user.username;
                    selectedAddUserIdInput.value = user.id;
                    searchUsernameSuggestions.classList.add('hidden');
                });
                searchUsernameSuggestions.appendChild(suggestionItem);
            });
            searchUsernameSuggestions.classList.remove('hidden');
        }

        document.addEventListener('click', (event) => {
            if (!searchMemberUsernameInput.contains(event.target) && !searchUsernameSuggestions.contains(event.target)) {
                searchUsernameSuggestions.classList.add('hidden');
            }
        });

        addMemberForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const userIdToAdd = selectedAddUserIdInput.value;
            if (!userIdToAdd) {
                alert('Silakan pilih pengguna dari saran.');
                return;
            }

            const formData = new FormData();
            formData.append('user_id', userIdToAdd);
            formData.append(csrfTokenName, csrfHash);

            try {
                const response = await fetch(`<?= base_url('api/groups/') ?>${currentGroupId}/members/add`, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();

                if (data.csrf_hash) {
                    updateAllCsrfTokens(data.csrf_hash);
                }

                if (response.ok && data.status === 'success') {
                    alert(data.message);
                    fetchGroupMembers(); // Muat ulang daftar anggota di halaman ini
                    searchMemberUsernameInput.value = '';
                    selectedAddUserIdInput.value = '';
                    searchUsernameSuggestions.innerHTML = '';
                    searchUsernameSuggestions.classList.add('hidden');
                    
                    // Pindah kembali ke tab "Anggota Saat Ini" setelah berhasil menambah
                    const currentMembersTabBtn = document.getElementById('current-members-tab');
                    if (currentMembersTabBtn) {
                        currentMembersTabBtn.click(); // Flowbite tabs should handle this
                    }
                } else {
                    alert(data.message || 'Gagal menambahkan anggota.');
                }
            } catch (error) {
                console.error('Error adding member:', error);
                alert('Terjadi kesalahan saat menambahkan anggota.');
            }
        });

        // --- UPDATE: Mengubah Peran Anggota ---
        async function updateMemberRole(userId, newRole) {
            if (!confirm(`Apakah Anda yakin ingin mengubah peran pengguna ini menjadi "${newRole}"?`)) {
                return;
            }

            const formData = new FormData();
            formData.append('role', newRole);
            formData.append(csrfTokenName, csrfHash);

            try {
                const response = await fetch(`<?= base_url('api/groups/') ?>${currentGroupId}/members/${userId}/update_role`, {
                    method: 'POST', 
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();

                if (data.csrf_hash) {
                    updateAllCsrfTokens(data.csrf_hash);
                }

                if (response.ok && data.status === 'success') {
                    alert(data.message);
                    fetchGroupMembers(); // Muat ulang daftar anggota
                } else {
                    alert(data.message || 'Gagal memperbarui peran anggota.');
                }
            } catch (error) {
                console.error('Error updating member role:', error);
                alert('Terjadi kesalahan saat memperbarui peran anggota.');
            }
        }

        // --- DELETE: Mengeluarkan Anggota ---
        function prepareRemoveMember(userId, username) {
            memberToRemoveUsernameSpan.textContent = username;
            confirmRemoveMemberButton.setAttribute('data-member-id', userId);
            // Modal akan dibuka oleh data-modal-target/toggle di HTML button
        }

        confirmRemoveMemberButton.addEventListener('click', async () => {
            const userIdToRemove = confirmRemoveMemberButton.getAttribute('data-member-id');
            if (!userIdToRemove) return;

            const formData = new FormData();
            formData.append(csrfTokenName, csrfHash);
            formData.append('_method', 'DELETE'); // Spoofing DELETE method

            try {
                const response = await fetch(`<?= base_url('api/groups/') ?>${currentGroupId}/members/${userIdToRemove}/remove`, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();

                if (data.csrf_hash) {
                    updateAllCsrfTokens(data.csrf_hash);
                }

                if (response.ok && data.status === 'success') {
                    alert(data.message);
                    fetchGroupMembers(); // Muat ulang daftar anggota
                    // Tutup modal konfirmasi hapus anggota
                    // Flowbite akan menangani penutupan karena data-modal-hide="confirm-remove-member-modal"
                } else {
                    alert(data.message || 'Gagal mengeluarkan anggota.');
                }
            } catch (error) {
                console.error('Error removing member:', error);
                alert('Terjadi kesalahan saat mengeluarkan anggota.');
            }
        });

        // --- INITIALIZATION ---
        document.addEventListener('DOMContentLoaded', () => {
            fetchGroupMembers(); // Panggil saat halaman dimuat

            // Inisialisasi Flowbite (untuk tabs dan dropdown di halaman ini)
            if (typeof initFlowbite === 'function') {
                initFlowbite();
                console.log('Flowbite telah diinisialisasi pada group_members_view.php.');
            }
        });
    </script>
</body>
</html>