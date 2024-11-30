<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: game.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSS Game - เรียนรู้ CSS แบบสนุก</title>
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
            background: #1a1a2e;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
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

        .container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            z-index: 1;
        }

        .welcome-box {
            background: rgba(30, 30, 60, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 0 30px rgba(82, 109, 255, 0.1);
            border: 1px solid rgba(82, 109, 255, 0.2);
            animation: float 6s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .welcome-box::before {
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

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes shine {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .logo {
            margin-bottom: 30px;
        }

        .css-logo {
            font-size: 4rem;
            font-weight: bold;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 20px rgba(79, 172, 254, 0.5);
            animation: glow 3s ease-in-out infinite;
        }

        @keyframes glow {
            0%, 100% { filter: drop-shadow(0 0 20px rgba(79, 172, 254, 0.5)); }
            50% { filter: drop-shadow(0 0 30px rgba(79, 172, 254, 0.8)); }
        }

        h1 {
            font-size: 2.5em;
            margin: 0 0 15px 0;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
        }

        .subtitle {
            font-size: 1.2em;
            margin-bottom: 40px;
            color: #a0a0ff;
            opacity: 0.8;
        }

        .auth-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 40px;
        }

        .btn {
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 1.1em;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            opacity: 0;
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            color: #fff;
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: #4facfe;
            border: 2px solid #4facfe;
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.1);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 30px rgba(79, 172, 254, 0.5);
        }

        .btn:hover::before {
            opacity: 1;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .feature-item {
            text-align: center;
            padding: 20px;
            background: rgba(79, 172, 254, 0.1);
            border-radius: 15px;
            transition: all 0.3s ease;
            flex: 1;
            min-width: 150px;
            backdrop-filter: blur(5px);
        }

        .feature-item:hover {
            transform: translateY(-5px);
            background: rgba(79, 172, 254, 0.15);
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.2);
        }

        .feature-icon {
            font-size: 2em;
            margin-bottom: 10px;
            display: block;
            color: #4facfe;
            text-shadow: 0 0 10px rgba(79, 172, 254, 0.5);
        }

        .feature-item p {
            margin: 0;
            color: #a0a0ff;
        }

        @media (max-width: 768px) {
            .welcome-box {
                padding: 30px 20px;
            }

            .css-logo {
                font-size: 3rem;
            }

            .auth-buttons {
                flex-direction: column;
            }

            .features {
                flex-direction: column;
                gap: 20px;
            }

            .feature-item {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="container">
        <div class="welcome-box">
            <div class="logo">
                <span class="css-logo">CSS</span>
            </div>
            <h1>ยินดีต้อนรับสู่ CSS Game</h1>
            <p class="subtitle">เรียนรู้ CSS ผ่านเกมที่สนุกและท้าทาย!</p>
            
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-primary">เข้าสู่ระบบ</a>
                <a href="register.php" class="btn btn-secondary">สมัครสมาชิก</a>
            </div>

            <div class="features">
                <div class="feature-item">
                    <span class="feature-icon">🎮</span>
                    <p>เล่นสนุก</p>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">📚</span>
                    <p>เรียนรู้ง่าย</p>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">🏆</span>
                    <p>รับรางวัล</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create twinkling stars effect
        function createStars() {
            const starsContainer = document.querySelector('.stars');
            const numberOfStars = 100;

            for (let i = 0; i < numberOfStars; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                
                // Random position
                const x = Math.random() * 100;
                const y = Math.random() * 100;
                
                // Random size
                const size = Math.random() * 2;
                
                // Random animation duration and opacity
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

        // Initialize stars on page load
        window.addEventListener('load', createStars);
    </script>
</body>
</html>