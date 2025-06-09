function toggleNotifications(event) {
    event?.stopPropagation();
    const overlay = document.getElementById('notificationOverlay');
    if (overlay) {
        overlay.classList.toggle('hidden');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    const notificationBtn = document.querySelector('.fa-bell').parentElement;
    const notificationOverlay = document.getElementById('notificationOverlay');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    notificationBtn.addEventListener('click', async function (event) {
        event.stopPropagation();
        console.log('Notifications clicked');
        const isHidden = notificationOverlay.classList.toggle('hidden');
        // notificationOverlay.classList.toggle('hidden');


        if (!isHidden){
            console.log('Starting fetch...');
            try {
                const response = await fetch ("<?= base_url('notification/mark-read') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({})
                });

                if (response.ok){
                    console.log("Notifikasi telah dibaca");

                    const badge = notificationBtn.querySelector("span");
                    if (badge) badge.remove();
                }
                else {
                    console.error("Gagal menandai notifikasi");
                }
            } catch (error) {
                console.error("Gagal fetch", error);
                
            }
        }
    });

    profileBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        profileDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function (e) {
        if (!profileBtn.contains(e.target)) {
            profileDropdown.classList.add('hidden');
        }

        if (!notificationOverlay.contains(e.target) && !notificationBtn.contains(e.target)) {
            notificationOverlay.classList.add('hidden');
        }
    });
});
