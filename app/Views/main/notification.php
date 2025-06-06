<?php
// =================================================================
//  1. PHP LOGIC SECTION
//  All data processing and helper functions are here.
// =================================================================

// --- DATA SIMULATION ---
// In a real application, you would connect to your database here
// and fetch the notifications for the logged-in user.
$notifications = [
    [
        'id' => 1,
        'type' => 'friend_request',
        'sender' => [
            'name' => 'Jane Doe',
            'avatar' => 'https://i.pravatar.cc/150?u=jane_doe'
        ],
        'timestamp' => strtotime('-2 hours'),
        'read' => false
    ],
    [
        'id' => 2,
        'type' => 'loan_request',
        'sender' => [
            'name' => 'John Smith',
            'avatar' => 'https://i.pravatar.cc/150?u=john_smith'
        ],
        'details' => [
            'book_title' => "Lord of The Rings"
        ],
        'timestamp' => strtotime('-1 day'),
        'read' => false
    ],
    [
        'id' => 3,
        'type' => 'friend_request',
        'sender' => [
            'name' => 'Peter Jones',
            'avatar' => 'https://i.pravatar.cc/150?u=peter_jones'
        ],
        'timestamp' => strtotime('-3 days'),
        'read' => true
    ],
];

// --- HELPER FUNCTION ---
// A function to create readable "time ago" strings from timestamps.
function time_ago($timestamp) {
    $diff = time() - $timestamp;
    if ($diff < 60) return $diff . 's ago';
    if ($diff < 3600) return floor($diff / 60) . 'm ago';
    if ($diff < 86400) return floor($diff / 3600) . 'h ago';
    return floor($diff / 86400) . 'd ago';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>

    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
</head>
<body class="bg-gray-100 min-h-screen">

    <main class="max-w-2xl mx-auto py-8 px-4 items-center" id="mainContent">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Notifications</h1>

        <?php
        // Check if there are any notifications to display
        if (empty($notifications)) {
            // Display a message if there are no notifications
            echo '<p class="text-gray-500 text-center py-10">You have no new notifications.</p>';
        } else {
            // Loop through each notification and display it as a card
            foreach ($notifications as $notification) {
                $bgColor = $notification['read'] ? 'bg-white' : 'bg-blue-50';
        ?>
                <div class="flex items-start p-4 rounded-lg shadow-sm mb-3 <?php echo $bgColor; ?>">
                    <img src="<?php echo htmlspecialchars($notification['sender']['avatar']); ?>" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
                    
                    <div class="flex-grow">
                        <p class="text-gray-800">
                            <strong class="font-semibold"><?php echo htmlspecialchars($notification['sender']['name']); ?></strong>
                            <?php 
                                if ($notification['type'] === 'friend_request') {
                                    echo 'sent you a friend request.';
                                } elseif ($notification['type'] === 'loan_request') {
                                    echo 'sent you a loan request for ' . $notification['details']['book_title'] . '.';
                                }
                            ?>
                        </p>
                        <p class="text-sm text-blue-600 font-semibold"><?php echo time_ago($notification['timestamp']); ?></p>
                        
                        <div class="mt-3 flex space-x-2">
                            <?php if ($notification['type'] === 'friend_request'): ?>
                                <a href="/handle_request.php?action=confirm&id=<?php echo $notification['id']; ?>" class="px-4 py-1.5 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600">Confirm</a>
                                <a href="/handle_request.php?action=delete&id=<?php echo $notification['id']; ?>" class="px-4 py-1.5 bg-gray-200 text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-300">Delete</a>
                            <?php elseif ($notification['type'] === 'loan_request'): ?>
                                <a href="/loan_details.php?id=<?php echo $notification['id']; ?>" class="px-4 py-1.5 bg-green-500 text-white text-sm font-semibold rounded-lg hover:bg-green-600">View Details</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php
            } // End of foreach loop
        } // End of else
        ?>
    </main>
</body>
</html>