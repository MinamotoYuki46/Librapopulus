<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Librapopulus - Aplikasi Peminjaman Buku</title>
        <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <!-- Inter Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            .hero-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .floating-animation {
                animation: float 6s ease-in-out infinite;
            }
            .floating-animation:nth-child(2) {
                animation-delay: -2s;
            }
            .floating-animation:nth-child(3) {
                animation-delay: -4s;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .glass-card {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="bg-gray-50">
        <nav class="absolute top-0 w-full z-50 px-6 py-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-lg">
                        <i class="fas fa-book-open text-purple-600 text-lg"></i>
                    </div>
                    <span class="text-white font-bold text-xl">Librapopulus</span>
                </div>
            </div>
        </nav>

        <section class="hero-gradient min-h-screen flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="floating-animation absolute top-20 left-10 opacity-20">
                    <i class="fas fa-book text-6xl text-white"></i>
                </div>
                <div class="floating-animation absolute top-40 right-20 opacity-20">
                    <i class="fas fa-book-open text-5xl text-white"></i>
                </div>
                <div class="floating-animation absolute bottom-32 left-1/4 opacity-20">
                    <i class="fas fa-graduation-cap text-4xl text-white"></i>
                </div>
                <div class="floating-animation absolute top-60 right-1/3 opacity-20">
                    <i class="fas fa-scroll text-5xl text-white"></i>
                </div>
            </div>

            <div class="max-w-6xl mx-auto px-6 text-center relative z-10">
                <div class="mb-12">
                    <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                        Selamat datang di
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">
                            Librapopulus
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
                        Platform pinjam buku antar anggota.
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
                    <a href="<?= site_url('auth/login') ?>" 
                       class="group px-8 py-4 bg-white text-purple-600 font-semibold rounded-xl hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 shadow-xl">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="<?= site_url('auth/register') ?>" 
                       class="group px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-xl hover:bg-white hover:text-purple-600 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <!-- Features Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="glass-card rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-exchange-alt text-3xl text-white mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Saling meminjam</h3>
                        <p class="text-white/80 text-sm">Pinjamkan bukumu kepada anggota lain</p>
                    </div>
                    <div class="glass-card rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-users text-3xl text-white mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Komunitas</h3>
                        <p class="text-white/80 text-sm">Gabung komunitas dan para pecinta buku lainnya</p>
                    </div>
                    <div class="glass-card rounded-2xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                        <i class="fas fa-star text-3xl text-white mb-4"></i>
                        <h3 class="text-xl font-semibold text-white mb-2">Ulasan</h3>
                        <p class="text-white/80 text-sm"> Temukan buku bagus berdasarkan rekomendasi komunitas</p>
                    </div>
                </div>
            </div>

            <!-- Footer (Inside Hero Section) -->
            <div class="absolute bottom-0 left-0 right-0 bg-black/30 backdrop-blur-sm py-4">
                <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book-open text-white text-sm"></i>
                        </div>
                        <span class="text-white font-bold text-sm">Librapopulus</span>
                    </div>
                    <p class="text-white/70 text-sm">&copy; 2025 Librapopulus - Membuka pengetahuan, membangun komunitas</p>
                </div>
            </div>
        </section>

        <script>
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('nav');
                if (window.scrollY > 100) {
                    nav.classList.add('bg-white/10', 'backdrop-blur-md');
                } else {
                    nav.classList.remove('bg-white/10', 'backdrop-blur-md');
                }
            });
        </script>
    </body>
</html>