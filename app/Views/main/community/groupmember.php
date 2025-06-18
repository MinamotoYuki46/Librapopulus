<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Anggota Grup <?= esc($group['name']) ?></title>
    <link href="<?= base_url('assets/css/tailwind.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <?php include __DIR__ . '/../layout/layout.php' ?>
    <div class="flex justify-center py-6">
        
        <div class="w-full max-w-md bg-white rounded-xl shadow-md p-4">
            <div class="mb-4">
                <a href="<?= base_url('group/' . $group['slug']) ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="flex flex-col items-center text-center mb-6">
                <img src="<?= base_url('uploads/groups/' . $group['icon']) ?>" alt="Logo Grup"
                    class="w-28 h-28 rounded-full object-cover shadow-md mb-3">

                <h2 class="text-3xl font-bold text-gray-800"><?= esc($group['name']) ?></h2>

                <p class="text-lg text-gray-500 mt-1"><?= count($members) ?> anggota</p>

                <p class="text-lg text-gray-600 mt-2 px-4"><?= esc($group['description']) ?></p>
            </div>

            <?php if ($isCurrentUserAdmin): ?>
                <div class="flex justify-center my-6">
                    <a href="<?= base_url('group/invite-members/' . $group['slug']) ?>"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-blue-700 transition">
                        <i class="fa-solid fa-user-plus mr-2"></i> Tambah Anggota
                    </a>
                </div>
            <?php endif ?>

            <div class="space-y-5">
                <?php foreach ($members as $member): ?>
                    <div class="flex items-center justify-between hover:bg-gray-100 px-4 py-4 rounded-xl shadow-sm transition">
                        <a href="<?= base_url('profile/' . $member['username']) ?>" class="flex items-center gap-4">
                            <img src="<?= base_url('uploads/users/' . $member['picture']) ?>" alt="Foto Profil"
                                class="w-14 h-14 rounded-full object-cover shadow-md">

                            <div class="flex flex-col">
                                <span class="text-base font-semibold text-gray-800"><?= esc($member['username']) ?></span>
                                <span class="text-sm text-gray-500"><?= esc($member['full_name']) ?></span>
                            </div>
                        </a>

                        <div class="flex items-center gap-3">
                            <?php if ($member['role'] == 'creator' ): ?>
                                <span class="bg-green-200 text-green-800 text-sm px-3 py-1 rounded-full font-semibold shadow-sm">Owner</span>
                            <?php elseif ($member['role'] == 'admin'): ?>
                                <span class="bg-yellow-200 text-yellow-800 text-sm px-3 py-1 rounded-full font-semibold shadow-sm">Admin</span>
                            <?php endif ?>


                            <?php if ($isCurrentUserAdmin && $member['user_id'] !== $masterUserId && $member['role'] !== 'creator'): ?>
                                <button id="dropdownButton-<?= $member['user_id'] ?>" data-dropdown-toggle="dropdown-<?= $member['user_id'] ?>"
                                        class="text-gray-700 hover:text-gray-900 text-xl font-bold px-2">
                                    ⋮
                                </button>

                                <div id="dropdown-<?= $member['user_id'] ?>" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-md w-48">
                                    <ul class="py-2 text-sm text-gray-700">
                                        <?php if ($member['role'] === 'member'): ?>
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 action-button" 
                                                data-action="promote" 
                                                data-action-type="promote" data-url="<?= base_url('group/' . $group['id'] . '/promote/' . $member['user_id']) ?>"
                                                data-message="Anda yakin ingin mempromosikan <?= esc($member['username']) ?> menjadi admin?">
                                                    Promosikan jadi admin
                                                </a>
                                            </li>
                                        <?php endif ?>

                                        <?php if ($member['role'] === 'admin' && $currentUserRole === 'creator'): ?>
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 action-button" 
                                                data-action="demote" 
                                                data-action-type="demote" data-url="<?= base_url('group/' . $group['id'] . '/demote/' . $member['user_id']) ?>"
                                                data-message="Anda yakin ingin menurunkan <?= esc($member['username']) ?> menjadi member?">
                                                    Turunkan jadi member
                                                </a>
                                            </li>
                                        <?php endif ?>

                                        <?php if ($member['role'] !== 'creator'): ?>
                                            <li>
                                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-red-600 action-button" 
                                                data-action="kick" 
                                                data-action-type="kick" data-url="<?= base_url('group/' . $group['id'] . '/kick/' . $member['user_id']) ?>"
                                                data-message="Anda yakin ingin mengeluarkan <?= esc($member['username']) ?> dari grup?">
                                                    Keluarkan
                                                </a>
                                            </li>
                                        <?php endif ?>
                                    </ul>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <script src="<?= base_url("flowbite.min.js") ?>"></script>

    <div id="confirmationModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto bg-black/50 h-full">
        <div class="relative w-full max-w-md mx-auto mt-24">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 text-center">
                    <h3 class="mb-5 text-lg font-normal text-gray-700" id="modalMessage"></h3> <form id="confirmationForm" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Ya, lanjutkan
                        </button>
                        <button type="button" data-modal-hide="confirmationModal" class="text-gray-700 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm font-medium px-5 py-2.5">
                            Batal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmationModalElement = document.getElementById('confirmationModal');
            const confirmationModal = new Modal(confirmationModalElement);
            const modalMessage = document.getElementById('modalMessage');
            const confirmationForm = document.getElementById('confirmationForm');
            const confirmButton = confirmationForm.querySelector('button[type="submit"]');

            function updateConfirmButtonColor(actionType) {
                confirmButton.classList.remove('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-300');
                confirmButton.classList.remove('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-300');

                if (actionType === 'promote') {
                    confirmButton.classList.add('bg-green-600', 'hover:bg-green-700', 'focus:ring-green-300');
                } else if (actionType === 'demote' || actionType === 'kick') {
                    confirmButton.classList.add('bg-red-600', 'hover:bg-red-700', 'focus:ring-red-300');
                }
            }

            document.querySelectorAll('.action-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); 
                    const actionUrl = this.dataset.url;
                    const message = this.dataset.message;
                    const actionType = this.dataset.actionType;

                    confirmationForm.setAttribute('action', actionUrl);
                    modalMessage.innerHTML = message;

                    updateConfirmButtonColor(actionType);
                    
                    confirmationModal.show();
                });
            });
        });
    </script>
</body>
</html>