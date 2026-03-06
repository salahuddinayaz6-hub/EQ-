<?php
// index.php - Homepage for EQ Test
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Your Emotions | Professional EQ Test</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --accent: #10b981;
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --glass: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }
 
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }
 
        body {
            background-color: var(--bg);
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(236, 72, 153, 0.15) 0%, transparent 40%);
            color: var(--text-light);
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }
 
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
 
        header {
            padding: 2rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
 
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
        }
 
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8rem 0;
            gap: 4rem;
        }
 
        .hero-content {
            flex: 1;
        }
 
        .hero-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: var(--glass);
            border: 1px solid var(--glass-border);
            border-radius: 2rem;
            font-size: 0.9rem;
            color: var(--secondary);
            font-weight: 600;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }
 
        h1 {
            font-size: 4.5rem;
            line-height: 1.1;
            margin-bottom: 2rem;
            font-weight: 700;
            background: linear-gradient(to bottom right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
 
        .hero-desc {
            font-size: 1.25rem;
            color: var(--text-dim);
            margin-bottom: 3rem;
            max-width: 600px;
        }
 
        .cta-group {
            display: flex;
            gap: 1.5rem;
        }
 
        .btn {
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
        }
 
        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }
 
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 20px 35px -10px rgba(99, 102, 241, 0.5);
        }
 
        .hero-visual {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
 
        .visual-blob {
            width: 450px;
            height: 450px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: blobby 10s infinite alternate;
            filter: blur(60px);
            opacity: 0.6;
            position: absolute;
        }
 
        .floating-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            padding: 2rem;
            border-radius: 24px;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 380px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
 
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding-bottom: 8rem;
        }
 
        .feature-card {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            padding: 2.5rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
 
        .feature-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-10px);
            border-color: var(--primary);
        }
 
        .icon-box {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
 
        @keyframes blobby {
            0% { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; transform: rotate(0deg) scale(1); }
            100% { border-radius: 70% 30% 30% 70% / 70% 70% 30% 30%; transform: rotate(180deg) scale(1.1); }
        }
 
        @media (max-width: 968px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 4rem 0;
            }
            h1 { font-size: 3rem; }
            .hero-desc { margin: 0 auto 3rem; }
            .cta-group { justify-content: center; }
            .hero-visual { margin-top: 4rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">EQ.Mind</div>
        </header>
 
        <section class="hero">
            <div class="hero-content">
                <span class="hero-badge">Emotional Intelligence Assessment 2024</span>
                <h1>Master Your <br><span style="color: var(--primary)">Inner World.</span></h1>
                <p class="hero-desc">Take our scientifically inspired EQ assessment to discover your emotional strengths, areas for growth, and how you connect with the world around you.</p>
                <div class="cta-group">
                    <button id="startTest" class="btn btn-primary" onclick="redirectToQuiz()">
                        Start Your Journey 
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </div>
            </div>
 
            <div class="hero-visual">
                <div class="visual-blob"></div>
                <div class="floating-card">
                    <div style="font-size: 0.9rem; color: var(--secondary); margin-bottom: 0.5rem; font-weight: 600;">AI Insight</div>
                    <div style="font-size: 1.4rem; font-weight: 600; margin-bottom: 1rem;">Emotional Pulse</div>
                    <div style="height: 4px; background: #334155; border-radius: 2px; margin-bottom: 1.5rem; overflow: hidden;">
                        <div style="width: 75%; height: 100%; background: var(--primary); box-shadow: 0 0 15px var(--primary);"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-dim);">
                        <span>Self Awareness</span>
                        <span style="color: var(--text-light);">75%</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-dim); margin-top: 0.5rem;">
                        <span>Empathy</span>
                        <span style="color: var(--text-light);">88%</span>
                    </div>
                </div>
            </div>
        </section>
 
        <section class="feature-grid">
            <div class="feature-card">
                <div class="icon-box">🧠</div>
                <h3>Deep Analysis</h3>
                <p style="color: var(--text-dim); margin-top: 1rem;">Go beyond surface-level traits. Our assessment dives into your core emotional architecture.</p>
            </div>
            <div class="feature-card">
                <div class="icon-box">⚡</div>
                <h3>Instant Results</h3>
                <p style="color: var(--text-dim); margin-top: 1rem;">Receive your comprehensive score and personalized feedback immediately after completion.</p>
            </div>
            <div class="feature-card">
                <div class="icon-box">🌱</div>
                <h3>Growth Mindset</h3>
                <p style="color: var(--text-dim); margin-top: 1rem;">Actionable recommendations to help you improve your social and emotional well-being.</p>
            </div>
        </section>
 
        <footer style="padding: 4rem 0; text-align: center; border-top: 1px solid var(--glass-border); color: var(--text-dim); font-size: 0.9rem;">
            <p>&copy; 2024 EQ.Mind Intelligence Platform. All rights reserved.</p>
            <p style="margin-top: 0.5rem;">Designed for personal growth and self-discovery.</p>
        </footer>
    </div>
 
    <script>
        function redirectToQuiz() {
            // JavaScript redirection as requested
            window.location.href = 'quiz.php';
        }
    </script>
</body>
</html>
 
