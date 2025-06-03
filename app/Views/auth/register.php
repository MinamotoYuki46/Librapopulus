<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register - Librapopulus</title>
        <link href="<?= base_url('assets/css/tailwind.css')?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <!-- Inter Font -->
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
        </style>
    </head>
    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen">
            <!-- Left Side - Image/Illustration -->
            <div class="hidden lg:flex lg:w-1/2 bg-library-register relative">
                <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-12">
                    <div class="text-center max-w-md">
                        <div class="mb-8">
                            <i class="fas fa-user-plus text-6xl mb-4 opacity-90"></i>
                        </div>
                        <h2 class="text-4xl font-bold mb-4">Join Our Community</h2>
                    </div>
                </div>
            </div>

            <!-- Right Side - Register Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="max-w-md w-full">
                    <!-- Mobile Header (visible on small screens) -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <i class="fas fa-user-plus text-2xl text-green-600"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">Librapopulus</h1>
                    </div>

                    <!-- Register Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Make New Account</h1>
                        <p class="text-gray-600">Join our community and read the books</p>
                    </div>
                    
                    <!-- Error Message -->
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        <?= session()->getFlashdata('error') ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Register Form -->
                    <div class="glass-effect rounded-2xl shadow-xl p-8 border border-gray-200">
                        <form action="<?= base_url('auth/processRegister') ?>" method="post" class="space-y-5">
                            <!-- Username Field -->
                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                    Username
                                </label>
                                <input type="text" id="username" name="username" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent input-focus transition-all duration-200"
                                    required>
                                <p class="text-xs text-gray-500 mt-1">This username will be used for log in</p>
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                    Email
                                </label>
                                <input type="email" id="email" name="email" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent input-focus transition-all duration-200"
                                    required>
                            </div>

                            <!-- Password Field -->
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
                                <!-- Password Strength Indicator -->
                                <div class="mt-2">
                                    <div class="password-strength bg-gray-200" id="passwordStrength"></div>
                                    <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters long and include letters, numbers, and symbols.
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label for="confirmPassword" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2 text-gray-400"></i>
                                    Password Confirmation
                                </label>
                                <div class="relative">
                                    <input type="password" id="confirmPassword" name="confirmPassword"
                                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent input-focus transition-all duration-200"
                                        placeholder="Masukkan kembali password" required>
                                    <button type="button" id="toggleConfirm"
                                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                                        <i class="fa-solid fa-eye" id="eyeIconConfirm"></i>
                                    </button>
                                </div>
                                <div id="passwordMatch" class="text-xs mt-1 hidden">
                                    <span class="text-red-500">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Password is not match
                                    </span>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
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
                            
                            <!-- Register Button -->
                            <div>
                                <button type="submit" 
                                    class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-green-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Register Now
                                </button>
                            </div>
                        </form>
                        
                        <!-- Login Link -->
                        <div class="mt-6 text-center">
                            <p class="text-gray-600">
                                Already have an account? 
                                <a href="<?= base_url('auth/login') ?>" class="text-green-600 hover:text-green-700 font-semibold hover:underline transition-colors">
                                    Login here
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Back to Home -->
                    <div class="text-center mt-8">
                        <a href="<?= base_url() ?>" class="inline-flex items-center text-gray-500 hover:text-green-600 text-sm font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to home
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Enhanced JavaScript for better UX -->
        <script>
            // Password visibility toggles
            document.getElementById('togglePassword').addEventListener('click', function() {
                const password = document.getElementById('password');
                const eyeIcon = document.getElementById('eyeIcon');
                
                if (password.type === 'password') {
                    password.type = 'text';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    password.type = 'password';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });

            document.getElementById('toggleConfirm').addEventListener('click', function() {
                const confirmPassword = document.getElementById('confirmPassword');
                const eyeIconConfirm = document.getElementById('eyeIconConfirm');
                
                if (confirmPassword.type === 'password') {
                    confirmPassword.type = 'text';
                    eyeIconConfirm.classList.remove('fa-eye');
                    eyeIconConfirm.classList.add('fa-eye-slash');
                } else {
                    confirmPassword.type = 'password';
                    eyeIconConfirm.classList.remove('fa-eye-slash');
                    eyeIconConfirm.classList.add('fa-eye');
                }
            });

            // Password strength indicator
            document.getElementById('password').addEventListener('input', function() {
                const password = this.value;
                const strengthBar = document.getElementById('passwordStrength');
                let strength = 0;

                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;

                const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
                const widths = ['20%', '40%', '60%', '80%', '100%'];

                strengthBar.className = `password-strength ${colors[strength - 1] || 'bg-gray-200'}`;
                strengthBar.style.width = widths[strength - 1] || '0%';
            });

            // Password match validation
            function checkPasswordMatch() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const matchIndicator = document.getElementById('passwordMatch');

                if (confirmPassword.length > 0) {
                    if (password !== confirmPassword) {
                        matchIndicator.classList.remove('hidden');
                        matchIndicator.innerHTML = '<span class="text-red-500"><i class="fas fa-times-circle mr-1"></i>Password tidak cocok</span>';
                    } else {
                        matchIndicator.classList.remove('hidden');
                        matchIndicator.innerHTML = '<span class="text-green-500"><i class="fas fa-check-circle mr-1"></i>Password cocok</span>';
                    }
                } else {
                    matchIndicator.classList.add('hidden');
                }
            }

            document.getElementById('password').addEventListener('input', checkPasswordMatch);
            document.getElementById('confirmPassword').addEventListener('input', checkPasswordMatch);
        </script>
        
        <script src="<?= base_url('assets/js/showPass.js')?>"></script>
    </body>
</html>