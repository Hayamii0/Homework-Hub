<?php
require_once 'config.php';
checkLogin();

$user = getCurrentUser();
$userEmail = $user['email'] ?? 'Guest';
$userName = $user['full_name'] ?? $user['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeworkHub - Test Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #4361ee;
            --secondary: #3a0ca3;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #4ade80;
            --warning: #fbbf24;
            --danger: #f87171;
        }

        body {
            background-color: #f5f7ff;
            color: var(--dark);
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Navigation Bar */
        .navbar {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 15px 0;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.2);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.8rem;
            font-weight: 700;
            text-decoration: none;
            color: white;
        }

        .logo i {
            font-size: 2.2rem;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .nav-link.active {
            background-color: rgba(255, 255, 255, 0.25);
            font-weight: 600;
        }

        .user-info {
            background-color: rgba(255, 255, 255, 0.15);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Main Layout */
        .main-content {
            display: flex;
            gap: 25px;
        }

        /* Left Menu - Test Types */
        .test-menu {
            flex: 0 0 250px;
            background-color: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }

        .menu-title {
            color: var(--secondary);
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-title i {
            color: var(--accent);
        }

        .test-type-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 15px;
            margin-bottom: 12px;
            border: none;
            background-color: #f8f9ff;
            border-radius: 10px;
            color: var(--dark);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
        }

        .test-type-btn:hover {
            background-color: #eef1ff;
            transform: translateY(-2px);
        }

        .test-type-btn.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 5px 10px rgba(67, 97, 238, 0.3);
        }

        .test-type-btn i {
            font-size: 1.2rem;
        }

        /* Topic Selection Area */
        .topic-section {
            flex: 1;
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            min-height: 500px;
        }

        .section-title {
            color: var(--secondary);
            font-size: 1.4rem;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--accent);
        }

        .form-selector {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .form-btn {
            padding: 12px 25px;
            border: 2px solid #e2e7ff;
            background-color: white;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--dark);
        }

        .form-btn:hover {
            background-color: #f8f9ff;
        }

        .form-btn.active {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .topics-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .topic-card {
            background: linear-gradient(135deg, #f8f9ff, #eef1ff);
            border-radius: 12px;
            padding: 25px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .topic-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            border-color: var(--accent);
        }

        .topic-card.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, #eef1ff, #dfe5ff);
        }

        .topic-icon {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
        }

        .topic-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 8px;
        }

        .topic-desc {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Test Area */
        .test-area {
            display: none;
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .test-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .test-title {
            font-size: 1.6rem;
            color: var(--secondary);
        }

        .test-info {
            display: flex;
            gap: 15px;
        }

        .test-info-item {
            background-color: #f8f9ff;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .back-to-topics {
            background-color: #f0f2ff;
            color: var(--primary);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .back-to-topics:hover {
            background-color: #e2e7ff;
        }

        /* Quiz Specific Styles */
        .quiz-question {
            font-size: 1.3rem;
            margin-bottom: 25px;
            color: var(--dark);
            line-height: 1.5;
        }

        .quiz-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        .quiz-option {
            padding: 15px 20px;
            background-color: #f8f9ff;
            border: 2px solid #e2e7ff;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quiz-option:hover {
            background-color: #eef1ff;
        }

        .quiz-option.selected {
            background-color: #e2e7ff;
            border-color: var(--primary);
        }

        .quiz-option.correct {
            background-color: rgba(74, 222, 128, 0.15);
            border-color: var(--success);
        }

        .quiz-option.incorrect {
            background-color: rgba(248, 113, 113, 0.15);
            border-color: var(--danger);
        }

        .option-letter {
            width: 36px;
            height: 36px;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Test Controls */
        .test-controls {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
        }

        .btn-secondary {
            background-color: #f0f2ff;
            color: var(--primary);
        }

        .btn-secondary:hover {
            background-color: #e2e7ff;
        }

        .test-result {
            text-align: center;
            padding: 30px;
            background-color: #f8f9ff;
            border-radius: 12px;
            margin-top: 30px;
            display: none;
        }

        .result-title {
            font-size: 1.8rem;
            color: var(--secondary);
            margin-bottom: 15px;
        }

        .score {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            margin: 20px 0;
        }

        .result-message {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 25px;
        }

        /* Hidden form to submit results */
        .result-form {
            display: none;
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 40px;
            color: #666;
            font-size: 0.9rem;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        /* Responsive Design */
        @media (max-width: 1100px) {
            .main-content {
                flex-direction: column;
            }

            .test-menu {
                flex: 1;
                width: 100%;
            }

            .nav-menu {
                gap: 15px;
            }
        }

        @media (max-width: 768px) {
            .test-info {
                flex-direction: column;
                gap: 10px;
            }

            .test-controls {
                flex-direction: column;
                gap: 15px;
            }

            .nav-container {
                flex-direction: column;
                gap: 20px;
            }

            .nav-menu {
                flex-wrap: wrap;
                justify-content: center;
            }

            .form-selector {
                flex-direction: column;
            }
        }

    </style>
</head>
<body>
    <!-- Update the user info display -->
    <div class="user-info">
        <i class="fas fa-user"></i> <?php echo htmlspecialchars($userName); ?>
    </div>
    
 <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>HomeworkHub</span>
            </a>

            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="topic.php" class="nav-link">
                        <i class="fas fa-book-open"></i> Topic
                    </a>
                </li>
                <li class="nav-item">
                    <a href="test.php" class="nav-link active">
                        <i class="fas fa-file-alt"></i> Test
                    </a>
                </li>
                <li class="nav-item">
                    <a href="result.php" class="nav-link">
                        <i class="fas fa-chart-bar"></i> Result
                    </a>
                </li>
            </ul>

            <div class="user-info">
                <i class="fas fa-user"></i> <?php echo htmlspecialchars($userEmail); ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="main-content">
            <!-- Left Menu - Test Types -->
            <div class="test-menu">
                <div class="menu-title">
                    <i class="fas fa-list"></i> Test Types
                </div>
                <button class="test-type-btn active" data-type="quiz">
                    <i class="fas fa-question-circle"></i> QUIZ
                </button>
                <button class="test-type-btn" data-type="dragdrop">
                    <i class="fas fa-arrows-alt"></i> DRAG & DROP
                </button>
                <button class="test-type-btn" data-type="crossword">
                    <i class="fas fa-th"></i> CROSSWORD
                </button>
                <button class="test-type-btn" data-type="fillblank">
                    <i class="fas fa-edit"></i> FILL IN THE BLANK
                </button>
            </div>

            <!-- Topic Selection Area -->
            <div class="topic-section">
                <div class="section-title">
                    <i class="fas fa-book-open"></i> Select a Topic
                </div>

                <!-- Form Selection -->
                <div class="form-selector">
                    <button class="form-btn active" data-form="form4">
                        <i class="fas fa-graduation-cap"></i> Science Form 4
                    </button>
                    <button class="form-btn" data-form="form5">
                        <i class="fas fa-graduation-cap"></i> Science Form 5
                    </button>
                </div>

                <!-- Form 4 Topics -->
                <div class="topics-container" id="form4-topics">
                    <div class="topic-card active" data-topic="body-coordination">
                        <div class="topic-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <div class="topic-title">Body Coordination</div>
                        <div class="topic-desc">Nervous system, hormones, and human coordination</div>
                    </div>

                    <div class="topic-card" data-topic="heredity-variation">
                        <div class="topic-icon">
                            <i class="fas fa-dna"></i>
                        </div>
                        <div class="topic-title">Heredity and Variation</div>
                        <div class="topic-desc">Genetics, inheritance, and genetic variation</div>
                    </div>

                    <div class="topic-card" data-topic="matter-nature">
                        <div class="topic-icon">
                            <i class="fas fa-atom"></i>
                        </div>
                        <div class="topic-title">Matter in Nature</div>
                        <div class="topic-desc">States of matter, particles, and properties</div>
                    </div>

                    <div class="topic-card" data-topic="energy-chemical">
                        <div class="topic-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <div class="topic-title">Chemical Energy</div>
                        <div class="topic-desc">Chemical reactions, energy changes, and electrolysis</div>
                    </div>
                </div>

                <!-- Form 5 Topics -->
                <div class="topics-container" id="form5-topics" style="display: none;">
                    <div class="topic-card" data-topic="microorganisms">
                        <div class="topic-icon">
                            <i class="fas fa-bacteria"></i>
                        </div>
                        <div class="topic-title">Microorganisms</div>
                        <div class="topic-desc">Bacteria, viruses, fungi, and their effects</div>
                    </div>

                    <div class="topic-card" data-topic="nutrition-food">
                        <div class="topic-icon">
                            <i class="fas fa-apple-alt"></i>
                        </div>
                        <div class="topic-title">Nutrition and Food Production</div>
                        <div class="topic-desc">Balanced diet, food technology, and agriculture</div>
                    </div>

                    <div class="topic-card" data-topic="sustainability">
                        <div class="topic-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="topic-title">Sustainability of Environment</div>
                        <div class="topic-desc">Ecosystems, conservation, and environmental balance</div>
                    </div>

                    <div class="topic-card" data-topic="carbon-compounds">
                        <div class="topic-icon">
                            <i class="fas fa-oil-can"></i>
                        </div>
                        <div class="topic-title">Carbon Compounds</div>
                        <div class="topic-desc">Organic chemistry, hydrocarbons, and polymers</div>
                    </div>
                </div>

                <p style="color: #666; font-style: italic; text-align: center; margin-top: 20px;">
                    <i class="fas fa-info-circle"></i> First select a test type, then choose a topic.
                </p>
            </div>
        </div>

        <!-- Quiz Test Area -->
        <div class="test-area" id="quiz-test">
            <div class="test-header">
                <div>
                    <h2 class="test-title">Science Form 4: Body Coordination Quiz</h2>
                    <div class="test-info">
                        <div class="test-info-item">
                            <i class="fas fa-question-circle"></i> 5 Questions
                        </div>
                        <div class="test-info-item">
                            <i class="fas fa-clock"></i> 10 Minutes
                        </div>
                    </div>
                </div>
                <button class="back-to-topics">
                    <i class="fas fa-arrow-left"></i> Back to Topics
                </button>
            </div>

            <div class="quiz-question" id="quiz-question">Which part of the brain controls balance and coordination?
            </div>

            <div class="quiz-options" id="quiz-options">
                <div class="quiz-option" data-option="A">
                    <div class="option-letter">A</div>
                    <div class="option-text">Cerebellum</div>
                </div>
                <div class="quiz-option" data-option="B">
                    <div class="option-letter">B</div>
                    <div class="option-text">Cerebrum</div>
                </div>
                <div class="quiz-option" data-option="C">
                    <div class="option-letter">C</div>
                    <div class="option-text">Medulla oblongata</div>
                </div>
                <div class="quiz-option" data-option="D">
                    <div class="option-letter">D</div>
                    <div class="option-text">Hypothalamus</div>
                </div>
            </div>

            <div class="test-controls">
                <div>
                    <span id="quiz-progress">Question 1 of 5</span>
                </div>
                <div>
                    <button class="btn btn-secondary" id="prev-question">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <button class="btn btn-primary" id="next-question">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                    <button class="btn btn-primary" id="submit-quiz" style="display: none;">
                        <i class="fas fa-paper-plane"></i> Submit Quiz
                    </button>
                </div>
            </div>

            <div class="test-result" id="quiz-result">
                <h3 class="result-title">Quiz Results</h3>
                <div class="score">0/5</div>
                <p class="result-message" id="result-message">Your results will appear here.</p>
                
                <!-- Form to submit results -->
                <form id="result-form" action="save_result.php" method="POST" class="result-form">
                    <input type="hidden" name="test_type" value="quiz">
                    <input type="hidden" name="topic" id="result-topic" value="body-coordination">
                    <input type="hidden" name="score" id="result-score" value="0">
                    <input type="hidden" name="total" id="result-total" value="5">
                    <input type="hidden" name="time_spent" id="result-time" value="0">
                    
                    <button type="submit" class="btn btn-primary" id="save-result-btn">
                        <i class="fas fa-save"></i> Save Results & View Report
                    </button>
                </form>
                
                <button class="btn btn-secondary" id="retake-quiz">
                    <i class="fas fa-redo"></i> Try Again
                </button>
            </div>
        </div>

        <footer>
            <p>HomeworkHub - Interactive Assignment System &copy; 2023 | Test Page</p>
        </footer>
    </div>

    <script>
        // DOM Elements
        const testTypeButtons = document.querySelectorAll('.test-type-btn');
        const formButtons = document.querySelectorAll('.form-btn');
        const topicCards = document.querySelectorAll('.topic-card');
        const testAreas = document.querySelectorAll('.test-area');
        const backToTopicsButtons = document.querySelectorAll('.back-to-topics');
        const form4Topics = document.getElementById('form4-topics');
        const form5Topics = document.getElementById('form5-topics');

        // Current selection state
        let currentTestType = 'quiz';
        let currentForm = 'form4';
        let currentTopic = 'body-coordination';

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function () {
            // Set up event listeners for test type buttons
            testTypeButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const testType = this.getAttribute('data-type');
                    selectTestType(testType);
                });
            });

            // Set up event listeners for form buttons
            formButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const form = this.getAttribute('data-form');
                    selectForm(form);
                });
            });

            // Set up event listeners for topic cards
            topicCards.forEach(card => {
                card.addEventListener('click', function () {
                    const topic = this.getAttribute('data-topic');
                    selectTopic(topic);
                });
            });

            // Set up event listeners for back to topics buttons
            backToTopicsButtons.forEach(button => {
                button.addEventListener('click', function () {
                    showTopicSelection();
                });
            });

            // Initialize quiz functionality
            initializeQuiz();

            // Show topic selection by default
            showTopicSelection();
        });

        // Select a test type
        function selectTestType(testType) {
            currentTestType = testType;

            // Update active button
            testTypeButtons.forEach(button => {
                if (button.getAttribute('data-type') === testType) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            });

            // Highlight the active topic card
            highlightActiveTopic();
        }

        // Select a form
        function selectForm(form) {
            currentForm = form;

            // Update active button
            formButtons.forEach(button => {
                if (button.getAttribute('data-form') === form) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            });

            // Show the correct topics
            if (form === 'form4') {
                form4Topics.style.display = 'grid';
                form5Topics.style.display = 'none';
            } else {
                form4Topics.style.display = 'none';
                form5Topics.style.display = 'grid';
            }

            // Reset topic selection
            const firstTopicCard = document.querySelector(`#${form}-topics .topic-card`);
            if (firstTopicCard) {
                selectTopic(firstTopicCard.getAttribute('data-topic'));
            }
        }

        // Select a topic
        function selectTopic(topic) {
            currentTopic = topic;

            // Update active topic card
            topicCards.forEach(card => {
                if (card.getAttribute('data-topic') === topic) {
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                }
            });

            // Show the test for the selected type and topic
            showTest();
        }

        // Show the test based on current selections
        function showTest() {
            // Hide topic selection
            document.querySelector('.topic-section').style.display = 'none';

            // Hide all test areas
            testAreas.forEach(area => {
                area.style.display = 'none';
            });

            // Show the selected test area
            const selectedTestArea = document.getElementById(`${currentTestType}-test`);
            if (selectedTestArea) {
                selectedTestArea.style.display = 'block';
            }
        }

        // Show topic selection
        function showTopicSelection() {
            // Show topic selection
            document.querySelector('.topic-section').style.display = 'block';

            // Hide all test areas
            testAreas.forEach(area => {
                area.style.display = 'none';
            });
        }

        // ==================== QUIZ FUNCTIONALITY ====================
        function initializeQuiz() {
            const quizOptions = document.querySelectorAll('.quiz-option');
            const nextQuestionBtn = document.getElementById('next-question');
            const prevQuestionBtn = document.getElementById('prev-question');
            const submitQuizBtn = document.getElementById('submit-quiz');
            const retakeQuizBtn = document.getElementById('retake-quiz');
            const quizResult = document.getElementById('quiz-result');
            const saveResultBtn = document.getElementById('save-result-btn');
            const resultForm = document.getElementById('result-form');
            
            // Form elements for result submission
            const resultTopic = document.getElementById('result-topic');
            const resultScore = document.getElementById('result-score');
            const resultTotal = document.getElementById('result-total');
            const resultTime = document.getElementById('result-time');

            let currentQuestion = 1;
            const totalQuestions = 5;
            const userAnswers = {};
            let startTime = null;
            let endTime = null;

            // Quiz questions data for each topic
            const quizData = {
                'body-coordination': [
                    {
                        question: "Which part of the brain controls balance and coordination?",
                        options: ["Cerebellum", "Cerebrum", "Medulla oblongata", "Hypothalamus"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What type of neurons carry signals from receptors to the central nervous system?",
                        options: ["Sensory neurons", "Motor neurons", "Interneurons", "Relay neurons"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Which hormone is responsible for the 'fight or flight' response?",
                        options: ["Adrenaline", "Insulin", "Thyroxine", "Estrogen"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What is the function of the myelin sheath?",
                        options: ["Speeds up nerve impulse transmission", "Produces neurotransmitters", "Receives signals from other neurons", "Protects the brain"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Which gland is known as the 'master gland'?",
                        options: ["Pituitary gland", "Thyroid gland", "Adrenal gland", "Pancreas"],
                        correctAnswer: "A"
                    }
                ],
                'heredity-variation': [
                    {
                        question: "What carries genetic information in cells?",
                        options: ["DNA", "RNA", "Proteins", "Carbohydrates"],
                        correctAnswer: "A"
                    },
                    {
                        question: "How many chromosomes do humans have in each body cell?",
                        options: ["46", "23", "48", "24"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What is the term for different forms of the same gene?",
                        options: ["Alleles", "Chromosomes", "Genotypes", "Phenotypes"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Which genetic disorder results from an extra chromosome 21?",
                        options: ["Down syndrome", "Turner syndrome", "Klinefelter syndrome", "Cystic fibrosis"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Who is known as the father of genetics?",
                        options: ["Gregor Mendel", "Charles Darwin", "James Watson", "Francis Crick"],
                        correctAnswer: "A"
                    }
                ],
                'matter-nature': [
                    {
                        question: "Which state of matter has a definite volume but no definite shape?",
                        options: ["Liquid", "Solid", "Gas", "Plasma"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What happens to particles when a solid melts?",
                        options: ["They gain energy and move more", "They lose energy and move less", "They change chemically", "They disappear"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What is sublimation?",
                        options: ["Solid changing directly to gas", "Gas changing directly to solid", "Liquid changing to gas", "Solid changing to liquid"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Which has the strongest forces between particles?",
                        options: ["Solid", "Liquid", "Gas", "All have equal forces"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What is evaporation?",
                        options: ["Liquid changing to gas at surface", "Gas changing to liquid", "Solid changing to gas", "Liquid changing to solid"],
                        correctAnswer: "A"
                    }
                ],
                'energy-chemical': [
                    {
                        question: "What type of energy is stored in chemical bonds?",
                        options: ["Chemical energy", "Thermal energy", "Kinetic energy", "Electrical energy"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Which process releases energy?",
                        options: ["Exothermic reaction", "Endothermic reaction", "Photosynthesis", "Evaporation"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What is the principle of conservation of energy?",
                        options: ["Energy cannot be created or destroyed", "Energy can be created", "Energy can be destroyed", "Energy decreases over time"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Which device converts chemical energy to electrical energy?",
                        options: ["Battery", "Generator", "Solar panel", "Wind turbine"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What is activation energy?",
                        options: ["Energy needed to start a reaction", "Energy released in a reaction", "Energy stored in products", "Energy lost as heat"],
                        correctAnswer: "A"
                    }
                ],
                'microorganisms': [
                    {
                        question: "Which microorganism is used in making bread?",
                        options: ["Yeast", "Bacteria", "Virus", "Fungus"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What causes malaria?",
                        options: ["Plasmodium", "Bacteria", "Virus", "Fungus"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Which is the smallest microorganism?",
                        options: ["Virus", "Bacteria", "Fungus", "Protozoa"],
                        correctAnswer: "A"
                    },
                    {
                        question: "What is pasteurization?",
                        options: ["Heating to kill bacteria", "Freezing food", "Adding preservatives", "Drying food"],
                        correctAnswer: "A"
                    },
                    {
                        question: "Which microorganism causes COVID-19?",
                        options: ["Coronavirus", "Bacteria", "Fungus", "Protozoa"],
                        correctAnswer: "A"
                    }
                ]
            };

            // Event listeners for quiz options
            quizOptions.forEach(option => {
                option.addEventListener('click', function () {
                    // Remove selected class from all options
                    quizOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Store user's answer
                    userAnswers[currentQuestion] = this.getAttribute('data-option');
                });
            });

            // Next question button
            nextQuestionBtn.addEventListener('click', function () {
                if (currentQuestion < totalQuestions) {
                    currentQuestion++;
                    updateQuizQuestion();
                }

                // Show submit button on last question
                if (currentQuestion === totalQuestions) {
                    nextQuestionBtn.style.display = 'none';
                    submitQuizBtn.style.display = 'block';
                }

                // Always show previous button after first question
                if (currentQuestion > 1) {
                    prevQuestionBtn.style.display = 'inline-block';
                }
            });

            // Previous question button
            prevQuestionBtn.addEventListener('click', function () {
                if (currentQuestion > 1) {
                    currentQuestion--;
                    updateQuizQuestion();
                }

                // Hide previous button on first question
                if (currentQuestion === 1) {
                    prevQuestionBtn.style.display = 'none';
                }

                // Show next button if we're not on last question
                if (currentQuestion < totalQuestions) {
                    nextQuestionBtn.style.display = 'inline-block';
                    submitQuizBtn.style.display = 'none';
                }
            });

            // Submit quiz button
            submitQuizBtn.addEventListener('click', function () {
                // Record end time
                endTime = new Date();
                
                // Calculate score
                let score = 0;
                const questions = quizData[currentTopic] || quizData['body-coordination'];

                for (let i = 1; i <= totalQuestions; i++) {
                    if (userAnswers[i] === questions[i - 1].correctAnswer) {
                        score++;
                    }
                }

                // Calculate time spent in minutes
                const timeSpent = startTime ? Math.round((endTime - startTime) / 1000 / 60) : 5;
                
                // Display result
                const scoreElement = document.querySelector('#quiz-result .score');
                const messageElement = document.getElementById('result-message');
                
                scoreElement.textContent = `${score}/${totalQuestions}`;
                
                if (score === totalQuestions) {
                    messageElement.textContent = "Excellent! Perfect score!";
                    messageElement.style.color = "var(--success)";
                } else if (score >= totalQuestions * 0.7) {
                    messageElement.textContent = "Great job! You have a good understanding of this topic.";
                    messageElement.style.color = "var(--success)";
                } else if (score >= totalQuestions * 0.5) {
                    messageElement.textContent = "Good effort! Keep practicing to improve.";
                    messageElement.style.color = "var(--warning)";
                } else {
                    messageElement.textContent = "Keep studying! Review the topic and try again.";
                    messageElement.style.color = "var(--danger)";
                }

                // Update form values
                resultTopic.value = currentTopic;
                resultScore.value = score;
                resultTotal.value = totalQuestions;
                resultTime.value = timeSpent;
                
                // Show result section and form
                quizResult.style.display = 'block';
                resultForm.style.display = 'block';
                
                // Scroll to results
                quizResult.scrollIntoView({ behavior: 'smooth' });
            });

            // Save result button - now submits form
            saveResultBtn.addEventListener('click', function(e) {
                // The form will handle the submission via POST
                // We'll let it submit normally
            });

            // Retake quiz button
            retakeQuizBtn.addEventListener('click', function () {
                // Reset quiz
                currentQuestion = 1;
                startTime = new Date(); // Reset start time
                Object.keys(userAnswers).forEach(key => delete userAnswers[key]);
                quizResult.style.display = 'none';
                nextQuestionBtn.style.display = 'inline-block';
                submitQuizBtn.style.display = 'none';
                prevQuestionBtn.style.display = 'none';
                updateQuizQuestion();

                // Clear selections
                quizOptions.forEach(opt => {
                    opt.classList.remove('selected', 'correct', 'incorrect');
                });
            });

            // Update quiz question based on current topic
            function updateQuizQuestion() {
                const questions = quizData[currentTopic] || quizData['body-coordination'];
                const currentQuizData = questions[currentQuestion - 1];

                if (currentQuizData) {
                    document.getElementById('quiz-question').textContent = currentQuizData.question;

                    const options = document.querySelectorAll('.quiz-option');
                    options.forEach((option, index) => {
                        option.querySelector('.option-text').textContent = currentQuizData.options[index];
                    });

                    // Update progress
                    document.getElementById('quiz-progress').textContent = `Question ${currentQuestion} of ${totalQuestions}`;

                    // Restore user's previous answer for this question if exists
                    if (userAnswers[currentQuestion]) {
                        options.forEach(option => {
                            if (option.getAttribute('data-option') === userAnswers[currentQuestion]) {
                                option.classList.add('selected');
                            }
                        });
                    } else {
                        options.forEach(option => option.classList.remove('selected'));
                    }
                }
                
                // Start timer on first question
                if (currentQuestion === 1 && !startTime) {
                    startTime = new Date();
                }
            }

            // Initialize first question
            updateQuizQuestion();
            prevQuestionBtn.style.display = 'none';
            startTime = new Date(); // Start timer
        }
    </script>
</body>
</html>