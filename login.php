<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - CSS Game</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            background: #1a1a2e;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background: radial-gradient(circle at center, #1a1a2e 0%, #0f0f1a 100%);
        }

        .star {
            position: absolute;
            background: #fff;
            border-radius: 50%;
            animation: twinkle var(--duration) infinite;
            opacity: 0;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0; }
            50% { opacity: var(--opacity); }
        }

        .login-container {
            position: relative;
            z-index: 1;
            background: rgba(30, 30, 60, 0.9);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(82, 109, 255, 0.1);
            border: 1px solid rgba(82, 109, 255, 0.2);
            width: 90%;
            max-width: 400px;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                transparent 40%,
                rgba(82, 109, 255, 0.1),
                transparent 60%,
                transparent
            );
            animation: shine 8s linear infinite;
            pointer-events: none;
        }

        @keyframes shine {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        h2 {
            text-align: center;
            font-size: 2em;
            margin-bottom: 30px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(79, 172, 254, 0.5);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #a0a0ff;
            font-size: 0.9em;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(82, 109, 255, 0.2);
            border-radius: 10px;
            background: rgba(30, 30, 60, 0.5);
            color: #fff;
            font-family: 'Kanit', sans-serif;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 15px rgba(79, 172, 254, 0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Kanit', sans-serif;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.5);
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #4facfe;
            text-decoration: none;
            font-size: 0.9em;
            transition: all 0.3s ease;
        }

        .links a:hover {
            color: #00f2fe;
            text-shadow: 0 0 10px rgba(79, 172, 254, 0.5);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            h2 {
                font-size: 1.8em;
            }
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="login-container">
        <h2>เข้าสู่ระบบ</h2>
        <form action="login_action.php" method="post">
            <div class="form-group">
                <label for="username">ชื่อผู้ใช้</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">รหัสผ่าน</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">เข้าสู่ระบบ</button>
        </form>
        <div class="links">
            <a href="register.php">สมัครสมาชิก</a> | <a href="index.php">กลับหน้าหลัก</a>
        </div>
    </div>

    <script>
        function createStars() {
            const starsContainer = document.querySelector('.stars');
            const numberOfStars = 100;

            for (let i = 0; i < numberOfStars; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                const size = Math.random() * 2;
                const duration = 3 + Math.random() * 3;
                const opacity = 0.3 + Math.random() * 0.7;
                
                star.style.cssText = `
                    left: ${x}%;
                    top: ${y}%;
                    width: ${size}px;
                    height: ${size}px;
                    --duration: ${duration}s;
                    --opacity: ${opacity};
                `;
                
                starsContainer.appendChild(star);
            }
        }

        window.addEventListener('load', createStars);
    </script>
</body>
</html>
