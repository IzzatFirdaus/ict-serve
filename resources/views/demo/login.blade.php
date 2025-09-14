<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Masuk - ICTServe (iServe)</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-600: #2563EB;
            --primary-500: #3A75F6;
            --danger-600: #DC2626;
            --gray-100: #F4F4F5;
            --gray-300: #D4D4D8;
            --gray-500: #71717A;
            --gray-900: #18181B;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary-600), var(--primary-500));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            background: white;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 400px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-900);
            font-size: 0.875rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-600);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-primary {
            width: 100%;
            background-color: var(--primary-600);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }

        .btn-primary:hover {
            background-color: var(--primary-500);
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo img {
            max-height: 60px;
            margin: 0 auto;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-600);
            margin-top: 0.5rem;
        }

        .logo p {
            color: var(--gray-500);
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div style="width: 60px; height: 60px; background-color: var(--primary-600); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                <span style="color: white; font-weight: bold; font-size: 1.5rem;">iS</span>
            </div>
            <h1 class="font-poppins">ICTServe (iServe)</h1>
            <p>Sistem Pengurusan Perkhidmatan ICT MOTAC</p>
        </div>

        <form id="loginForm" action="{{ route('demo.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">E-mel</label>
                <input type="email" id="email" name="email" class="form-input" 
                       value="test@motac.gov.my" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Kata Laluan</label>
                <input type="password" id="password" name="password" class="form-input" 
                       value="password" required>
            </div>

            <button type="submit" class="btn-primary">Log Masuk</button>
        </form>

        <div style="text-align: center; margin-top: 1.5rem; color: var(--gray-500); font-size: 0.75rem;">
            <p>Demo Login Credentials:</p>
            <p>E-mel: test@motac.gov.my</p>
            <p>Kata Laluan: password</p>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate login process
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (email === 'test@motac.gov.my' && password === 'password') {
                // Redirect to dashboard
                window.location.href = '/dashboard';
            } else {
                alert('E-mel atau kata laluan tidak sah');
            }
        });
    </script>
</body>
</html>