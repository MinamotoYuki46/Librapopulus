<?php if (empty($notifications)): ?>
    <p class="text-gray-500 text-center py-10">Kamu tidak punya notifikasi baru.</p>
<?php else: ?>
    <?php foreach ($notifications as $notification): 
        $bgColor = !$notification['read'] ? 'bg-blue-50' : 'bg-white'; ?>
        <div class="flex items-start p-4 rounded-lg shadow-sm mb-3 <?= $bgColor ?>">
            <img src="<?= esc($notification['sender']['picture']) ?>" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
            <div class="flex-grow">
                <p class="text-gray-800">
                    <strong class="font-semibold"><?= esc($notification['sender']['name']) ?></strong>
                    <?php 
                        echo $notification['message'];
                    ?>
                </p>
                <p class="text-sm text-blue-600 font-semibold"><?= timeElapsed($notification['timestamp']) ?></p>
                <div class="mt-3 flex space-x-2">
                    <?php if ($notification['type'] === 'friend_request'): ?>
                        <form action="<?= base_url('friends/accept/' . $notification['related_id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="px-4 py-1.5 bg-blue-500 text-white text-sm font-semibold rounded-lg hover:bg-blue-600">Terima</button>
                        </form>
                        <form action="<?= base_url('friends/decline/' . $notification['related_id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="px-4 py-1.5 bg-gray-200 text-gray-800 text-sm font-semibold rounded-lg hover:bg-gray-300">Tolak</button>
                        </form>
                    <?php elseif ($notification['type'] === 'loan_request'): ?>
                        <a href= "<?= base_url('library/requested-loan/'. $notification['related_id']) ?>" class="px-4 py-1.5 bg-green-500 text-white text-sm font-semibold rounded-lg hover:bg-green-600">View Details</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php endif ?>