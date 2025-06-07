document.querySelector('.fa-bell').parentElement.addEventListener('click', function() {
    console.log('Notifications clicked');
});


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

    notificationBtn.addEventListener('click', function (event) {
        event.stopPropagation();
        console.log('Notifications clicked');
        notificationOverlay.classList.toggle('hidden');
    });

    profileBtn.addEventListener('click', function (event) {
        event.stopPropagation(); // prevent bubbling to document
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
