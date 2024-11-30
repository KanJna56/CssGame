<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - CSS Game</title>
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

        .login-container {
            width: 90%;
            max-width: 400px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .login-box {
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

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
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
    <div class="login-container">
        <div class="login-box">
            <h2>เข้าสู่ระบบ</h2>
            <form action="login_action.php" method="POST">
                <div class="input-group">
                    <label for="username">ชื่อผู้ใช้</label>
                    <input type="text" name="username" id="username" placeholder="กรอกชื่อผู้ใช้" required>
                </div>
                <div class="input-group">
                    <label for="password">รหัสผ่าน</label>
                    <input type="password" name="password" id="password" placeholder="กรอกรหัสผ่าน" required>
                </div>
                <button type="submit" class="btn">เข้าสู่ระบบ</button>
                <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
            </form>
        </div>
    </div>
</body>
</html>
