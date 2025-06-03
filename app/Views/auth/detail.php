<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Complete Your Profile - Librapopulus</title>
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
            .bg-library-profile {
                background-image: linear-gradient(135deg, rgba(147, 51, 234, 0.8), rgba(79, 70, 229, 0.8)), 
                                url('https://images.unsplash.com/photo-1564846824194-346b7871b855?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            .glass-effect {
                backdrop-filter: blur(10px);
                background: rgba(255, 255, 255, 0.95);
            }
            .input-focus:focus {
                box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
            }
            .profile-upload {
                width: 120px;
                height: 120px;
                border-radius: 50%;
                border: 4px dashed #d1d5db;
                transition: all 0.3s ease;
            }
            .profile-upload:hover {
                border-color: #8b5cf6;
                background-color: #f3f4f6;
            }
            .profile-upload.has-image {
                border-style: solid;
                border-color: #8b5cf6;
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
                background-color: #8b5cf6;
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
            <!-- Left Side - Image/Illustration -->
            <div class="hidden lg:flex lg:w-1/2 bg-library-profile relative">
                <div class="absolute inset-0 flex flex-col justify-center items-center text-white p-12">
                    <div class="text-center max-w-md">
                        <div class="mb-8">
                            <i class="fas fa-user-edit text-6xl mb-4 opacity-90"></i>
                        </div>
                        <h2 class="text-4xl font-bold mb-4">Hampir Selesai!</h2>
                        <p class="text-xl opacity-90 leading-relaxed mb-6">
                            Lengkapi data profil agar mendapatkan rekomendasi buku dan terhubung dengan orang-orang di kotamu.
                        </p>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20">
                            <h3 class="text-lg font-semibold mb-4">Mengapa perlu?</h3>
                            <div class="space-y-3 text-left">
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-purple-300 mr-3"></i>
                                    <span>Mencari pembaca buku di sekitarmu</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-users text-purple-300 mr-3"></i>
                                    <span>Terhubung dengan pembaca buku sekitar</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-star text-purple-300 mr-3"></i>
                                    <span>Mendapatkan rekomendasi yang sesuai</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-purple-300 mr-3"></i>
                                    <span>Bergabung ke komunitas</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Profile Setup Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="max-w-md w-full">
                    <!-- Progress Indicator -->
                    <div class="flex items-center justify-center mb-8">
                        <div class="flex items-center space-x-4">
                            <div class="progress-step completed">
                                <i class="fas fa-check text-sm"></i>
                            </div>
                            <div class="h-1 w-12 bg-green-500"></div>
                            <div class="progress-step active">2</div>
                            <div class="h-1 w-12 bg-gray-300"></div>
                            <div class="progress-step inactive">3</div>
                        </div>
                    </div>

                    <!-- Mobile Header (visible on small screens) -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full mb-4">
                            <i class="fas fa-user-edit text-2xl text-purple-600"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">Librapopulus</h1>
                    </div>

                    <!-- Profile Setup Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Lengkapi Profilmu</h1>
                        <p class="text-gray-600">Tambahkan beberapa detail agar menambah kenyamanan</p>
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
                    
                    <!-- Profile Setup Form -->
                    <div class="glass-effect rounded-2xl shadow-xl p-8 border border-gray-200">
                        <form action="<?= base_url('auth/processProfileSetup') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
                            <!-- Profile Picture Upload -->
                            <div class="text-center">
                                <label class="block text-sm font-semibold text-gray-700 mb-4">
                                    <i class="fas fa-camera mr-2 text-gray-400"></i>
                                    Foto Profil
                                </label>
                                <div class="flex justify-center">
                                    <div class="profile-upload flex flex-col items-center justify-center cursor-pointer" id="profileUpload">
                                        <div id="uploadPlaceholder">
                                            <i class="fas fa-camera text-3xl text-gray-400 mb-2"></i>
                                            <p class="text-xs text-gray-500 text-center">Klik untuk Unggah</p>
                                        </div>
                                        <img id="profilePreview" class="w-full h-full object-cover rounded-full hidden" alt="Profile preview">
                                    </div>
                                </div>
                                <input type="file" id="profilePicture" name="profile_picture" accept="image/*" class="hidden">
                                <p class="text-xs text-gray-500 mt-2">JPG, PNG atau GIF (maks. 2MB)</p>
                            </div>

                            <!-- Full Name Field -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-id-card mr-2 text-gray-400"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" id="fullName" name="full_name" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus transition-all duration-200"
                                    placeholder="Masukkan nama lengkapmu">
                                <p class="text-xs text-gray-500 mt-1">Nama ini akan terlihat di publik</p>
                            </div>

                            <!-- City/Location Field -->
                            <div>
                                <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    Kota, Provinsi
                                </label>
                                <input type="text" id="city" name="city" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus transition-all duration-200"
                                    placeholder="contoh, Banjarmasin, Kalimantan Selatan">
                                <p class="text-xs text-gray-500 mt-1">Bantu kami menghubungkanmu dengan pembaca lokal</p>
                            </div>

                            <!-- Bio/About Field -->
                            <div>
                                <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-pen mr-2 text-gray-400"></i>
                                    Tentang Dirimu (Opsional)
                                </label>
                                <textarea id="bio" name="bio" rows="3"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent input-focus transition-all duration-200 resize-none"
                                    placeholder="Katakan kepada dunia tentang dirimu"></textarea>
                                <p class="text-xs text-gray-500 mt-1">Genre atau Topik Favoritmu?</p>
                            </div>

                            <!-- Favorite Genres -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-heart mr-2 text-gray-400"></i>
                                    Genre Favorit (Optional)
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="genres[]" value="fiction" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Fiksi</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="genres[]" value="non-fiction" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Non-Fiksi</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="genres[]" value="mystery" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Misteri</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="genres[]" value="romance" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Romansa</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="genres[]" value="sci-fi" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Sci-Fi</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="genres[]" value="fantasy" class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Fantasi</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4">
                                <button type="button" onclick="skipProfile()" 
                                    class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                    Lewati untuk Sekarang
                                </button>
                                <button type="submit" 
                                    class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transform hover:scale-[1.02] transition-all duration-200 shadow-lg">
                                    <i class="fas fa-check mr-2"></i>
                                    Profil Sudah Lengkap
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Help Text -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-500">
                            Kamu selalu bisa mengubah profilmu nanti di pengaturan
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            // Profile picture upload handling
            document.getElementById('profileUpload').addEventListener('click', function() {
                document.getElementById('profilePicture').click();
            });

            document.getElementById('profilePicture').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB max)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB');
                        return;
                    }

                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Please select an image file');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById('profilePreview');
                        const placeholder = document.getElementById('uploadPlaceholder');
                        const uploadContainer = document.getElementById('profileUpload');
                        
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                        uploadContainer.classList.add('has-image');
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Skip profile function
            function skipProfile() {
                if (confirm('Are you sure you want to skip profile setup? You can complete it later in settings.')) {
                    window.location.href = '<?= base_url('dashboard') ?>';
                }
            }

            // Form validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const fullName = document.getElementById('fullName').value.trim();
                const city = document.getElementById('city').value.trim();
                
                if (!fullName && !city) {
                    e.preventDefault();
                    alert('Please fill in at least your full name or city to continue.');
                }
            });
        </script>
    </body>
</html>
