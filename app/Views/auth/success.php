<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to Librapopulus!</title>
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
            .celebration-animation {
                animation: celebrate 2s ease-in-out;
            }
            @keyframes celebrate {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }
            .fade-in {
                animation: fadeIn 1s ease-in-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-purple-600 via-blue-600 to-green-500 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full mx-4">
            <div class="bg-white rounded-3xl shadow-2xl p-8 text-center fade-in">
                <!-- Success Icon -->
                <div class="celebration-animation mb-6">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-3xl text-green-600"></i>
                    </div>
                </div>

                <!-- Welcome Message -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Welcome to Librapopulus!</h1>
                <p class="text-gray-600 mb-8 leading-relaxed">
                    Your profile has been successfully created. You're now ready to explore our community and discover amazing books!
                </p>

                <!-- Quick Stats -->
                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">50K+</div>
                        <div class="text-xs text-gray-500">Books</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">10K+</div>
                        <div class="text-xs text-gray-500">Members</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">24/7</div>
                        <div class="text-xs text-gray-500">Access</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-4">
                    <a href="<?= base_url('dashboard') ?>" 
                       class="block w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white py-3 px-6 rounded-xl font-semibold hover:from-purple-700 hover:to-blue-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-home mr-2"></i>
                        Go to Dashboard
                    </a>
                    <a href="<?= base_url('books') ?>" 
                       class="block w-full bg-gray-100 text-gray-700 py-3 px-6 rounded-xl font-semibold hover:bg-gray-200 transition-all duration-200">
                        <i class="fas fa-book mr-2"></i>
                        Browse Books
                    </a>
                </div>

                <!-- Tips -->
                <div class="mt-8 p-4 bg-blue-50 rounded-xl">
                    <h3 class="font-semibold text-blue-900 mb-2">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Quick Tips
                    </h3>
                    <ul class="text-sm text-blue-800 space-y-1 text-left">
                        <li>• Update your reading preferences in settings</li>
                        <li>• Join discussions to meet fellow readers</li>
                        <li>• Check out local book clubs in your area</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Auto redirect after 10 seconds -->
        <script>
            let countdown = 10;
            const redirectTimer = setInterval(() => {
                countdown--;
                if (countdown <= 0) {
                    clearInterval(redirectTimer);
                    window.location.href = '<?= base_url('dashboard') ?>';
                }
            }, 1000);

            // Add some confetti effect (optional)
            setTimeout(() => {
                // You can add a confetti library here for celebration effect
                console.log('🎉 Welcome to Librapopulus! 🎉');
            }, 500);
        </script>
    </body>
</html>
