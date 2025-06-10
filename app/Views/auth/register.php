<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register - Librapopulus</title>
        <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .bg-library-register {
                background-image: linear-gradient(135deg, rgba(16, 185, 129, 0.8), rgba(59, 130, 246, 0.8)), 
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
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            }
            .password-strength {
                height: 4px;
                border-radius: 2px;
                transition: all 0.3s ease;
            }
            .progress-step {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .progress-step.active {
                background-color: #10b981;
                color: white;
            }
            .progress-step.completed {
                background-color: #10b981;
                color: white;
            }
            .progress-step.inactive {
                background-color: #e5e7eb;
                color: #6b7280;
            }
        </style>
    </head>
    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen">
            <div class="hidden lg:flex lg:w-1/2 bg-library-register relative">
                <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-12">
                    <div class="text-center max-w-md">
                        <div class="mb-8">
                            <i class="fas fa-user-plus text-6xl mb-4 opacity-90"></i>
                        </div>
                        <h2 class="text-4xl font-bold mb-4">Mari Bergabung</h2>
                        <p class="text-xl opacity-90 leading-relaxed mb-6">
                            Temukan teman dan buku barumu di komunitas pembaca
                        </p>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="max-w-md w-full">
                    <div class="flex items-center justify-center mb-8">
                        <div class="flex items-center space-x-4">
                            <div class="progress-step active">1</div>
                            <div class="h-1 w-12 bg-gray-300"></div>
                            <div class="progress-step inactive">2</div>
                            <div class="h-1 w-12 bg-gray-300"></div>
                            <div class="progress-step inactive">3</div>
                        </div>
                    </div>

                    <div class="lg:hidden text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <i class="fas fa-user-plus text-2xl text-green-600"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">Librapopulus</h1>
                    </div>

                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h1>
                        <p class="text-gray-600">Ayo bergabung ke komunitas dan baca bukunya</p>
                    </div>
                    
                    <?php 
                        $errors = session()->getFlashdata('errors');
                        $error  = session()->getFlashdata('error');
                    
                        if ($errors || $error):
                    ?>
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <?php if ($errors && is_array($errors)): ?>
                                        <ul class="text-sm text-red-700 list-disc pl-5 space-y-1">
                                            <?php foreach ($errors as $err): ?>
                                                <li><?= esc($err) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php elseif ($error): ?>
                                        <p class="text-sm text-red-700"><?= esc($error) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="glass-effect rounded-2xl shadow-xl p-8 border border-gray-200">
                        <form action="<?= base_url('auth/processRegister') ?>" method="post" class="space-y-5">  <?= csrf_field() ?>
                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    Username
                                </label>
                                <input type="text" id="username" name="username" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent input-focus transition-all duration-200"
                                    required>
                                <p class="text-xs text-gray-500 mt-1">Username ini akan muncul sebagai nama yang terlihat oleh pengguna lain</p>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                    Email
                                </label>
                                <input type="email" id="email" name="email" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent input-focus transition-all duration-200"
                                    required>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-gray-400"></i>
                                    Password
                                </label>
                                <div class="relative">
                                    <input type="password" id="password" name="password"
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent input-focus transition-all duration-200"
                                        required>
                                    <button type="button" id="togglePassword"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                        <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>

                                <div class="mt-2">
                                    <div class="password-strength bg-gray-200" id="passwordStrength"></div>
                                    <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter berupa kombinasi huruf, angka, dan simbol</p>
                                </div>
                            </div>

                            <div>
                                <label for="confirmPassword" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-gray-400"></i>
                                    Konfirmasi Password
                                </label>
                                <div class="relative">
                                    <input type="password" id="confirmPassword" name="confirmPassword"
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent input-focus transition-all duration-200"
                                        required>
                                    <button type="button" id="toggleConfirm"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                        <i class="fa-solid fa-eye" id="eyeIconConfirm"></i>
                                    </button>
                                </div>
                                <div id="passwordMatch" class="text-xs mt-1 hidden">
                                    <span class="text-red-500">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Password tidak cocok
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <input type="checkbox" id="terms" name="terms" required
                                    class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                <label for="terms" class="ml-3 text-sm text-gray-600">
                                    Saya setuju dengan 
                                    <a href="#" class="text-green-600 hover:text-green-700 font-medium">Syarat & Ketentuan</a> 
                                    dan 
                                    <a href="#" class="text-green-600 hover:text-green-700 font-medium">Kebijakan Privasi</a>
                                </label>
                            </div>
                            
                            <div>
                                <button type="submit" 
                                    class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
                                    <i class="fas fa-arrow-right mr-2"></i>
                                    Lanjutkan ke Profil
                                </button>
                            </div>
                        </form>
                        
                        <div class="mt-6 text-center">
                            <p class="text-gray-600">
                                Sudah punya akun? 
                                <a href="<?= base_url('auth/login') ?>" class="text-green-600 hover:text-green-700 font-semibold hover:underline transition-colors">
                                    Masuk di sini
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="text-center mt-8">
                        <a href="<?= base_url() ?>" class="inline-flex items-center text-gray-500 hover:text-green-600 text-sm font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke halaman utama
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="<?= base_url('assets/js/passStrength.js') ?>"> </script>
        <script src="<?= base_url('assets/js/showPass.js')?>"> </script>
    </body>
</html>
