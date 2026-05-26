<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth - Product Manager</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 400px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-size: 2em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #5568d3;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
        }

        .tab-btn {
            flex: 1;
            padding: 12px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            color: #999;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .tab-btn.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: 600;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            display: none;
            text-align: center;
            color: #667eea;
        }

        .user-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
            text-align: center;
        }

        .user-info h3 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .user-info p {
            color: #666;
            margin: 5px 0;
        }

        .logout-btn {
            background: #dc3545;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        .link {
            text-align: center;
            margin-top: 15px;
            color: #666;
        }

        .link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        .link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .card {
                padding: 25px;
            }

            h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>🔐 Auth</h1>

            <div id="loggedOutView">
                <div class="tabs">
                    <button class="tab-btn active" onclick="switchTab('login')">Login</button>
                    <button class="tab-btn" onclick="switchTab('register')">Register</button>
                </div>

                <!-- Login Tab -->
                <div id="login" class="tab-content active">
                    <div id="loginMessage"></div>
                    <form id="loginForm">
                        <div class="form-group">
                            <label for="loginEmail">Email</label>
                            <input type="email" id="loginEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Password</label>
                            <input type="password" id="loginPassword" required>
                        </div>
                        <button type="submit">Login</button>
                    </form>
                </div>

                <!-- Register Tab -->
                <div id="register" class="tab-content">
                    <div id="registerMessage"></div>
                    <form id="registerForm">
                        <div class="form-group">
                            <label for="registerName">Name</label>
                            <input type="text" id="registerName" required>
                        </div>
                        <div class="form-group">
                            <label for="registerEmail">Email</label>
                            <input type="email" id="registerEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="registerPassword">Password</label>
                            <input type="password" id="registerPassword" required>
                        </div>
                        <button type="submit">Register</button>
                    </form>
                </div>
            </div>

            <!-- Logged In View -->
            <div id="loggedInView" style="display: none;">
                <div class="user-info">
                    <h3>Welcome!</h3>
                    <p id="userEmail"></p>
                    <p id="userName"></p>
                </div>
                <p style="text-align: center; color: #666; margin-bottom: 20px;">
                    ✅ You are authenticated! Your token is stored.
                </p>
                <a href="/products" style="display: inline-block; width: 100%; padding: 12px; background: #667eea; color: white; text-align: center; border-radius: 5px; text-decoration: none; font-weight: 600; margin-bottom: 10px;">
                    Go to Products
                </a>
                <button class="logout-btn" onclick="logout()">Logout</button>
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
