function setupPasswordToggle(inputId, toggleId, eyeIcon) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(toggleId);
    const icon = document.getElementById(eyeIcon);

    if (input && toggle && icon) {
        toggle.addEventListener('click', function () {
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    setupPasswordToggle('password', 'togglePassword', 'eyeIcon');
    setupPasswordToggle('confirmPassword', 'toggleConfirm', 'eyeIconConfirm');
});
