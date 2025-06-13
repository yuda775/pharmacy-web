<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Swarfa Farma</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e8f5e9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('https://img.freepik.com/free-vector/medicine-concept-background_52683-42625.jpg');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            padding: 40px;
            text-align: center;
            border: 1px solid #c8e6c9;
        }

        .logo img {
            max-width: 100%;
            max-height: 100%;
        }

        h1 {
            color: #2e7d32;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .subtitle {
            color: #757575;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #2e7d32;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #c8e6c9;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #4caf50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
        }

        .login-btn {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .login-btn:hover {
            background-color: #388e3c;
        }

        .forgot-password {
            display: block;
            margin-top: 15px;
            color: #689f38;
            text-decoration: none;
            font-size: 13px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #757575;
        }

        .error-message {
            color: #d32f2f;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="/logo.png" alt="logo">
        </div>
        <h1>Swarga Farma Digital</h1>
        <p class="subtitle">Silakan masuk dengan akun Anda</p>

        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email" required>
                <div class="error-message" id="email-error">email tidak valid</div>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                <div class="error-message" id="password-error">Password tidak valid</div>
            </div>

            <button type="submit" class="login-btn">Masuk</button>
            {{-- <a href="#" class="forgot-password">Lupa password?</a> --}}
        </form>

        <div class="footer">
            &copy; 2025 Apotek Sehat. Seluruh hak cipta dilindungi.
        </div>
    </div>

    {{-- <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Validasi sederhana
            let isValid = true;

            if (username.trim() === '') {
                document.getElementById('username-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('username-error').style.display = 'none';
            }

            if (password.trim() === '') {
                document.getElementById('password-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('password-error').style.display = 'none';
            }

            if (isValid) {
                // Simulasi login berhasil
                // Dalam implementasi nyata, ini akan mengirim data ke server
                alert('Login berhasil! Mengarahkan ke halaman absensi...');
                window.location.href = 'absensi.html'; // Ganti dengan halaman absensi yang sudah dibuat sebelumnya
            }
        });
    </script> --}}
</body>

</html>
