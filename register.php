<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก - CSS Game</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Reset Styles */
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Base Styles */
        body {
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(135deg, #74ebd5, #9face6);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .register-container {
            width: 90%;
            max-width: 400px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .register-box {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #4CAF50;
            font-size: 2rem;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 0.9rem;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            color: #333;
            transition: all 0.3s ease;
            font-family: 'Kanit', sans-serif;
        }

        input:focus {
            border-color: #4CAF50;
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        input::placeholder {
            color: #aaa;
        }

        button.btn {
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Kanit', sans-serif;
            margin-bottom: 20px;
        }

        button.btn:hover {
            background: #45a049;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        button.btn:active {
            transform: translateY(0);
        }

        p {
            color: #666;
            font-size: 0.9rem;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #45a049;
            text-decoration: underline;
        }

        /* Password Strength Indicator */
        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 3px;
            transition: all 0.3s ease;
            background: #e0e0e0;
        }

        .strength-weak {
            background: #ff4444;
            width: 33.33%;
        }

        .strength-medium {
            background: #ffbb33;
            width: 66.66%;
        }

        .strength-strong {
            background: #00C851;
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .register-container {
                width: 95%;
                padding: 20px;
            }

            h2 {
                font-size: 1.8rem;
            }

            input {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-box">
            <h2>สมัครสมาชิก</h2>
            <form action="register_action.php" method="POST">
                <div class="input-group">
                    <label for="username">ชื่อผู้ใช้</label>
                    <input type="text" name="username" id="username" placeholder="กรอกชื่อผู้ใช้" required>
                </div>
                <div class="input-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" name="password" id="password" placeholder="กรอกรหัสผ่าน" required>
                    <div class="password-strength"></div>
                </div>
                <div class="input-group">
                    <label for="confirm_password">ยืนยันรหัสผ่าน</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="ยืนยันรหัสผ่าน" required>
                </div>
                <button type="submit" class="btn">สมัครสมาชิก</button>
                <p>มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
            </form>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthIndicator = document.querySelector('.password-strength');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;

            strengthIndicator.className = 'password-strength';
            if (strength === 1) strengthIndicator.classList.add('strength-weak');
            else if (strength === 2) strengthIndicator.classList.add('strength-medium');
            else if (strength === 3) strengthIndicator.classList.add('strength-strong');
        });

        // Password confirmation check
        const confirmInput = document.getElementById('confirm_password');
        const form = document.querySelector('form');

        form.addEventListener('submit', function(e) {
            if (passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                alert('รหัสผ่านไม่ตรงกัน กรุณาตรวจสอบอีกครั้ง');
            }
        });
    </script>
</body>
</html>
