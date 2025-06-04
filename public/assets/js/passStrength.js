document.addEventListener('DOMContentLoaded', () => {
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const strengthBar = document.getElementById('passwordStrength');
    const matchIndicator = document.getElementById('passwordMatch');

    function updatePasswordStrength() {
        const password = passwordInput.value;
        let strength = 0;

        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
        const widths = ['20%', '40%', '60%', '80%', '100%'];

        strengthBar.className = `password-strength ${colors[strength - 1] || 'bg-gray-200'}`;
        strengthBar.style.width = widths[strength - 1] || '0%';
    }

    function checkPasswordMatch() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

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

    passwordInput.addEventListener('input', () => {
        updatePasswordStrength();
        checkPasswordMatch();
    });

    confirmPasswordInput.addEventListener('input', checkPasswordMatch);
});
