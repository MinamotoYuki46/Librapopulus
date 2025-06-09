<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>

    <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">

    <header class="fixed top-0 left-0 right-0 z-50 bg-red-200/90 backdrop-blur-sm border-b border-white/40 shadow-sm px-6 py-4 flex justify-between items-center md:pl-20">
        <div class="text-2xl font-bold felx space-x-2">
            Dashboard Admin Librapopulus
        </div>
        <div class="flex items-center space-x-4 relative">
            Laporan Pengguna
        </div>
    </header>

    <div class="h-[88px]"></div>


    <main class="px-6 pb-6 py-6" id="mainContent">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Laporan Pengguna</h2>

            <!-- Tabel Laporan Pengguna -->
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200 text-sm">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Username</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Jumlah Buku</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh baris data (bisa diganti dengan loop PHP) -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">1</td>
                            <td class="px-4 py-2 border">andiputra</td>
                            <td class="px-4 py-2 border">andi@example.com</td>
                            <td class="px-4 py-2 border text-center">12</td>
                            <td class="px-4 py-2 border text-green-600 text-center">Aktif</td>
                            <td class="px-4 py-2 border text-center space-x-2">
                                <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded text-xs">Detail</a>
                                <a href="#" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">Blokir</a>
                            </td>
                        </tr>
                        <!-- Tambah data lainnya di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>