<?php
session_start(); // เริ่มต้น session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // ตรวจสอบว่าข้อมูลไม่เว้นว่าง
    if (empty($username) || empty($password) || empty($confirm_password)) {
        die("กรุณากรอกข้อมูลให้ครบถ้วน");
    }

    // ตรวจสอบว่ารหัสผ่านตรงกัน
    if ($password !== $confirm_password) {
        die("รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน");
    }

    // เชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $db_username = "root";
    $db_password = ""; // แก้ไขหากคุณตั้งรหัสผ่านไว้
    $dbname = "css_game";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // ตรวจสอบการเชื่อมต่อฐานข้อมูล
    if ($conn->connect_error) {
        die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ตรวจสอบว่าชื่อผู้ใช้มีอยู่แล้วหรือไม่
    $check_user_stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_user_stmt->bind_param("s", $username);
    $check_user_stmt->execute();
    $check_user_stmt->store_result();

    if ($check_user_stmt->num_rows > 0) {
        die("ชื่อผู้ใช้นี้ถูกใช้แล้ว");
    }
    $check_user_stmt->close();

    // บันทึกข้อมูลลงในตาราง users
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Kanit", sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #0a0a1f;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
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

        .message-container {
            background: rgba(15, 17, 42, 0.9);
            padding: 2rem;
            border-radius: 15px;
            border: 2px solid rgba(82, 109, 255, 0.3);
            box-shadow: 0 0 30px rgba(82, 109, 255, 0.2);
            text-align: center;
            z-index: 1;
            position: relative;
            max-width: 400px;
            width: 90%;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0;
                transform: translateY(-20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #4facfe;
            margin-bottom: 1rem;
            text-shadow: 0 0 10px rgba(79, 172, 254, 0.5);
            animation: pulseSuccess 2s infinite;
        }

        p {
            margin: 1rem 0;
            line-height: 1.6;
            color: #fff;
        }

        @keyframes pulseSuccess {
            0% { text-shadow: 0 0 5px rgba(72, 187, 120, 0.5); }
            50% { text-shadow: 0 0 20px rgba(72, 187, 120, 0.8); }
            100% { text-shadow: 0 0 5px rgba(72, 187, 120, 0.5); }
        }

        a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.5);
        }

        a::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: buttonShine 2s linear infinite;
        }

        @keyframes buttonShine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="message-container">
        <h2>Registration Successful!</h2>
        <p>Welcome aboard, ' . htmlspecialchars($username) . '!</p>
        <p>Your journey into the CSS universe begins now.</p>
        <a href="login.php">Login Now</a>
    </div>

    <script>
        function createStars() {
            const starsContainer = document.querySelector(".stars");
            const numberOfStars = 100;

            for (let i = 0; i < numberOfStars; i++) {
                const star = document.createElement("div");
                star.className = "star";
                
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

        window.addEventListener("load", createStars);
    </script>
</body>
</html>';
    } else {
        echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Failed</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Same CSS as success page */
        body {
            font-family: "Kanit", sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: #0a0a1f;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
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

        .message-container {
            background: rgba(15, 17, 42, 0.9);
            padding: 2rem;
            border-radius: 15px;
            border: 2px solid rgba(82, 109, 255, 0.3);
            box-shadow: 0 0 30px rgba(82, 109, 255, 0.2);
            text-align: center;
            z-index: 1;
            position: relative;
            max-width: 400px;
            width: 90%;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { 
                opacity: 0;
                transform: translateY(-20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            color: #e53e3e;
            margin-bottom: 1rem;
            text-shadow: 0 0 10px rgba(229, 62, 62, 0.5);
            animation: pulseError 2s infinite;
        }

        @keyframes pulseError {
            0% { text-shadow: 0 0 5px rgba(229, 62, 62, 0.5); }
            50% { text-shadow: 0 0 20px rgba(229, 62, 62, 0.8); }
            100% { text-shadow: 0 0 5px rgba(229, 62, 62, 0.5); }
        }

        p {
            margin: 1rem 0;
            line-height: 1.6;
            color: #fff;
        }

        a {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.5);
        }

        a::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            animation: buttonShine 2s linear infinite;
        }

        @keyframes buttonShine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="message-container">
        <h2>Registration Failed</h2>
        <p>Sorry, there was an error during registration.</p>
        <p>Please try again.</p>
        <a href="register.php">Back to Register</a>
    </div>

    <script>
        function createStars() {
            const starsContainer = document.querySelector(".stars");
            const numberOfStars = 100;

            for (let i = 0; i < numberOfStars; i++) {
                const star = document.createElement("div");
                star.className = "star";
                
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

        window.addEventListener("load", createStars);
    </script>
</body>
</html>';
    }

    // ปิดการเชื่อมต่อ
    $stmt->close();
    $conn->close();
}
?>
