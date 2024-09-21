<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Periksa apakah username ada di database
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password, $role);
    $stmt->fetch();
    $stmt->close();

    // Verifikasi password
    if ($password === $hashed_password) {  // Verifikasi tanpa hash karena password disimpan sebagai teks biasa
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // Redirect berdasarkan role
        if ($role == 'kasir') {
            header("Location: transaksi.php");
        } elseif ($role == 'manager') {
            header("Location: rekap.php");
        } elseif ($role == 'customer') {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Username atau password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #0A0E1A;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .background {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .background::before, .background::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: linear-gradient(120deg, #00BFFF, #FF00FF);
            opacity: 0.3;
            animation: animate 30s linear infinite;
        }
        .background::after {
            animation-delay: -15s;
        }
        @keyframes animate {
            0% {
                transform: translateX(-50%) translateY(-50%) scale(1.5);
            }
            100% {
                transform: translateX(50%) translateY(50%) scale(1.5);
            }
        }
        .login-container {
            background-color: #1F2A48;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.5);
            width: 350px;
            text-align: center;
            position: relative;
            z-index: 1;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #00BFFF;
        }
        .login-container input[type="text"], 
        .login-container input[type="password"] {
            width: calc(100% - 40px);
            padding: 10px;
            margin: 10px auto;
            border-radius: 5px;
            border: none;
            background: #27335D;
            color: #FFF;
            outline: none;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.5);
        }
        .password-wrapper {
            position: relative;
            width: calc(100% - 40px);
            margin: 10px auto;
        }
        .password-wrapper input {
            width: 100%;
            margin: 0;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #FFF;
        }
        .login-container button {
            background-color: #00BFFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: calc(100% - 40px);
            margin: 10px auto;
            display: block;
        }
        .login-container button:hover {
            background-color: #008ACD;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .links {
            margin-top: 20px;
        }
        .links a {
            color: #00BFFF;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        .links a:hover {
            color: #008ACD;
        }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="login-container">
        <h2>Form Login</h2>
        <?php if (isset($error)) echo '<p class="error">' . $error . '</p>'; ?>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Masukkan Username" required>
            <div class="password-wrapper">
                <input type="password" name="password" placeholder="Masukkan Password" required>
                <span class="toggle-password">👁️</span>
            </div>
            <button type="submit" name="login">Submit</button>
        </form>
        <div class="links">
            <a href="index.php">Lihat Menu</a>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('input[name="password"]');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });
    </script>
</body>
</html>
