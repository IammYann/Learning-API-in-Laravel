<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - Product Manager</title>
    <link rel="stylesheet" href="/css/modern.css">
</head>
<body>
    <!-- Background glows -->
    <div class="bg-glow-container">
        <div class="glow-blob glow-blob-1"></div>
        <div class="glow-blob glow-blob-2"></div>
        <div class="glow-blob glow-blob-3"></div>
    </div>

    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="glass-card">
                <h1 style="left: 0; transform: none; font-size: 2.25rem; font-weight: 800; margin-bottom: 30px;">🔐 Auth</h1>

                <div id="loggedOutView">
                    <div class="auth-tabs">
                        <button class="auth-tab-btn tab-btn active" onclick="switchTab('login')">Login</button>
                        <button class="auth-tab-btn tab-btn" onclick="switchTab('register')">Register</button>
                    </div>

                    <!-- Login Tab -->
                    <div id="login" class="auth-tab-content tab-content active">
                        <div id="loginMessage"></div>
                        <form id="loginForm">
                            <div class="form-group">
                                <label for="loginEmail">Email</label>
                                <input type="email" id="loginEmail" required placeholder="name@domain.com">
                            </div>
                            <div class="form-group">
                                <label for="loginPassword">Password</label>
                                <input type="password" id="loginPassword" required placeholder="••••••••">
                            </div>
                            <button type="submit">Login</button>
                        </form>
                    </div>

                    <!-- Register Tab -->
                    <div id="register" class="auth-tab-content tab-content">
                        <div id="registerMessage"></div>
                        <form id="registerForm">
                            <div class="form-group">
                                <label for="registerName">Name</label>
                                <input type="text" id="registerName" required placeholder="John Doe">
                            </div>
                            <div class="form-group">
                                <label for="registerEmail">Email</label>
                                <input type="email" id="registerEmail" required placeholder="name@domain.com">
                            </div>
                            <div class="form-group">
                                <label for="registerPassword">Password</label>
                                <input type="password" id="registerPassword" required placeholder="••••••••">
                            </div>
                            <button type="submit">Register</button>
                        </form>
                    </div>
                </div>

                <!-- Logged In View -->
                <div id="loggedInView" class="auth-logged-in-view" style="display: none;">
                    <div class="auth-user-card">
                        <h3>👋 Welcome back!</h3>
                        <p id="userName" style="font-weight: 600; margin-bottom: 6px; color: var(--text-primary);"></p>
                        <p id="userEmail" style="color: var(--text-secondary);"></p>
                    </div>
                    <p style="text-align: center; color: var(--text-secondary); margin-bottom: 24px; font-size: 0.95rem;">
                        ✅ You are authenticated! Your secure token is stored.
                    </p>
                    <a href="/products" class="btn btn-primary" style="text-decoration: none; margin-bottom: 12px;">
                        Go to Dashboard →
                    </a>
                    <button class="delete-btn" style="width: 100%; border-radius: 12px; padding: 12px;" onclick="logout()">Logout</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://127.0.0.1:8000/api';

        // Switch between login/register tabs
        function switchTab(tab) {
            // Hide all tabs
            document.getElementById('login').classList.remove('active');
            document.getElementById('register').classList.remove('active');
            
            // Remove active from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            
            // Show selected tab
            document.getElementById(tab).classList.add('active');
            
            // Activate button
            event.target.classList.add('active');
        }

        // Check if already logged in
        window.addEventListener('DOMContentLoaded', () => {
            const token = localStorage.getItem('auth_token');
            const user = localStorage.getItem('auth_user');
            
            if (token && user) {
                showLoggedInView(JSON.parse(user));
            }
        });

        // Login
        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const messageDiv = document.getElementById('loginMessage');

            try {
                const response = await fetch(`${API_URL}/login`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });

                const data = await response.json();

                if (!response.ok) {
                    messageDiv.innerHTML = `<div class="message error">${data.message || 'Login failed'}</div>`;
                    return;
                }

                // Store token and user
                localStorage.setItem('auth_token', data.token);
                localStorage.setItem('auth_user', JSON.stringify(data.user));

                messageDiv.innerHTML = `<div class="message success">Login successful! Redirecting...</div>`;
                
                setTimeout(() => {
                    showLoggedInView(data.user);
                }, 1000);

            } catch (error) {
                messageDiv.innerHTML = `<div class="message error">Error: ${error.message}</div>`;
            }
        });

        // Register
        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const password = document.getElementById('registerPassword').value;
            const messageDiv = document.getElementById('registerMessage');

            try {
                const response = await fetch(`${API_URL}/register`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ name, email, password })
                });

                const data = await response.json();

                if (!response.ok) {
                    const errorMsg = data.errors 
                        ? Object.values(data.errors).flat().join(', ')
                        : data.message || 'Registration failed';
                    messageDiv.innerHTML = `<div class="message error">${errorMsg}</div>`;
                    return;
                }

                // Store token and user
                localStorage.setItem('auth_token', data.token);
                localStorage.setItem('auth_user', JSON.stringify(data.user));

                messageDiv.innerHTML = `<div class="message success">Registration successful! Redirecting...</div>`;
                
                setTimeout(() => {
                    showLoggedInView(data.user);
                }, 1000);

            } catch (error) {
                messageDiv.innerHTML = `<div class="message error">Error: ${error.message}</div>`;
            }
        });

        // Show logged in view
        function showLoggedInView(user) {
            document.getElementById('loggedOutView').style.display = 'none';
            document.getElementById('loggedInView').style.display = 'block';
            document.getElementById('userEmail').textContent = `Email: ${user.email}`;
            document.getElementById('userName').textContent = `Name: ${user.name}`;
        }

        // Logout
        async function logout() {
            const token = localStorage.getItem('auth_token');

            try {
                await fetch(`${API_URL}/logout`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                });
            } catch (error) {
                console.error('Logout error:', error);
            }

            // Clear storage
            localStorage.removeItem('auth_token');
            localStorage.removeItem('auth_user');

            // Show login view
            document.getElementById('loggedOutView').style.display = 'block';
            document.getElementById('loggedInView').style.display = 'none';
            
            // Clear forms
            document.getElementById('loginForm').reset();
            document.getElementById('registerForm').reset();
        }
    </script>
</body>
</html>
