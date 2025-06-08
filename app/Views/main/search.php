<?php
// Dummy data
$users = [
    ['name' => 'Alice Johnson', 'avatar' => 'https://i.pravatar.cc/100?u=alice'],
    ['name' => 'Bob Smith', 'avatar' => 'https://i.pravatar.cc/100?u=bob'],
    ['name' => 'Charlie Davis', 'avatar' => 'https://i.pravatar.cc/100?u=charlie'],
];

$books = [
    ['title' => 'Harry Potter and the Chamber of Secrets', 'author' => 'J.K. Rowling'],
    ['title' => 'The Hobbit', 'author' => 'J.R.R. Tolkien'],
    ['title' => '1984', 'author' => 'George Orwell'],
];

// Handle search query
$query = $_GET['query'] ?? '';
$userResults = [];
$bookResults = [];

if ($query) {
    $queryLower = strtolower($query);

    $userResults = array_filter($users, fn($u) =>
        str_contains(strtolower($u['name']), $queryLower)
    );

    $bookResults = array_filter($books, fn($b) =>
        str_contains(strtolower($b['title']), $queryLower)
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     
</head>
<body class="bg-gray-50 min-h-screen px-4 py-8">
    <?php include 'layout/header.php' ?>
    <main class="px-6 pb-6 py-6" id="mainContent">

        <div class="max-w-3xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-center">Cari</h1>
            
            <form method="GET" action="<?= site_url('search') ?>" class="flex mb-6">
                <input 
                    type="text" 
                    name="query" 
                    value="<?= htmlspecialchars($query) ?>" 
                    placeholder="Search for users or books..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 transition"
                >
                Search
                </button>
            </form>

            <?php if ($query): ?>
                <p class="mb-4 text-gray-600">Showing results for "<strong><?= htmlspecialchars($query) ?></strong>":</p>
                
                <?php if (count($userResults) === 0 && count($bookResults) === 0): ?>
                    <p class="text-red-500 mb-8">No results found.</p>
                    <?php else: ?>

                        <?php if ($userResults): ?>
                            <h2 class="text-xl font-semibold mb-3">Users</h2>
                        <div class="space-y-4 mb-8">
                            <?php foreach ($userResults as $user): ?>
                                <div class="flex items-center bg-white p-4 shadow rounded-lg">
                                    <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="w-12 h-12 rounded-full mr-4">
                                    <p class="text-gray-800 font-medium"><?= htmlspecialchars($user['name']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($bookResults): ?>
                        <h2 class="text-xl font-semibold mb-3">Books</h2>
                        <div class="space-y-4">
                            <?php foreach ($bookResults as $book): ?>
                                <div class="bg-white p-4 shadow rounded-lg">
                                    <h3 class="text-lg font-semibold"><?= htmlspecialchars($book['title']) ?></h3>
                                    <p class="text-gray-600">Author: <?= htmlspecialchars($book['author']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'layout/navbar.php' ?>
</body>
</html>
