<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// เริ่มต้น Health ที่ 100% ถ้ายังไม่มีค่า
if (!isset($_SESSION['health'])) {
    $_SESSION['health'] = 100;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSS Adventure Game - Level 1</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kanit', sans-serif;
            margin: 0;
            padding: 0;
            background: #0a0a1f;
            color: #fff;
            min-height: 100vh;
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

        .game-container {
            display: flex;
            height: 100vh;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .game-info {
            width: 30%;
            padding: 20px;
            background: rgba(10, 12, 36, 0.8);
            overflow-y: auto;
            box-shadow: 0 0 20px rgba(82, 109, 255, 0.2);
            border-right: 2px solid rgba(82, 109, 255, 0.1);
            backdrop-filter: blur(10px);
            position: relative;
        }

        .game-info::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(82, 109, 255, 0.1),
                transparent
            );
            animation: shine 3s linear infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .game-info h2 {
            text-align: center;
            color: #4facfe;
            font-size: 28px;
            margin-bottom: 20px;
            text-shadow: 0 0 10px rgba(79, 172, 254, 0.5);
            position: relative;
        }

        .level-badge {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 10px;
            box-shadow: 0 0 15px rgba(79, 172, 254, 0.3);
        }

        .health-bar {
            width: 100%;
            height: 20px;
            background-color: rgba(10, 12, 36, 0.5);
            border-radius: 10px;
            margin: 10px 0;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .health {
            height: 100%;
            background: linear-gradient(90deg, #4facfe, #00f2fe);
            transition: width 0.5s ease-in-out;
            box-shadow: 0 0 15px rgba(79, 172, 254, 0.5);
            position: relative;
        }

        .health-text {
            position: absolute;
            width: 100%;
            text-align: center;
            color: white;
            font-weight: bold;
            text-shadow: 0 0 5px rgba(79, 172, 254, 0.5);
            z-index: 1;
            line-height: 20px;
            font-size: 12px;
        }

        .css-editor {
            margin-top: 20px;
            background: rgba(15, 17, 42, 0.9);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(82, 109, 255, 0.1);
            border: 1px solid rgba(82, 109, 255, 0.2);
            position: relative;
        }

        .editor-header {
            background: rgba(10, 12, 36, 0.9);
            padding: 10px;
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
            box-shadow: 0 0 5px currentColor;
        }

        .dot-red { 
            background-color: #ff5f56;
            color: #ff5f56;
        }
        .dot-yellow { 
            background-color: #ffbd2e;
            color: #ffbd2e;
        }
        .dot-green { 
            background-color: #27c93f;
            color: #27c93f;
        }

        textarea {
            width: 100%;
            height: 120px;
            background-color: rgba(10, 12, 36, 0.95);
            color: #4facfe;
            border: 1px solid rgba(82, 109, 255, 0.3);
            padding: 15px;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 14px;
            border-radius: 8px;
            margin: 10px 0;
            resize: none;
            transition: all 0.3s ease;
        }

        textarea:focus {
            outline: none;
            border-color: #4facfe;
            box-shadow: 0 0 15px rgba(79, 172, 254, 0.3);
        }

        button {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(79, 172, 254, 0.3);
            position: relative;
            overflow: hidden;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.5);
        }

        button::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            transform: rotate(45deg);
            animation: buttonShine 2s linear infinite;
        }

        @keyframes buttonShine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .game-field {
            width: 70%;
            background: radial-gradient(circle at center, #1a1a2e, #0f0f1a);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(82, 109, 255, 0.3);
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(82, 109, 255, 0.2);
            overflow: hidden;
        }

        .game-field::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: linear-gradient(
                45deg,
                transparent,
                rgba(82, 109, 255, 0.1),
                transparent
            );
            animation: fieldShine 3s linear infinite;
        }

        @keyframes fieldShine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        .field {
            width: 80%;
            height: 80%;
            background: rgba(15, 17, 42, 0.9);
            border: 1px solid rgba(82, 109, 255, 0.2);
            position: relative;
            border-radius: 15px;
            box-shadow: 
                0 0 30px rgba(82, 109, 255, 0.2),
                inset 0 0 50px rgba(82, 109, 255, 0.1);
            overflow: hidden;
            animation: fieldPulse 3s ease-in-out infinite;
        }

        @keyframes fieldPulse {
            0%, 100% { 
                box-shadow: 0 0 30px rgba(82, 109, 255, 0.2),
                           inset 0 0 50px rgba(82, 109, 255, 0.1);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 0 40px rgba(82, 109, 255, 0.3),
                           inset 0 0 60px rgba(82, 109, 255, 0.2);
                transform: scale(1.02);
            }
        }

        #tree, .apple {
            transition: all 0.3s ease;
            filter: drop-shadow(0 0 10px rgba(79, 172, 254, 0.5));
        }

        .knight {
            position: absolute;
            top: 10%;
            left: 10%;
            width: 50px;
            height: auto;
            transition: all 0.5s ease;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.5));
            z-index: 2;
            animation: treeMove 2s infinite;
        }

        .knight.wiggle {
            animation: treeWiggle 0.5s ease;
        }

        .apple {
            position: absolute;
            top: 70%;
            left: 80%;
            width: 40px;
            height: auto;
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.3));
        }

        #result {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .success {
            background: linear-gradient(45deg, #48bb78, #38a169);
            color: white;
            box-shadow: 0 2px 4px rgba(72, 187, 120, 0.3);
        }

        .error {
            background: linear-gradient(45deg, #e53e3e, #c53030);
            color: white;
            box-shadow: 0 2px 4px rgba(229, 62, 62, 0.3);
        }

        .hint-button {
            background: linear-gradient(45deg, #00f2fe, #4facfe);
            margin-top: 10px;
            position: relative;
        }

        .hint-button:disabled {
            background: #2a2a3a;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .hint-button.used {
            background: #2a2a3a;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .hint-button.used::after {
            content: ' (ใช้ไปแล้ว)';
        }

        .hint-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(10, 12, 36, 0.95);
            border: 2px solid rgba(82, 109, 255, 0.3);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 100;
            box-shadow: 0 0 30px rgba(82, 109, 255, 0.2);
            max-width: 80%;
        }

        .hint-box.show {
            opacity: 1;
            visibility: visible;
        }

        .hint-text {
            color: #4facfe;
            font-size: 18px;
            margin-bottom: 15px;
            text-shadow: 0 0 10px rgba(79, 172, 254, 0.5);
        }

        .hint-code {
            background: rgba(15, 17, 42, 0.9);
            padding: 10px;
            border-radius: 8px;
            font-family: 'Monaco', 'Menlo', monospace;
            color: #00f2fe;
            margin: 10px 0;
            text-align: left;
        }

        .timer-bar {
            width: 100%;
            height: 4px;
            background: rgba(10, 12, 36, 0.5);
            margin-top: 10px;
            border-radius: 2px;
            overflow: hidden;
            display: none;
        }

        .timer-progress {
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #4facfe, #00f2fe);
            transform-origin: left;
            transition: transform 1s linear;
        }
    </style>
</head>
<body>
    <div class="stars"></div>
    <div class="game-container">
        <div class="game-info">
            <div class="level-badge">LEVEL 1</div>
            <h2>Level 1: Tree and Water</h2>
            <p>Heroes' health:</p>
            <div class="health-bar">
                <div class="health-text"><?php echo $_SESSION['health']; ?>%</div>
                <div class="health" style="width: <?php echo $_SESSION['health']; ?>%;"></div>
            </div>
            <p>
                สวัสดี ฮีโร่! เราต้องช่วยต้นไม้ให้ไปถึงแหล่งน้ำ! พร้อมรึยังสำหรับการผจญภัย?
            </p>
            <p>
                ดูเหมือนว่าต้นไม้จะเหี่ยวเฉาลงเรื่อยๆ เราต้องรีบพาไปหาน้ำ! ใช้คำสั่ง CSS เพื่อควบคุมตำแหน่งของต้นไม้กันเถอะ
            </p>
            <div class="css-editor">
                <div class="editor-header">
                    <div class="dot dot-red"></div>
                    <div class="dot dot-yellow"></div>
                    <div class="dot dot-green"></div>
                </div>
                <pre>#tree {</pre>
                <textarea id="css-input" placeholder="ใส่คำสั่ง CSS ตรงนี้..."></textarea>
                <pre>}</pre>
                <button id="check-answer">ตรวจคำตอบ</button>
                <button class="hint-button" onclick="showHint()">ขอดูคำใบ้</button>
                <div class="timer-bar">
                    <div class="timer-progress"></div>
                </div>
                <div id="result"></div>
            </div>
        </div>

        <div class="game-field">
            <div id="field" class="field">
                <div class="hint-box">
                    <div class="hint-text">คำใบ้: ใช้ top และ left เพื่อเคลื่อนย้ายต้นไม้ไปหาน้ำ</div>
                    <div class="hint-code">top: ??%;
left: ??%;</div>
                </div>
                <img src="tree.png" alt="Tree" class="knight" id="tree">
                <img src="water.png" alt="Water" class="apple">
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

        document.getElementById('css-input').addEventListener('input', function() {
            const cssInput = this.value;
            const tree = document.getElementById('tree');

            // แยกคำสั่ง CSS เป็นบรรทัด
            const cssLines = cssInput.split(';');
            
            // ประมวลผลแต่ละบรรทัด
            cssLines.forEach(line => {
                const [property, value] = line.split(':').map(str => str.trim());
                if (property && value) {
                    try {
                        // กำหนดค่า style ตามที่ผู้เล่นใส่
                        tree.style[property] = value;
                    } catch (error) {
                        console.error('Invalid CSS:', error);
                    }
                }
            });
        });

        document.getElementById('check-answer').addEventListener('click', function() {
            const tree = document.getElementById('tree');
            const water = document.querySelector('.apple');
            const result = document.getElementById('result');
            const healthBar = document.querySelector('.health');
            const healthText = document.querySelector('.health-text');

            const treeRect = tree.getBoundingClientRect();
            const waterRect = water.getBoundingClientRect();

            const distance = Math.sqrt(
                Math.pow(treeRect.left - waterRect.left, 2) +
                Math.pow(treeRect.top - waterRect.top, 2)
            );

            if (distance < 50) {
                result.textContent = 'เยี่ยมมาก! คุณผ่านด่านนี้แล้ว! ';
                result.className = 'success';
                tree.classList.add('wiggle');
                setTimeout(() => {
                    tree.classList.remove('wiggle');
                    window.location.href = 'game2.php';
                }, 1000);
            } else {
                // ลด Health 5% เมื่อตอบผิด
                fetch('update_health.php?decrease=5')
                    .then(response => response.json())
                    .then(data => {
                        const newHealth = data.health;
                        const healthBar = document.querySelector('.health');
                        const healthText = document.querySelector('.health-text');
                        
                        // อัพเดท health bar แบบ realtime
                        healthBar.style.width = newHealth + '%';
                        healthText.textContent = newHealth + '%';
                        
                        // เปลี่ยนสีตามระดับ health
                        if (newHealth <= 20) {
                            healthBar.style.background = 'linear-gradient(90deg, #ff0000, #cc0000)';
                        } else if (newHealth <= 50) {
                            healthBar.style.background = 'linear-gradient(90deg, #ffa500, #ff8c00)';
                        } else {
                            healthBar.style.background = 'linear-gradient(90deg, #ff6b6b, #ee5253)';
                        }
                        
                        // ถ้าเพิ่งรีเซ็ต health (Game Over)
                        if (data.gameOver) {
                            alert('Game Over! เริ่มเกมใหม่');
                            window.location.href = 'index.php';
                            return;
                        }
                    });

                result.textContent = 'ยังไม่ถูกต้อง ลองอีกครั้ง! ';
                result.className = 'error';
            }
        });

        let hintTimer = null;
        let isHintVisible = false;
        let hintUsed = false;

        function showHint() {
            if (isHintVisible || hintUsed) return;
            
            const hintBox = document.querySelector('.hint-box');
            const timerBar = document.querySelector('.timer-bar');
            const timerProgress = document.querySelector('.timer-progress');
            const hintButton = document.querySelector('.hint-button');
            
            // Show timer bar
            timerBar.style.display = 'block';
            
            // Show hint
            hintBox.classList.add('show');
            
            // Start timer animation
            timerProgress.style.transform = 'scaleX(0)';
            
            // Disable hint button permanently
            hintButton.disabled = true;
            hintButton.classList.add('used');
            isHintVisible = true;
            hintUsed = true;
            
            // Set timer to hide hint after 10 seconds
            hintTimer = setTimeout(() => {
                hintBox.classList.remove('show');
                timerBar.style.display = 'none';
                isHintVisible = false;
                // ไม่ต้อง enable ปุ่มกลับเพราะใช้ได้ครั้งเดียว
            }, 10000);
            
            // Animate timer bar
            requestAnimationFrame(() => {
                timerProgress.style.transform = 'scaleX(0)';
                requestAnimationFrame(() => {
                    timerProgress.style.transition = 'transform 10s linear';
                    timerProgress.style.transform = 'scaleX(1)';
                });
            });
        }
    </script>
</body>
</html>
