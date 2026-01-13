<?php
require_once 'config.php';
checkLogin();

$user = getCurrentUser();

// Get test results from database
$pdo = getPDO();
$stmt = $pdo->prepare("SELECT * FROM test_results WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user['id']]);
$testResults = $stmt->fetchAll();

// Calculate overall statistics
$totalTests = count($testResults);
$totalScore = 0;
$totalPossible = 0;

foreach ($testResults as $result) {
    $totalScore += $result['score'];
    $totalPossible += $result['total_questions'];
}

$overallPercentage = $totalPossible > 0 ? round(($totalScore / $totalPossible) * 100) : 0;

// Get last test result
$lastTestResult = $testResults[0] ?? null;

// Get subject progress from database
$stmt = $pdo->prepare("SELECT * FROM user_progress WHERE user_id = ?");
$stmt->execute([$user['id']]);
$subjectProgressRows = $stmt->fetchAll();

$subjectProgress = [];
foreach ($subjectProgressRows as $row) {
    $subjectProgress[$row['subject']] = $row['progress_percent'];
}

// Default subjects if no data
if (empty($subjectProgress)) {
    $subjectProgress = [
        'Mathematics' => 85,
        'Science' => 72,
        'Language Arts' => 90,
        'Social Studies' => 65
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeworkHub - Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
      * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #6C63FF;
            --secondary: #FF6584;
            --accent: #36D1DC;
            --success: #4CAF50;
            --warning: #FF9800;
            --light: #F8F9FA;
            --dark: #2D3436;
            --gradient: linear-gradient(135deg, var(--primary), var(--accent));
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background-color: #f0f2f5;
            color: var(--dark);
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(108, 99, 255, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(255, 101, 132, 0.1) 0%, transparent 20%);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header & Navigation */
        header {
            background: white;
            border-radius: 20px;
            padding: 20px 40px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .logo-text h1 {
            font-size: 28px;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .logo-text p {
            font-size: 14px;
            color: #6c757d;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(108, 99, 255, 0.1);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
        }

        nav {
            display: flex;
            gap: 10px;
        }

        .nav-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            background: transparent;
            color: var(--dark);
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .nav-btn i {
            font-size: 18px;
        }

        .nav-btn:hover {
            transform: translateY(-3px);
        }

        .nav-btn.active {
            background: var(--gradient);
            color: white;
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
        }

        /* Success Message */
        .success-message {
            background: linear-gradient(135deg, var(--success), #66BB6A);
            color: white;
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: <?php echo isset($_GET['success']) ? 'flex' : 'none'; ?>;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Last Test Result */
        .last-test-result {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            border-left: 5px solid var(--primary);
            display: <?php echo $lastTestResult ? 'block' : 'none'; ?>;
        }

        .last-test-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .last-test-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
        }

        .last-test-grade {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            background: rgba(108, 99, 255, 0.1);
            padding: 5px 15px;
            border-radius: 20px;
        }

        .last-test-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .detail-item {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .detail-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .detail-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Stats Overview */
        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 20px;
            color: white;
        }

        .stat-card:nth-child(1) .stat-icon {
            background: linear-gradient(135deg, var(--primary), #8A84FF);
        }

        .stat-card:nth-child(2) .stat-icon {
            background: linear-gradient(135deg, var(--accent), #5CE1E6);
        }

        .stat-card:nth-child(3) .stat-icon {
            background: linear-gradient(135deg, var(--secondary), #FF7B95);
        }

        .stat-card:nth-child(4) .stat-icon {
            background: linear-gradient(135deg, var(--success), #6BCF6F);
        }

        .stat-value {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 16px;
        }

        /* Progress Chart */
        .progress-chart {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
        }

        .progress-chart h3 {
            font-size: 24px;
            margin-bottom: 30px;
            color: var(--dark);
        }

        .subject-progress {
            margin-bottom: 30px;
        }

        .subject-row {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .subject-name {
            width: 150px;
            font-weight: 600;
            color: var(--dark);
        }

        .progress-container {
            flex: 1;
            height: 20px;
            background: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 0 20px;
        }

        .progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 1s ease;
        }

        .progress-percent {
            width: 60px;
            text-align: right;
            font-weight: 600;
            color: var(--dark);
        }

        /* Recent Results */
        .recent-results {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
        }

        .recent-results h3 {
            font-size: 24px;
            margin-bottom: 30px;
            color: var(--dark);
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
        }

        .results-table th {
            text-align: left;
            padding: 15px;
            border-bottom: 2px solid #e9ecef;
            color: #6c757d;
            font-weight: 600;
        }

        .results-table td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .result-row:hover {
            background: #f8f9fa;
        }

        .score-cell {
            font-weight: 600;
        }

        .score-cell.high {
            color: var(--success);
        }

        .score-cell.medium {
            color: var(--warning);
        }

        .score-cell.low {
            color: var(--secondary);
        }

        .action-btn {
            padding: 8px 15px;
            background: #f8f9fa;
            border: none;
            border-radius: 8px;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
        }

        .action-btn:hover {
            background: var(--gradient);
            color: white;
        }

        .no-results {
            text-align: center;
            padding: 50px;
            color: #6c757d;
        }

        .no-results i {
            font-size: 48px;
            margin-bottom: 20px;
            color: #e9ecef;
        }

        /* Page Info */
        .page-info {
            background: white;
            border-radius: 20px;
            padding: 25px 40px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }

        .page-number {
            font-size: 18px;
            color: var(--primary);
            font-weight: 600;
            background: rgba(108, 99, 255, 0.1);
            padding: 8px 20px;
            border-radius: 50px;
        }

        .page-description {
            max-width: 600px;
            color: #6c757d;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 20px;
                padding: 20px;
            }

            nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .nav-btn {
                padding: 10px 20px;
                font-size: 14px;
            }

            .stats-overview {
                grid-template-columns: 1fr;
            }

            .subject-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .subject-name {
                width: 100%;
            }

            .progress-container {
                width: 100%;
                margin: 0;
            }

            .progress-percent {
                width: 100%;
                text-align: left;
            }

            .results-table {
                display: block;
                overflow-x: auto;
            }

            .page-info {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .last-test-details {
                grid-template-columns: repeat(2, 1fr);
            }
        }

    </style>
</head>
<body>
    <!-- Update user info -->
    <div class="user-info">
        <i class="fas fa-user"></i> <?php echo htmlspecialchars($user['full_name'] ?? $user['email']); ?>
    </div>
    
    <!-- Update last test result display -->
    <?php if ($lastTestResult): ?>
    <div class="last-test-result">
        <div class="last-test-header">
            <div class="last-test-title">Latest Test: <?php echo ucfirst($lastTestResult['test_type']) . " - " . ucwords(str_replace('-', ' ', $lastTestResult['topic'])); ?></div>
            <div class="last-test-grade">Grade: <?php echo $lastTestResult['grade']; ?></div>
        </div>
        <div class="last-test-details">
            <div class="detail-item">
                <div class="detail-value"><?php echo $lastTestResult['score']; ?>/<?php echo $lastTestResult['total_questions']; ?></div>
                <div class="detail-label">Score</div>
            </div>
            <div class="detail-item">
                <div class="detail-value"><?php echo $lastTestResult['percentage']; ?>%</div>
                <div class="detail-label">Percentage</div>
            </div>
            <div class="detail-item">
                <div class="detail-value"><?php echo $lastTestResult['time_spent']; ?> min</div>
                <div class="detail-label">Time Spent</div>
            </div>
            <div class="detail-item">
                <div class="detail-value"><?php echo date('M d, Y', strtotime($lastTestResult['created_at'])); ?></div>
                <div class="detail-label">Date</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Update recent results table -->
    <?php if (!empty($testResults)): ?>
    <table class="results-table">
        <thead>
            <tr>
                <th>Test Name</th>
                <th>Date</th>
                <th>Score</th>
                <th>Time Spent</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody id="results-container">
            <?php foreach ($testResults as $result): 
                $scoreClass = 'score-cell ';
                if ($result['percentage'] >= 80) $scoreClass .= 'high';
                elseif ($result['percentage'] >= 60) $scoreClass .= 'medium';
                else $scoreClass .= 'low';
            ?>
            <tr class="result-row">
                <td><strong><?php echo ucfirst($result['test_type']) . " - " . ucwords(str_replace('-', ' ', $result['topic'])); ?></strong></td>
                <td><?php echo date('Y-m-d', strtotime($result['created_at'])); ?></td>
                <td class="<?php echo $scoreClass; ?>"><?php echo $result['score']; ?>/<?php echo $result['total_questions']; ?> (<?php echo $result['percentage']; ?>%)</td>
                <td><?php echo $result['time_spent']; ?> min</td>
                <td><strong><?php echo $result['grade']; ?></strong></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    
     <div class="container">
        <!-- Header with Navigation -->
        <header>
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text">
                    <h1>HomeworkHub</h1>
                    <p>Interactive Assignment System</p>
                </div>
            </div>

            <nav>
                <a href="index.php" class="nav-btn">
                    <i class="fas fa-home"></i> HOME
                </a>
                <a href="topic.php" class="nav-btn">
                    <i class="fas fa-book-open"></i> TOPIC
                </a>
                <a href="test.php" class="nav-btn">
                    <i class="fas fa-pencil-alt"></i> TEST
                </a>
                <a href="result.php" class="nav-btn active">
                    <i class="fas fa-chart-line"></i> RESULT
                </a>
            </nav>

            <div class="user-info">
                <i class="fas fa-user"></i> <?php echo htmlspecialchars($userEmail); ?>
            </div>
        </header>

        <!-- Success Message -->
        <?php if (isset($_GET['success'])): ?>
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Test submitted successfully!</strong>
                <p>Your results have been saved. View your performance below.</p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Last Test Result -->
        <?php if ($lastTestResult): ?>
        <div class="last-test-result">
            <div class="last-test-header">
                <div class="last-test-title">Latest Test: <?php echo $lastTestResult['testName']; ?></div>
                <div class="last-test-grade">Grade: <?php echo $lastTestResult['grade']; ?></div>
            </div>
            <div class="last-test-details">
                <div class="detail-item">
                    <div class="detail-value"><?php echo $lastTestResult['score']; ?>/<?php echo $lastTestResult['total']; ?></div>
                    <div class="detail-label">Score</div>
                </div>
                <div class="detail-item">
                    <div class="detail-value"><?php echo $lastTestResult['percentage']; ?>%</div>
                    <div class="detail-label">Percentage</div>
                </div>
                <div class="detail-item">
                    <div class="detail-value"><?php echo $lastTestResult['timeSpent']; ?> min</div>
                    <div class="detail-label">Time Spent</div>
                </div>
                <div class="detail-item">
                    <div class="detail-value"><?php echo date('M d, Y', strtotime($lastTestResult['date'])); ?></div>
                    <div class="detail-label">Date</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Page Title -->
        <div class="page-title">
            <h2>Results & Progress</h2>
            <p>Track your learning journey with detailed analytics and performance reports.</p>
        </div>

        <!-- Stats Overview -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-value"><?php echo $overallPercentage; ?>%</div>
                <div class="stat-label">Overall Score</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value"><?php echo $totalTests; ?></div>
                <div class="stat-label">Completed Tests</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-value"><?php echo $totalTests * 5; ?>m</div>
                <div class="stat-label">Total Study Time</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-value">+<?php echo $improvement; ?>%</div>
                <div class="stat-label">Improvement</div>
            </div>
        </div>

        <!-- Progress Chart -->
        <div class="progress-chart">
            <h3>Subject Progress</h3>
            <div class="subject-progress">
                <?php foreach ($subjectProgress as $subject => $percentage): ?>
                <div class="subject-row">
                    <div class="subject-name"><?php echo $subject; ?></div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: <?php echo $percentage; ?>%; background: <?php 
                            echo $percentage >= 80 ? 'var(--success)' : 
                                  ($percentage >= 60 ? 'var(--warning)' : 'var(--secondary)'); 
                        ?>;"></div>
                    </div>
                    <div class="progress-percent"><?php echo $percentage; ?>%</div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Recent Results -->
        <div class="recent-results">
            <h3>Recent Test Results</h3>

            <?php if (empty($testResults)): ?>
            <div class="no-results">
                <i class="fas fa-clipboard-list"></i>
                <h4>No Test Results Yet</h4>
                <p>Take a test to see your results here!</p>
                <a href="test.php" class="action-btn" style="margin-top: 20px; display: inline-block;">
                    <i class="fas fa-pencil-alt"></i> Take a Test
                </a>
            </div>
            <?php else: ?>
            <table class="results-table">
                <thead>
                    <tr>
                        <th>Test Name</th>
                        <th>Date</th>
                        <th>Score</th>
                        <th>Time Spent</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody id="results-container">
                    <?php foreach ($testResults as $result): 
                        $scoreClass = 'score-cell ';
                        if ($result['percentage'] >= 80) $scoreClass .= 'high';
                        elseif ($result['percentage'] >= 60) $scoreClass .= 'medium';
                        else $scoreClass .= 'low';
                    ?>
                    <tr class="result-row">
                        <td><strong><?php echo $result['testName']; ?></strong></td>
                        <td><?php echo date('Y-m-d', strtotime($result['date'])); ?></td>
                        <td class="<?php echo $scoreClass; ?>"><?php echo $result['score']; ?>/<?php echo $result['total']; ?> (<?php echo $result['percentage']; ?>%)</td>
                        <td><?php echo $result['timeSpent']; ?> min</td>
                        <td><strong><?php echo $result['grade']; ?></strong></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

        <!-- Page Info -->
        <div class="page-info">
            <div class="page-number">RESULT PAGE</div>
            <div class="page-description">
                <p>This is the Result Page, showing test results, progress analytics, and performance statistics. Users
                    can track their improvement over time.</p>
            </div>
        </div>
    </div>

    <script>
        // Animate progress bars
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => {
                document.querySelectorAll('.progress-bar').forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 100);
                });
            }, 500);
        });
    </script>
</body>
</html>