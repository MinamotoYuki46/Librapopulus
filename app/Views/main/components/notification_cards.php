<?php if (empty($notifications)): ?>
    <p class="text-gray-500 text-center py-10">You have no new notifications.</p>
<?php else: ?>
    <?php foreach ($notifications as $notification): 
        $bgColor = $notification['read'] ? 'bg-white' : 'bg-blue-50'; ?>
        <div class="flex items-start p-4 rounded-lg shadow-sm mb-3 <?= $bgColor ?>">
            <img src="<?= htmlspecialchars($notification['sender']['avatar']) ?>" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
            <div class="flex-grow">
                <p class="text-gray-800">
                    <strong class="font-semibold"><?= htmlspecialchars($notification['sender']['name']) ?></strong>
                    <?php 
                        if ($notification['type'] === 'friend_request') {
                            echo 'sent you a friend request.';
                        } elseif ($notification['type'] === 'loan_request') {
                            echo 'sent you a loan request for <em>' . $notification['details']['book_title'] . '</em>.';
                        }
                    ?>
                </p>
                <p class="text-sm text-blue-600 font-semibold"><?= time_ago($notification['timestamp']) ?></p>
                <div class="mt-3 flex space-x-2">
                    <?php if ($notification['type'] === 'friend_request'): ?>
                        <a href="/handle_request.php?action=confirm&id=<?= $notification['id'] ?>" class="px-4 py-1.5 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600">Confirm</a>
                        <a href="/handle_request.php?action=delete&id=<?= $notification['id'] ?>" class="px-4 py-1.5 bg-gray-200 text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-300">Delete</a>
                    <?php elseif ($notification['type'] === 'loan_request'): ?>
                        <a href="/loan_details.php?id=<?= $notification['id'] ?>" class="px-4 py-1.5 bg-green-500 text-white text-sm font-semibold rounded-lg hover:bg-green-600">View Details</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>
