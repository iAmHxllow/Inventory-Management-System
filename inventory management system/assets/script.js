document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const usernameInput = document.getElementById('user');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const submitButton = document.querySelector('.login-btn');

    // Add styles for validation feedback and animations
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            .error-message {
                color: #ff3b3b;
                font-size: 0.875rem;
                margin-top: 0.5rem;
                display: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .error-message.visible {
                opacity: 1;
                display: block;
            }

            .input-container {
                position: relative;
                transition: all 0.3s ease;
            }

            .input-container.error input {
                border: 1px solid #ff3b3b;
                background-color: #fff1f1;
            }

            .input-container.success input {
                border: 1px solid #28a745;
                background-color: #f0fff4;
            }

            .input-container .validation-icon {
                position: absolute;
                right: 40px;
                top: 50%;
                transform: translateY(-50%);
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .input-container.success .validation-icon.success {
                opacity: 1;
                color: #28a745;
            }

            .input-container.error .validation-icon.error {
                opacity: 1;
                color: #ff3b3b;
            }

            .shake {
                animation: shake 0.3s ease-in-out;
            }

            .login-btn {
                position: relative;
                transition: all 0.3s ease;
            }

            .login-btn.loading {
                background-color: #4a5568;
                pointer-events: none;
            }

            .login-btn.loading::after {
                content: '';
                position: absolute;
                width: 20px;
                height: 20px;
                top: 50%;
                left: 50%;
                margin-left: -10px;
                margin-top: -10px;
                border: 2px solid #fff;
                border-top-color: transparent;
                border-radius: 50%;
                animation: spin 0.8s linear infinite;
            }

            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }

            @keyframes spin {
                to { transform: rotate(360deg); }
            }

            .toast {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem;
                border-radius: 4px;
                background: white;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transform: translateX(120%);
                transition: transform 0.3s ease;
                z-index: 1000;
            }

            .toast.success {
                background: #28a745;
                color: white;
            }

            .toast.error {
                background: #ff3b3b;
                color: white;
            }

            .toast.visible {
                transform: translateX(0);
            }
        </style>
    `);

    // Add validation icons and error message elements
    document.querySelectorAll('.input-container').forEach(container => {
        container.insertAdjacentHTML('beforeend', `
            <span class="validation-icon success">✓</span>
            <span class="validation-icon error">✗</span>
        `);
        container.insertAdjacentHTML('afterend', '<div class="error-message"></div>');
    });

    // Add toast container
    document.body.insertAdjacentHTML('beforeend', '<div class="toast"></div>');
    const toast = document.querySelector('.toast');

    // Validation functions
    function isValidUsername(username) {
        return /^[a-zA-Z0-9_]{3,20}$/.test(username);
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function isValidPassword(password) {
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumbers = /\d/.test(password);
        return password.length >= 6 && hasUpperCase && hasLowerCase && hasNumbers;
    }

    function showToast(message, type = 'error') {
        toast.textContent = message;
        toast.className = `toast ${type}`;
        requestAnimationFrame(() => {
            toast.classList.add('visible');
        });

        setTimeout(() => {
            toast.classList.remove('visible');
        }, 3000);
    }

    function showError(input, message) {
        const container = input.closest('.input-container');
        const errorDisplay = container.nextElementSibling;
        
        container.classList.remove('success');
        container.classList.add('error', 'shake');
        errorDisplay.textContent = message;
        errorDisplay.classList.add('visible');
        
        setTimeout(() => container.classList.remove('shake'), 300);
    }

    function showSuccess(input) {
        const container = input.closest('.input-container');
        const errorDisplay = container.nextElementSibling;
        
        container.classList.remove('error');
        container.classList.add('success');
        errorDisplay.classList.remove('visible');
    }

    // Debounce function for real-time validation
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    function validateUsername() {
        const username = usernameInput.value.trim();
        if (!username) {
            showError(usernameInput, 'Username is required');
            return false;
        } else if (!isValidUsername(username)) {
            showError(usernameInput, 'Username must be 3-20 characters and contain only letters, numbers, and underscores');
            return false;
        }
        showSuccess(usernameInput);
        return true;
    }

    function validateEmail() {
        const email = emailInput.value.trim();
        if (!email) {
            showError(emailInput, 'Email is required');
            return false;
        } else if (!isValidEmail(email)) {
            showError(emailInput, 'Please enter a valid email address');
            return false;
        }
        showSuccess(emailInput);
        return true;
    }

    function validatePassword() {
        const password = passwordInput.value.trim();
        if (!password) {
            showError(passwordInput, 'Password is required');
            return false;
        } else if (!isValidPassword(password)) {
            showError(passwordInput, 'Password must be at least 6 characters and contain uppercase, lowercase, and numbers');
            return false;
        }
        showSuccess(passwordInput);
        return true;
    }

    // Real-time validation with debounce
    const debouncedValidateUsername = debounce(validateUsername, 300);
    const debouncedValidateEmail = debounce(validateEmail, 300);
    const debouncedValidatePassword = debounce(validatePassword, 300);

    usernameInput.addEventListener('input', debouncedValidateUsername);
    emailInput.addEventListener('input', debouncedValidateEmail);
    passwordInput.addEventListener('input', debouncedValidatePassword);

    // Form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validate all fields
        const isUsernameValid = validateUsername();
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();

        if (!isUsernameValid || !isEmailValid || !isPasswordValid) {
            return;
        }

        // Show loading state
        submitButton.classList.add('loading');
        submitButton.textContent = '';

        try {
            const response = await fetch('register.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    username: usernameInput.value.trim(),
                    email: emailInput.value.trim(),
                    password: passwordInput.value.trim()
                })
            });

            const data = await response.json();

            if (data.success) {
                showToast('Registration successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 1500);
            } else {
                if (data.field) {
                    switch (data.field) {
                        case 'username':
                            showError(usernameInput, data.message);
                            usernameInput.focus();
                            break;
                        case 'email':
                            showError(emailInput, data.message);
                            emailInput.focus();
                            break;
                        case 'password':
                            showError(passwordInput, data.message);
                            passwordInput.focus();
                            break;
                        default:
                            showToast(data.message);
                    }
                } else {
                    showToast(data.message);
                }
                throw new Error(data.message);
            }
        } catch (error) {
            submitButton.classList.remove('loading');
            submitButton.textContent = 'Signup';
        }
    });

    // Password strength indicator
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = {
            hasUpperCase: /[A-Z]/.test(password),
            hasLowerCase: /[a-z]/.test(password),
            hasNumbers: /\d/.test(password),
            isLongEnough: password.length >= 6
        };

        const strengthLevel = Object.values(strength).filter(Boolean).length;
        const container = this.closest('.input-container');
        
        container.style.borderColor = 
            strengthLevel === 0 ? '#ff3b3b' :
            strengthLevel <= 2 ? '#ffa500' :
            strengthLevel <= 3 ? '#2196f3' :
            '#28a745';
    });
});