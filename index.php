<?php
require_once 'config.php';

// Check if user is logged in
$user = getCurrentUser();
$isLoggedIn = ($user !== null);

// Get user stats if logged in
$userStats = null;
$userName = '';
if ($isLoggedIn) {
    $userName = $user['full_name'] ?? $user['email'] ?? 'User';
    $pdo = getPDO();
    
    try {
        // Get total tests taken
        $sql = "SELECT COUNT(*) as total_tests FROM test_results WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user['id']]);
        $totalTests = $stmt->fetchColumn();
        
        // Get average score
        $sql = "SELECT AVG(percentage) as avg_score FROM test_results WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user['id']]);
        $avgScore = $stmt->fetchColumn();
        
        // Get recent activity
        $sql = "SELECT test_type, topic, score, total_questions, percentage, grade, created_at 
                FROM test_results 
                WHERE user_id = ? 
                ORDER BY created_at DESC 
                LIMIT 3";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user['id']]);
        $recentTests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $userStats = [
            'total_tests' => $totalTests ?: 0,
            'avg_score' => $avgScore ? round($avgScore, 1) : 0,
            'recent_tests' => $recentTests
        ];
        
    } catch(PDOException $e) {
        error_log("Error fetching user stats: " . $e->getMessage());
        $userStats = [
            'total_tests' => 0,
            'avg_score' => 0,
            'recent_tests' => []
        ];
    }
}

// Handle messages
$logoutMessage = '';
$loginMessage = '';
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    $logoutMessage = 'You have been successfully logged out.';
} elseif (isset($_GET['login']) && $_GET['login'] == 'success') {
    $loginMessage = 'Welcome back! You have been successfully logged in.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeworkHub - Home</title>
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

        .user-info i {
            color: var(--primary);
        }

        nav {
            display: flex;
            gap: 10px;
            align-items: center;
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

        .logout-btn {
            background: rgba(255, 101, 132, 0.1);
            color: var(--secondary);
        }

        .logout-btn:hover {
            background: var(--secondary);
            color: white;
        }

        /* System Messages */
        .system-message {
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideIn 0.5s ease;
            position: relative;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-success {
            background: linear-gradient(135deg, var(--success), #66BB6A);
            color: white;
        }

        .message-info {
            background: linear-gradient(135deg, var(--accent), #36D1DC);
            color: white;
        }

        .message-warning {
            background: linear-gradient(135deg, var(--warning), #FFB74D);
            color: white;
        }

        .message-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .message-content i {
            font-size: 20px;
        }

        .close-message {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .close-message:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* User Dashboard for Logged In Users */
        .user-dashboard {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .welcome-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .welcome-avatar {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
        }

        .welcome-content h2 {
            font-size: 24px;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .welcome-content p {
            color: #6c757d;
            margin-bottom: 15px;
        }

        .user-stats {
            display: flex;
            gap: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 15px 20px;
            background: rgba(108, 99, 255, 0.05);
            border-radius: 12px;
            min-width: 100px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .quick-actions {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .quick-actions h3 {
            font-size: 18px;
            color: var(--dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .action-btn {
            padding: 15px;
            background: #f8f9fa;
            border: none;
            border-radius: 12px;
            color: var(--dark);
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: left;
            text-decoration: none;
        }

        .action-btn:hover {
            background: var(--gradient);
            color: white;
            transform: translateX(5px);
        }

        .action-btn i {
            font-size: 18px;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .recent-activity h3 {
            font-size: 20px;
            color: var(--dark);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .activity-list {
            display: grid;
            gap: 15px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
            transition: var(--transition);
        }

        .activity-item:hover {
            background: rgba(108, 99, 255, 0.05);
        }

        .activity-icon {
            width: 50px;
            height: 50px;
            background: rgba(108, 99, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 20px;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .activity-details {
            display: flex;
            gap: 15px;
            font-size: 12px;
            color: #6c757d;
        }

        .activity-score {
            font-weight: 600;
            color: var(--success);
        }

        /* Login prompt for guest users */
        .guest-welcome {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .guest-welcome-content h2 {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .guest-welcome-content p {
            font-size: 18px;
            opacity: 0.9;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .guest-actions {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .guest-btn {
            padding: 15px 35px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            backdrop-filter: blur(10px);
            text-decoration: none;
        }

        .guest-btn.primary {
            background: white;
            color: var(--primary);
            border-color: white;
        }

        .guest-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Main Content */
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        /* Hero Section */
        .hero-section {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-section h2 {
            font-size: 42px;
            margin-bottom: 20px;
            line-height: 1.2;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-section p {
            font-size: 18px;
            color: #6c757d;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .stats {
            display: flex;
            gap: 30px;
            margin-top: 20px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
        }

        /* Image Gallery */
        .image-gallery {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .image-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            height: 250px;
            background: linear-gradient(45deg, var(--primary), var(--accent));
        }

        .image-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .image-card.large {
            grid-column: span 2;
            height: 300px;
        }

        .image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .image-card:hover img {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            color: white;
            padding: 20px;
            transform: translateY(100%);
            transition: var(--transition);
        }

        .image-card:hover .image-overlay {
            transform: translateY(0);
        }

        /* Subject Overview */
        .subject-overview {
            grid-column: span 2;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow);
        }

        .subject-overview h3 {
            font-size: 28px;
            margin-bottom: 20px;
            color: var(--dark);
        }

        .subject-description {
            font-size: 16px;
            line-height: 1.8;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .subject-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .feature {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            transition: var(--transition);
            cursor: pointer;
        }

        .feature:hover {
            transform: translateY(-5px);
            background: var(--gradient);
            color: white;
        }

        .feature:hover .feature-icon {
            background: white;
            color: var(--primary);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            background: var(--gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .feature h4 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .feature p {
            font-size: 14px;
            opacity: 0.9;
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
        @media (max-width: 992px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .image-gallery {
                grid-template-columns: 1fr;
            }

            .image-card.large {
                grid-column: span 1;
            }

            .user-dashboard {
                grid-template-columns: 1fr;
            }
        }

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

            .hero-section h2 {
                font-size: 32px;
            }

            .page-info {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .guest-actions {
                flex-direction: column;
                align-items: center;
            }

            .guest-btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .welcome-card {
                flex-direction: column;
                text-align: center;
            }

            .user-stats {
                justify-content: center;
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
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
                <a href="index.php" class="nav-btn active">
                    <i class="fas fa-home"></i> HOME
                </a>
                <a href="topic.php" class="nav-btn">
                    <i class="fas fa-book-open"></i> TOPIC
                </a>
                <a href="test.php" class="nav-btn">
                    <i class="fas fa-pencil-alt"></i> TEST
                </a>
                <a href="result.php" class="nav-btn">
                    <i class="fas fa-chart-line"></i> RESULT
                </a>
                
                <?php if ($isLoggedIn): ?>
                <div class="user-info">
                    <i class="fas fa-user"></i> <?php echo htmlspecialchars($userName); ?>
                </div>
                <a href="logout.php" class="nav-btn logout-btn">
                    <i class="fas fa-sign-out-alt"></i> LOGOUT
                </a>
                <?php else: ?>
                <a href="login.php" class="nav-btn" style="background: var(--gradient); color: white;">
                    <i class="fas fa-sign-in-alt"></i> LOGIN
                </a>
                <?php endif; ?>
            </nav>
        </header>

        <!-- System Messages -->
        <?php if ($logoutMessage): ?>
        <div class="system-message message-success" id="logout-message">
            <div class="message-content">
                <i class="fas fa-check-circle"></i>
                <span><?php echo $logoutMessage; ?></span>
            </div>
            <button class="close-message" onclick="closeMessage('logout-message')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>

        <?php if ($loginMessage): ?>
        <div class="system-message message-success" id="login-message">
            <div class="message-content">
                <i class="fas fa-check-circle"></i>
                <span><?php echo $loginMessage; ?></span>
            </div>
            <button class="close-message" onclick="closeMessage('login-message')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php endif; ?>

        <!-- User Dashboard (for logged in users) -->
        <?php if ($isLoggedIn): ?>
        <div class="user-dashboard">
            <div class="welcome-card">
                <div class="welcome-avatar">
                    <?php echo strtoupper(substr($userName, 0, 1)); ?>
                </div>
                <div class="welcome-content">
                    <h2>Welcome back, <?php echo htmlspecialchars($userName); ?>!</h2>
                    <p>Continue your learning journey with personalized recommendations and track your progress.</p>
                    <div class="user-stats">
                        <div class="stat-item">
                            <div class="stat-value"><?php echo $userStats['total_tests'] ?? 0; ?></div>
                            <div class="stat-label">Tests Taken</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo $userStats['avg_score'] ?? 0; ?>%</div>
                            <div class="stat-label">Avg Score</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo date('H:i'); ?></div>
                            <div class="stat-label">Current Time</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                <div class="action-buttons">
                    <a href="test.php" class="action-btn">
                        <i class="fas fa-play-circle"></i>
                        <span>Take a Test</span>
                    </a>
                    <a href="result.php" class="action-btn">
                        <i class="fas fa-chart-line"></i>
                        <span>View Results</span>
                    </a>
                    <a href="topic.php" class="action-btn">
                        <i class="fas fa-book"></i>
                        <span>Browse Topics</span>
                    </a>
                    <button class="action-btn" onclick="showProfile()">
                        <i class="fas fa-user-cog"></i>
                        <span>Profile Settings</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <?php if (!empty($userStats['recent_tests'])): ?>
        <div class="recent-activity">
            <h3><i class="fas fa-history"></i> Recent Activity</h3>
            <div class="activity-list">
                <?php foreach ($userStats['recent_tests'] as $test): ?>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title"><?php echo htmlspecialchars($test['topic']); ?> Test</div>
                        <div class="activity-details">
                            <span class="activity-score">Score: <?php echo $test['score']; ?>/<?php echo $test['total_questions']; ?> (<?php echo $test['grade']; ?>)</span>
                            <span><?php echo date('M d, Y', strtotime($test['created_at'])); ?></span>
                            <span><?php echo $test['test_type']; ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <!-- Guest Welcome Section -->
        <?php if (!$isLoggedIn): ?>
        <div class="guest-welcome">
            <div class="guest-welcome-content">
                <h2>Welcome to HomeworkHub!</h2>
                <p>Transform your learning experience with interactive assignments, detailed progress tracking, and personalized study plans designed to help you achieve academic excellence.</p>
                <div class="guest-actions">
                    <a href="login.php" class="guest-btn primary">
                        <i class="fas fa-sign-in-alt"></i> Login / Register
                    </a>
                    <button class="guest-btn" onclick="showDemo()">
                        <i class="fas fa-eye"></i> View Demo
                    </button>
                    <button class="guest-btn" onclick="scrollToFeatures()">
                        <i class="fas fa-info-circle"></i> Learn More
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Hero Section -->
            <section class="hero-section">
                <h2>Welcome to Interactive Learning</h2>
                <p>HomeworkHub transforms traditional assignments into engaging interactive experiences. Explore topics, take tests, and track your progress all in one platform.</p>

                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Topics Available</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">85%</div>
                        <div class="stat-label">Success Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">4.8</div>
                        <div class="stat-label">User Rating</div>
                    </div>
                </div>
            </section>

            <!-- Image Gallery -->
            <div class="image-gallery">
                <div class="image-card">
                    <img src="https://thumbs.dreamstime.com/b/sabah-malaysia-april-classroom-malaysian-primary-school-children-kota-kinabalu-having-english-language-lesson-using-107488957.jpg"
                        alt="Interactive Learning">
                    <div class="image-overlay">
                        <h4>Interactive Learning</h4>
                        <p>Engaging educational activities</p>
                    </div>
                </div>

                <div class="image-card">
                    <img src="https://ajar.com.my/wp-content/uploads/2018/11/edud_jk_pg6g_4cols_1805-768x514.jpg"
                        alt="Study Group">
                    <div class="image-overlay">
                        <h4>Collaborative Study</h4>
                        <p>Work together with classmates</p>
                    </div>
                </div>

                <div class="image-card large">
                    <img src="https://iluminasi.com/img/upload/budak-sekolah-gembira-dapat-keputusan-cemerlang.jpg"
                        alt="Modern Classroom">
                    <div class="image-overlay">
                        <h4>Modern Classroom</h4>
                        <p>Advanced tools for better education</p>
                    </div>
                </div>
            </div>

            <!-- Subject Overview -->
            <section class="subject-overview">
                <h3>General Subject Overview</h3>
                <div class="subject-description">
                    <p>HomeworkHub offers a comprehensive learning platform covering multiple subjects including
                        Mathematics, Science, Language Arts, and Social Studies. Our interactive approach combines
                        traditional learning methods with modern technology to create an engaging educational
                        experience.</p>
                    <p>Each topic is designed with interactive elements, practice tests, and progress tracking to ensure
                        students not only learn but retain knowledge effectively. The system adapts to individual
                        learning styles and provides personalized feedback for continuous improvement.</p>
                </div>

                <div class="subject-features">
                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h4>Interactive Lessons</h4>
                        <p>Engaging multimedia content that makes learning fun and effective.</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4>Progress Tracking</h4>
                        <p>Monitor your improvement with detailed analytics and reports.</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <h4>Practice Tests</h4>
                        <p>Test your knowledge with customizable quizzes and exams.</p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>Achievement System</h4>
                        <p>Earn badges and rewards for completing lessons and challenges.</p>
                    </div>
                </div>
            </section>
        </main>

        <!-- Page Info -->
        <div class="page-info">
            <div class="page-number">HOME PAGE</div>
            <div class="page-description">
                <p>This is the Home Page, showing the main subject, pictures, and basic introduction. Users can navigate
                    to Topic, Test, or Result using the menu buttons.</p>
            </div>
        </div>
    </div>

    <script>
        // Highlight current page in navigation
        document.addEventListener('DOMContentLoaded', function () {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-btn');

            navLinks.forEach(link => {
                const linkPage = link.getAttribute('href');
                if (linkPage === currentPage ||
                    (currentPage === '' && linkPage === 'index.php') ||
                    (currentPage === 'index.php' && linkPage === 'index.php')) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // Animate stats
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(stat => {
                const originalText = stat.textContent;
                stat.textContent = '0';

                setTimeout(() => {
                    let current = 0;
                    const target = parseFloat(originalText);
                    const increment = target / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            stat.textContent = originalText;
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(current) + (originalText.includes('.') ? '.0' : '');
                        }
                    }, 30);
                }, 500);
            });

            // Auto-hide messages after 5 seconds
            const messages = document.querySelectorAll('.system-message');
            messages.forEach(message => {
                setTimeout(() => {
                    if (message.parentNode) {
                        message.style.opacity = '0';
                        message.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => {
                            if (message.parentNode) {
                                message.parentNode.removeChild(message);
                            }
                        }, 500);
                    }
                }, 5000);
            });
        });

        // Close message function
        function closeMessage(messageId) {
            const message = document.getElementById(messageId);
            if (message) {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s ease';
                setTimeout(() => {
                    if (message.parentNode) {
                        message.parentNode.removeChild(message);
                    }
                }, 500);
            }
        }

        // Show demo for guest users
        function showDemo() {
            // Auto-fill demo credentials and redirect to login
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = 'login.php';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'demo';
            input.value = 'true';
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        // Scroll to features
        function scrollToFeatures() {
            const features = document.querySelector('.subject-overview');
            if (features) {
                features.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Show profile settings (for logged in users)
        function showProfile() {
            alert('Profile Settings:\n\nIn a full application, this would open a profile settings modal where you can:\n\n1. Update your profile information\n2. Change your password\n3. Set notification preferences\n4. Manage account settings\n5. View learning history');
        }

        // Image gallery interaction
        document.querySelectorAll('.image-card').forEach(card => {
            card.addEventListener('click', function() {
                const overlay = this.querySelector('.image-overlay');
                const title = overlay.querySelector('h4').textContent;
                const description = overlay.querySelector('p').textContent;
                
                alert(`${title}\n\n${description}\n\nThis would open a detailed view in a full application.`);
            });
        });

        // Feature cards interaction
        document.querySelectorAll('.feature').forEach(feature => {
            feature.addEventListener('click', function() {
                const title = this.querySelector('h4').textContent;
                const description = this.querySelector('p').textContent;
                
                alert(`Feature: ${title}\n\n${description}\n\nClick OK to learn more about this feature.`);
            });
        });

        // Update current time every minute
        function updateCurrentTime() {
            const timeElement = document.querySelector('.user-stats .stat-value:last-child');
            if (timeElement) {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                timeElement.textContent = `${hours}:${minutes}`;
            }
        }

        // Update time immediately and then every minute
        updateCurrentTime();
        setInterval(updateCurrentTime, 60000);
    </script>
</body>
</html>