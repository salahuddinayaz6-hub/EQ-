<?php
// quiz.php - Interactive EQ Quiz Page
require_once 'db_config.php';
 
session_start();
 
// Fetch all questions and their options
$stmt = $pdo->query("SELECT q.id, q.question_text, q.category, o.id as option_id, o.option_text, o.score 
                     FROM questions q 
                     JOIN options o ON q.id = o.question_id 
                     ORDER BY q.id, o.score");
$raw_data = $stmt->fetchAll();
 
$questions = [];
foreach ($raw_data as $row) {
    if (!isset($questions[$row['id']])) {
        $questions[$row['id']] = [
            'id' => $row['id'],
            'text' => $row['question_text'],
            'category' => $row['category'],
            'options' => []
        ];
    }
    $questions[$row['id']]['options'][] = [
        'id' => $row['option_id'],
        'text' => $row['option_text'],
        'score' => $row['score']
    ];
}
 
$questions = array_values($questions); // Re-index for JS
 
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answers'])) {
    $answers = $_POST['answers']; // array of question_id => score
 
    $total_score = 0;
    $category_scores = [];
    $total_count = count($questions);
 
    foreach ($questions as $q) {
        $q_id = $q['id'];
        $cat = $q['category'];
        $score = isset($answers[$q_id]) ? (int)$answers[$q_id] : 0;
 
        $total_score += $score;
        if (!isset($category_scores[$cat])) {
            $category_scores[$cat] = ['score' => 0, 'max' => 0];
        }
        $category_scores[$cat]['score'] += $score;
        $category_scores[$cat]['max'] += 5; // Assuming max score per Q is 5
    }
 
    // Prepare breakdown for results
    $breakdown = [];
    foreach ($category_scores as $cat => $data) {
        $breakdown[$cat] = round(($data['score'] / $data['max']) * 100);
    }
 
    // Feedback logic
    $percentage = round(($total_score / ($total_count * 5)) * 100);
    if ($percentage >= 80) {
        $feedback = "Your EQ is exceptional! You possess a deep understanding of your own emotions and show remarkable empathy towards others. You are resilient and handle social complexities with grace.";
    } elseif ($percentage >= 60) {
        $feedback = "You have a solid emotional foundation. You are generally self-aware and empathetic, though there are specific areas where you could refine your emotional regulation or social resonance.";
    } else {
        $feedback = "You are beginning your journey of emotional discovery. While you have core strengths, focusing on self-reflection and active listening will significantly enhance your emotional intelligence.";
    }
 
    // Save to session
    $_SESSION['eq_results'] = [
        'total_score' => $total_score,
        'percentage' => $percentage,
        'breakdown' => $breakdown,
        'feedback' => $feedback
    ];
 
    // Redirect via JS in the HTML below or header (using JS as specifically requested)
    echo "<script>window.location.href = 'results.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EQ Assessment | Mind Insight</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --accent: #10b981;
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
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
            background-image: 
                radial-gradient(circle at top right, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle at bottom left, rgba(236, 72, 153, 0.1) 0%, transparent 50%);
        }
 
        .quiz-container {
            max-width: 800px;
            width: 100%;
            margin-top: 4rem;
        }
 
        .progress-bar-container {
            width: 100%;
            height: 8px;
            background: var(--glass);
            border-radius: 4px;
            margin-bottom: 3rem;
            overflow: hidden;
        }
 
        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, var(--primary), #ec4899);
            width: 0%;
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
 
        .question-card {
            background: var(--card-bg);
            border: 1px solid var(--glass-border);
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.4);
            display: none; /* Controlled by JS */
            animation: fadeIn 0.5s ease;
        }
 
        .question-card.active {
            display: block;
        }
 
        .category-tag {
            color: var(--primary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            display: block;
        }
 
        .question-text {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 2rem;
            line-height: 1.3;
        }
 
        .options-group {
            display: grid;
            gap: 1rem;
        }
 
        .option {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            padding: 1.25rem 1.5rem;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
 
        .option:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--primary);
            transform: translateX(5px);
        }
 
        .option.selected {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
 
        .option-radio {
            display: none;
        }
 
        .controls {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
 
        .btn {
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
 
        .btn-prev {
            background: var(--glass);
            color: var(--text-light);
            border: 1px solid var(--glass-border);
        }
 
        .btn-next {
            background: var(--primary);
            color: white;
            padding-left: 3rem;
            padding-right: 3rem;
        }
 
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }
 
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="quiz-container">
        <div class="progress-bar-container">
            <div id="progressFill" class="progress-fill"></div>
        </div>
 
        <form id="quizForm" method="POST">
            <?php foreach ($questions as $index => $q): ?>
                <div class="question-card <?php echo $index === 0 ? 'active' : ''; ?>" id="q-<?php echo $index; ?>">
                    <span class="category-tag"><?php echo htmlspecialchars($q['category']); ?></span>
                    <h2 class="question-text"><?php echo htmlspecialchars($q['text']); ?></h2>
 
                    <div class="options-group">
                        <?php foreach ($q['options'] as $opt): ?>
                            <label class="option" onclick="selectOption(this, <?php echo $index; ?>)">
                                <span><?php echo htmlspecialchars($opt['text']); ?></span>
                                <input type="radio" name="answers[<?php echo $q['id']; ?>]" value="<?php echo $opt['score']; ?>" required class="option-radio">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="check-icon" style="display:none;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </label>
                        <?php endforeach; ?>
                    </div>
 
                    <div class="controls">
                        <button type="button" class="btn btn-prev" onclick="changeQuestion(-1)" <?php echo $index === 0 ? 'disabled' : ''; ?>>Back</button>
                        <?php if ($index === count($questions) - 1): ?>
                            <button type="submit" class="btn btn-next" id="submitBtn" disabled>Complete Test</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-next" onclick="changeQuestion(1)" disabled>Next Step</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </form>
    </div>
 
    <script>
        let currentIdx = 0;
        const totalQuestions = <?php echo count($questions); ?>;
 
        function selectOption(element, qIndex) {
            // Remove selected class from sibling options
            const options = element.parentElement.querySelectorAll('.option');
            options.forEach(opt => opt.classList.remove('selected'));
 
            // Add selected class and check the radio
            element.classList.add('selected');
            const radio = element.querySelector('input[type="radio"]');
            radio.checked = true;
 
            // Enable next/submit button
            const currentCard = document.getElementById(`q-${qIndex}`);
            const nextBtn = currentCard.querySelector('.btn-next');
            if (nextBtn) nextBtn.disabled = false;
 
            updateProgress();
        }
 
        function changeQuestion(direction) {
            const currentCard = document.getElementById(`q-${currentIdx}`);
            currentCard.classList.remove('active');
 
            currentIdx += direction;
 
            const nextCard = document.getElementById(`q-${currentIdx}`);
            nextCard.classList.add('active');
 
            updateProgress();
        }
 
        function updateProgress() {
            // Calculate how many questions have been answered or reached
            const progress = ((currentIdx + 1) / totalQuestions) * 100;
            document.getElementById('progressFill').style.width = progress + '%';
        }
 
        // Initialize progress
        updateProgress();
    </script>
</body>
</html>
 
