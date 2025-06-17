<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 0; }
        .meta { text-align: center; font-size: 10px; margin-top: 0; }
    </style>
</head>
<body>
    <h2>Daftar Buku Librapopulus</h2>
    <p class="meta">Dicetak pada <?= date('d M Y, H:i') ?></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Terbit</th>
                <th>Halaman</th>
                <th>Deskripsi</th>
                <th>Genre</th>
                <!-- <th>Cover</th> -->
                <th>Ditambahkan</th>
                <th>Diubah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= esc($book['id']) ?></td>
                    <td><?= esc($book['title']) ?></td>
                    <td><?= esc($book['author']) ?></td>
                    <td><?= esc($book['published_date']) ?></td>
                    <td><?= esc($book['total_pages']) ?></td>
                    <td><?= esc($book['description']) ?></td>
                    <td><?= esc($book['genres']) ?></td>
                    <!-- <td><img src="<?= base_url('uploads/bookcover/' . $book['book_cover']) ?>" width="60" height="90"></td> -->
                    <!-- <td><img src="<?= base_url('uploads/bookcover/' . $book['book_cover']) ?>" alt="Cover" class="w-16 h-24 object-cover rounded"></td> -->
                    <td><?= date('d M Y, H:i', strtotime($book['created_at'])) ?></td>
                    <td><?= date('d M Y, H:i', strtotime($book['updated_at'])) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
