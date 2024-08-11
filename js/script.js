document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggleForm');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    toggleButton.addEventListener('click', function () {
        if (loginForm.style.display === 'none') {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            toggleButton.textContent = 'Switch to Register';
        } else {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            toggleButton.textContent = 'Switch to Login';
        }
    });
});
