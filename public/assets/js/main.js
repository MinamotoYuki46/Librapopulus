document.querySelectorAll('.book-card').forEach(card => {
    card.addEventListener('click', function() {
        const bookId = this.getAttribute('data-book-id');
        console.log('Book clicked:', bookId);
    });
});

// Add click handlers for discussion cards
document.querySelectorAll('.discussion-card').forEach(card => {
    card.addEventListener('click', function() {
        const discussionId = this.getAttribute('data-discussion-id');
        // Redirect to discussion details or handle click
        console.log('Discussion clicked:', discussionId);
        // window.location.href = `<?= base_url('discussions/') ?>${discussionId}`;
    });
});

// Handle header button clicks
document.querySelector('.fa-search').parentElement.addEventListener('click', function() {
    // Handle search button click
    console.log('Search clicked');
    // window.location.href = '<?= base_url('search') ?>';
});

document.querySelector('.fa-bell').parentElement.addEventListener('click', function() {
    // Handle notification button click
    console.log('Notifications clicked');
    // window.location.href = '<?= base_url('notifications') ?>';
});

document.querySelector('.fa-user-circle').parentElement.addEventListener('click', function() {
    // Handle profile button click
    console.log('Profile clicked');
    // window.location.href = '<?= base_url('profile') ?>';
});

function toggleNotifications(event) {
    event?.stopPropagation();
    const overlay = document.getElementById('notificationOverlay');
    if (overlay) {
        overlay.classList.toggle('hidden');
    }
}
