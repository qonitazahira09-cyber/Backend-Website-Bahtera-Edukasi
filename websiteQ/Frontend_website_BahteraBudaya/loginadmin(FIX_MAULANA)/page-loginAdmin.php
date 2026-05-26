<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Bahtera Edukasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Garamond:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="page-loginAdmin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-illustration">
            <img
                src="assetloginAdmin/Group 81.png"
                alt="Logo Login Admin Bahtera Edukasi"
                class="illustration-svg"
                 style="width: 100%; max-width: none; height: auto;"
            >
        </div>

        <form class="login-form" action="proses_loginD.php" method="POST">
            <h1 class="form-title">Hallo Admin!</h1>
            <p class="form-subtitle">
                Nahkoda Bahtera Edukasi, silakan masuk untuk meneruskan kendali bahteramu.
            </p>

            <div class="input-group">
                <label for="username" class="input-label">Username</label>
                <div class="input-wrapper">
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="input-field"
                        placeholder="Masukkan username"
                        required
                    >
                    <button type="button" class="clear-username" aria-label="Clear username" style="display: none;">
                        <svg class="clear-icon" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M18.3 5.71a.996.996 0 0 0-1.41 0L12 10.59L7.11 5.7A.996.996 0 1 0 5.7 7.11L10.59 12L5.7 16.89a.996.996 0 1 0 1.41 1.41L12 13.41l4.89 4.89a.996.996 0 1 0 1.41-1.41L13.41 12l4.89-4.89c.38-.38.38-1.02 0-1.4"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="input-group">
                <label for="password" class="input-label">Password</label>
                <div class="input-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="input-field"
                        placeholder="Masukkan password"
                        required
                    >
                    <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                        <svg id="eye-icon" class="eye-icon" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M11.83 9L15 12.16V12a3 3 0 0 0-3-3zm-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7"/>
                        </svg>
                    </button>
                </div>
                <a href="lupakatasandi.html" class="forgot-password">Lupa Password?</a>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>

<script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const path = eyeIcon.querySelector('path');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                path.setAttribute('d', 'M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5');
            } else {
                passwordInput.type = 'password';
                path.setAttribute('d', 'M11.83 9L15 12.16V12a3 3 0 0 0-3-3zm-4.3.8l1.55 1.55c-.05.21-.08.42-.08.65a3 3 0 0 0 3 3c.22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53a5 5 0 0 1-5-5c0-.79.2-1.53.53-2.2M2 4.27l2.28 2.28l.45.45C3.08 8.3 1.78 10 1 12c1.73 4.39 6 7.5 11 7.5c1.55 0 3.03-.3 4.38-.84l.43.42L19.73 22L21 20.73L3.27 3M12 7a5 5 0 0 1 5 5c0 .64-.13 1.26-.36 1.82l2.93 2.93c1.5-1.25 2.7-2.89 3.43-4.75c-1.73-4.39-6-7.5-11-7.5c-1.4 0-2.74.25-4 .7l2.17 2.15C10.74 7.13 11.35 7 12 7');
            }
        }

        function toggleClearButtonVisibility() {
            const usernameInput = document.getElementById('username');
            const clearButton = document.querySelector('.clear-username');
            
            if (usernameInput.value.trim() !== '') {
                clearButton.style.display = 'flex';
            } else {
                clearButton.style.display = 'none';
            }
        }

        function clearUsername() {
            const usernameInput = document.getElementById('username');
            usernameInput.value = '';
            toggleClearButtonVisibility();
            usernameInput.focus();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.querySelector('.toggle-password');
            toggleButton.addEventListener('click', togglePasswordVisibility);

            const usernameInput = document.getElementById('username');
            const clearButton = document.querySelector('.clear-username');
            
            usernameInput.addEventListener('input', toggleClearButtonVisibility);
            clearButton.addEventListener('click', clearUsername);
            
            toggleClearButtonVisibility();
        });
    </script>
</body>
</html>