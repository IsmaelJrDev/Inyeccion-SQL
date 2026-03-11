document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const messageBox = document.getElementById('messageBox');
    const messageText = document.getElementById('messageText');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const btnText = document.getElementById('btnText');

    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validación básica
        if (!username.value.trim() || !password.value.trim()) {
            showMessage('Por favor completa todos los campos', 'error');
            return;
        }

        // Desabilitar botón durante el envío
        loginBtn.disabled = true;
        loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Procesando...</span>';

        try {
            const formData = new FormData();
            formData.append('username', username.value);
            formData.append('password', password.value);

            const response = await fetch('index.php?action=login', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showMessage('¡Bienvenido! Redirigiendo...', 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                showMessage(data.message, 'error');
                loginBtn.disabled = false;
                loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i><span>Iniciar Sesión</span>';
            }
        } catch (error) {
            console.error('Error:', error);
            showMessage('Error en la conexión. Intenta nuevamente.', 'error');
            loginBtn.disabled = false;
            loginBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i><span>Iniciar Sesión</span>';
        }
    });

    function showMessage(message, type) {
        messageBox.classList.remove('hidden', 'bg-red-900', 'bg-red-opacity-30', 'bg-green-900', 'bg-green-opacity-30', 'text-red-200', 'text-green-200', 'border-red-700', 'border-green-700');
        messageText.textContent = message;

        if (type === 'error') {
            messageBox.classList.add('bg-red-900', 'text-red-200', 'border-red-700');
            messageBox.style.backgroundColor = 'rgba(127, 29, 29, 0.3)';
            messageBox.style.borderColor = '#b91c1c';
            messageBox.style.color = '#fecaca';
        } else if (type === 'success') {
            messageBox.classList.add('bg-green-900', 'text-green-200', 'border-green-700');
            messageBox.style.backgroundColor = 'rgba(20, 83, 45, 0.3)';
            messageBox.style.borderColor = '#16a34a';
            messageBox.style.color = '#86efac';
        }

        messageBox.classList.remove('hidden');
    }

    // Toggle para mostrar/ocultar contraseña
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword) {
        togglePassword.addEventListener('click', function(e) {
            e.preventDefault();
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    }

    // Agregar animación a los inputs
    [username, password].forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('opacity-100');
        });

        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('opacity-100');
            }
        });
    });
});
