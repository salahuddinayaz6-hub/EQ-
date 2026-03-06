<?php
// results.php - Result display page for EQ Test
session_start();
 
if (!isset($_SESSION['eq_results'])) {
    // If no results, redirect back to home via JS
    echo "<script>window.location.href = 'index.php';</script>";
    exit;
}
 
$results = $_SESSION['eq_results'];
$percentage = $results['percentage'];
$breakdown = $results['breakdown'];
$feedback = $results['feedback'];
 
// Determine label based on percentage
$label = "";
$color = "";
if ($percentage >= 80) {
    $label = "Exceptional Emotional Intelligence";
    $color = "#10b981";
} elseif ($percentage >= 60) {
    $label = "Balanced Emotional Intelligence";
    $color = "#6366f1";
} else {
    $label = "Developing Emotional Intelligence";
    $color = "#f59e0b";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your EQ Results | Mind Insight</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --bg: #0f172a;
            --card-bg: #1e293b;
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
            color: var(--text-light);
            min-height: 100vh;
            padding: 4rem 2rem;
            display: flex;
            justify-content: center;
        }
 
        .results-container {
            max-width: 900px;
            width: 100%;
            text-align: center;
        }
 
        .main-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            padding: 4rem;
            border-radius: 32px;
            box-shadow: 0 40px 100px -20px rgba(0,0,0,0.6);
            position: relative;
            overflow: hidden;
        }
 
        .score-circle {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 10px solid var(--glass);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            position: relative;
        }
 
        .score-circle::before {
            content: '';
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 10px solid <?php echo $color; ?>;
            clip-path: polygon(0 0, 100% 0, 100% <?php echo $percentage; ?>%, 0 <?php echo $percentage; ?>%);
            transition: clip-path 1.5s ease-out;
        }
 
        .score-value {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1;
        }
 
        .score-label {
            font-size: 0.9rem;
            color: var(--text-dim);
            text-transform: uppercase;
            letter-spacing: 2px;
        }
 
        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: <?php echo $color; ?>;
        }
 
        .feedback-box {
            background: var(--glass);
            border: 1px dashed var(--glass-border);
            padding: 2rem;
            border-radius: 20px;
            margin: 2.5rem 0;
            font-size: 1.1rem;
            color: var(--text-dim);
            line-height: 1.8;
            font-style: italic;
        }
 
        .breakdown-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
            text-align: left;
        }
 
        .cat-item {
            background: rgba(255,255,255,0.03);
            padding: 1.5rem;
            border-radius: 16px;
            border: 1px solid var(--glass-border);
        }
 
        .cat-name {
            font-size: 0.85rem;
            color: var(--text-dim);
            margin-bottom: 0.5rem;
            display: block;
        }
 
        .cat-bar-bg {
            height: 6px;
            background: #334155;
            border-radius: 3px;
            width: 100%;
            overflow: hidden;
        }
 
        .cat-bar-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 3px;
        }
 
        .cat-val {
            float: right;
            font-weight: 600;
            color: var(--text-light);
        }
 
        .actions {
            margin-top: 4rem;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
        }
 
        .btn {
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            border: none;
        }
 
        .btn-retake {
            background: var(--primary);
            color: white;
        }
 
        .btn-share {
            background: transparent;
            border: 1px solid var(--glass-border);
            color: var(--text-light);
        }
 
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="results-container">
        <div class="main-card">
            <div class="score-circle">
                <span class="score-value"><?php echo $percentage; ?>%</span>
                <span class="score-label">EQ Score</span>
            </div>
 
            <h1><?php echo $label; ?></h1>
            <p style="color: var(--text-dim);">Based on your responses, here is your emotional intelligence profile.</p>
 
            <div class="feedback-box">
                "<?php echo htmlspecialchars($feedback); ?>"
            </div>
 
            <div class="breakdown-grid">
                <?php foreach ($breakdown as $name => $val): ?>
                    <div class="cat-item">
                        <span class="cat-name">
                            <?php echo $name; ?>
                            <span class="cat-val"><?php echo $val; ?>%</span>
                        </span>
                        <div class="cat-bar-bg">
                            <div class="cat-bar-fill" style="width: <?php echo $val; ?>%;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
 
            <div class="actions">
                <button onclick="retakeTest()" class="btn btn-retake">Retake Quiz</button>
                <button onclick="shareResult()" class="btn btn-share">Share Results</button>
            </div>
        </div>
    </div>
 
    <script>
        function retakeTest() {
            // JS redirection as requested
            window.location.href = 'index.php';
        }
 
        function shareResult() {
            alert('Sharing functionality would trigger a social share popup or copy a link to clipboard.');
        }
    </script>
</body>
</html>
 
