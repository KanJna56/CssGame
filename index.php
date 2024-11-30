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
    <style>
        /* Reset Styles */
body, html {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Fonts and Base Styles */
body {
    font-family: 'Kanit', sans-serif;
    background: linear-gradient(135deg, #74ebd5, #9face6);
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    width: 90%;
    max-width: 400px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 20px;
    overflow: hidden;
}

.logo {
    font-size: 3rem;
    font-weight: bold;
    color: #4CAF50;
    margin-bottom: 20px;
}

h1 {
    font-size: 1.8rem;
    margin-bottom: 10px;
    color: #333;
}

.subtitle {
    font-size: 1rem;
    color: #666;
    margin-bottom: 30px;
}

.auth-buttons {
    margin: 20px 0;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 5px;
    text-decoration: none;
    margin: 5px;
    transition: background-color 0.3s, transform 0.3s;
}

.btn-primary {
    background: #4CAF50;
    color: #fff;
    border: none;
}

.btn-primary:hover {
    background: #45a049;
    transform: scale(1.05);
}

.btn-secondary {
    background: #008CBA;
    color: #fff;
    border: none;
}

.btn-secondary:hover {
    background: #007bb5;
    transform: scale(1.05);
}

.features {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.feature-item {
    text-align: center;
    color: #555;
}

.feature-icon {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
    color: #4CAF50;
}

    </style>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
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
</body>
</html>