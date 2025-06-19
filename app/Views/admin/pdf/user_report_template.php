<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>

    <h2>Laporan Pengguna Librapopulus: Tidak Mengembalikan Buku</h2>
    <p class="meta">Dicetak pada <?= date('d M Y, H:i') ?></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Email Peminjam</th>
                <th>Email Pemilik</th>
                <th>Keteragan</th>
                <th>Tanggal Laporan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= esc($report['id']) ?></td>
                    <td><?= esc($report['book_title']) ?></td>
                    <td><?= esc($report['borrower_email']) ?></td>
                    <td><?= esc($report['owner_email']) ?></td>
                    <td><?= esc($report['message']) ?></td>
                    <td><?= date('d M Y, H:i', strtotime($report['created_at'])) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
