<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Library System</title>
        <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            .bg-library {
                background-image: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(147, 51, 234, 0.8)), 
                                url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            .glass-effect {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
            }
            .input-focus:focus {
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }
        </style>
    </head>
    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen">

            <div class="hidden lg:flex lg:w-1/2 bg-library relative">
                <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-12">
                    <div class="text-center max-w-md">
                        <div class="mb-8">
                            <i class="fas fa-book-open text-6xl mb-4 opacity-90"></i>
                        </div>
                        <h2 class="text-4xl font-bold mb-4">Selamat datang di Librapopulus</h2>
                        <p class="text-xl opacity-90 leading-relaxed">
                            Masuk untuk mulai menjelajahi koleksi buku dan terhubung dengan teman
                        </p>
                        <div class="mt-8 flex justify-center space-x-6 text-sm opacity-80">
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="max-w-md w-full">

                    <div class="lg:hidden text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                            <i class="fas fa-book-open text-2xl text-blue-600"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">Librapopulus</h1>
                    </div>


                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Masuk ke Akunmu</h1>
                        <p class="text-gray-600">Selamat datang</p>
                    </div>
                    
                    <?php if(session() -> getFlashdata('error')): ?>
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        <?= session() -> getFlashdata('error') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="glass-effect rounded-2xl shadow-xl p-8 border border-gray-200">
                        <form action="<?= base_url('auth/processLogin') ?>" method="post" class="space-y-6">  <?= csrf_field() ?>

                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    Username atau Email
                                </label>
                                <input type="text" id="username" name="identity" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent input-focus transition-all duration-200"
                                    required>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-gray-400"></i>
                                    Password
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password"
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent input-focus transition-all duration-200"
                                        required>
                                    <button type="button" id="togglePassword"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                        <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                            </div>
                            

                            <div>
                                <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Masuk
                                </button>
                            </div>
                        </form>
                        
                        <!-- Register Link -->
                        <div class="mt-6 text-center">
                            <p class="text-gray-600">
                                Belum punya akun? 
                                <a href="<?= base_url('auth/register') ?>" class="text-blue-600 hover:text-blue-700 font-semibold hover:underline transition-colors">
                                    Daftar sekarang!
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Back to Home -->
                    <div class="text-center mt-8">
                        <a href="<?= base_url() ?>" class="inline-flex items-center text-gray-500 hover:text-blue-600 text-sm font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke halaman utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?= base_url('assets/js/showPass.js')?>"></script>
    </body>
</html>