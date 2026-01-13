<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeworkHub - Topic Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --science-blue: #3B82F6;
            --science-green: #10B981;
            --science-purple: #8B5CF6;
            --science-red: #EF4444;
            --science-orange: #F59E0B;
            --science-teal: #06B6D4;
            --light: #F8F9FA;
            --dark: #1F2937;
            --gradient-blue: linear-gradient(135deg, var(--science-blue), var(--science-teal));
            --gradient-green: linear-gradient(135deg, var(--science-green), #34D399);
            --gradient-purple: linear-gradient(135deg, var(--science-purple), #A78BFA);
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background-color: #ffffff;
            color: var(--dark);
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
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
            background: var(--gradient-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .logo-text h1 {
            font-size: 28px;
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        .logo-text p {
            font-size: 14px;
            color: #6c757d;
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
            background: var(--gradient-blue);
            color: white;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }

        /* Back Navigation */
        .back-navigation {
            margin-bottom: 20px;
        }

        .back-btn {
            padding: 12px 25px;
            background: #f1f5f9;
            color: var(--dark);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
        }

        .back-btn:hover {
            background: #e2e8f0;
            transform: translateX(-5px);
        }

        /* Topic Header */
        .topic-header {
            background: white;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .topic-banner {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .topic-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.7);
        }

        .topic-banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(6, 182, 212, 0.6));
            display: flex;
            align-items: center;
            padding: 0 40px;
            color: white;
        }

        .topic-icon-large {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin-right: 25px;
            flex-shrink: 0;
        }

        .topic-info h2 {
            font-size: 32px;
            margin-bottom: 10px;
            color: white;
        }

        .topic-meta {
            display: flex;
            gap: 20px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }

        .topic-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .topic-content-header {
            padding: 30px 40px;
        }

        /* Main Content Layout */
        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        /* Video Player Section */
        .video-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .video-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 22px;
            color: var(--dark);
        }

        .video-title i {
            color: var(--science-red);
        }

        .video-player {
            background: #1a1a1a;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
            position: relative;
            height: 400px;
        }

        .video-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #2D3748, #4A5568);
        }

        .video-placeholder i {
            font-size: 80px;
            margin-bottom: 20px;
            color: var(--science-blue);
        }

        .video-placeholder h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .video-placeholder p {
            opacity: 0.8;
            max-width: 500px;
        }

        /* Video Controls */
        .video-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .play-pause-btn {
            width: 60px;
            height: 60px;
            background: var(--gradient-blue);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .play-pause-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .seek-bar-container {
            flex: 1;
        }

        .seek-bar {
            width: 100%;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
        }

        .seek-progress {
            height: 100%;
            background: var(--gradient-blue);
            width: 35%;
            border-radius: 4px;
            position: relative;
        }

        .seek-progress::after {
            content: '';
            position: absolute;
            right: -5px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
            border: 3px solid var(--science-blue);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .time-display {
            display: flex;
            justify-content: space-between;
            color: #6c757d;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Explanation Section */
        .explanation-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .explanation-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 22px;
            color: var(--dark);
        }

        .explanation-header i {
            color: var(--science-green);
        }

        .explanation-content {
            line-height: 1.8;
            color: #4B5563;
        }

        .explanation-content h3 {
            margin: 25px 0 15px;
            color: var(--dark);
            font-size: 20px;
        }

        .explanation-content p {
            margin-bottom: 15px;
        }

        .explanation-content ul {
            margin: 15px 0 15px 20px;
            padding-left: 15px;
        }

        .explanation-content li {
            margin-bottom: 8px;
            position: relative;
        }

        .explanation-content li::before {
            content: '•';
            color: var(--science-blue);
            font-weight: bold;
            position: absolute;
            left: -15px;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* Notes Section */
        .notes-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .notes-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 20px;
            color: var(--dark);
        }

        .notes-header i {
            color: var(--science-orange);
        }

        .notes-content {
            background: #FFF7ED;
            border-radius: 15px;
            padding: 20px;
            border-left: 4px solid var(--science-orange);
        }

        .note-item {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #FDBA74;
        }

        .note-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .note-item h4 {
            color: #9A3412;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .note-item p {
            color: #7C2D12;
            line-height: 1.6;
            font-size: 14px;
        }

        /* Resources Section */
        .resources-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .resources-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            font-size: 20px;
            color: var(--dark);
        }

        .resources-header i {
            color: var(--science-purple);
        }

        .resource-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: #FAF5FF;
            border-radius: 12px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: var(--transition);
        }

        .resource-item:hover {
            background: #F3E8FF;
            transform: translateX(5px);
        }

        .resource-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-purple);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .resource-text h4 {
            font-size: 16px;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .resource-text p {
            font-size: 12px;
            color: #6c757d;
        }

        /* Navigation Buttons */
        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .nav-button {
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .prev-btn {
            background: #f1f5f9;
            color: var(--dark);
        }

        .prev-btn:hover {
            background: #e2e8f0;
            transform: translateX(-5px);
        }

        .next-btn {
            background: var(--gradient-blue);
            color: white;
        }

        .next-btn:hover {
            transform: translateX(5px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .test-btn {
            background: var(--gradient-green);
            color: white;
        }

        .test-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
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
            color: var(--science-blue);
            font-weight: 600;
            background: rgba(59, 130, 246, 0.1);
            padding: 8px 20px;
            border-radius: 50px;
        }

        .page-description {
            max-width: 600px;
            color: #6c757d;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .sidebar {
                grid-row: 1;
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

            .topic-banner {
                height: 200px;
            }

            .topic-banner-overlay {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .topic-icon-large {
                margin-right: 0;
                margin-bottom: 15px;
                width: 60px;
                height: 60px;
                font-size: 28px;
            }

            .topic-info h2 {
                font-size: 24px;
            }

            .topic-meta {
                justify-content: center;
                flex-wrap: wrap;
            }

            .video-player {
                height: 300px;
            }

            .navigation-buttons {
                flex-direction: column;
                gap: 15px;
            }

            .nav-button {
                width: 100%;
                justify-content: center;
            }

            .page-info {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .video-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .play-pause-btn {
                width: 100%;
                border-radius: 12px;
            }

            .topic-content-header {
                padding: 20px;
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
                    <i class="fas fa-atom"></i>
                </div>
                <div class="logo-text">
                    <h1>HomeworkHub</h1>
                    <p>Interactive Science Learning System</p>
                </div>
            </div>

            <nav>
                <a href="index.php" class="nav-btn">
                    <i class="fas fa-home"></i> HOME
                </a>
                <a href="topic.php" class="nav-btn">
                    <i class="fas fa-book-open"></i> TOPICS
                </a>
                <a href="test.php" class="nav-btn">
                    <i class="fas fa-pencil-alt"></i> TEST
                </a>
                <a href="result.php" class="nav-btn">
                    <i class="fas fa-chart-line"></i> RESULT
                </a>
            </nav>
        </header>

        <!-- Back Navigation - CHANGED TO GO TO TOPIC.PHP -->
        <div class="back-navigation">
            <button class="back-btn" id="backToTopicsBtn">
                <i class="fas fa-arrow-left"></i>
                Back to Topics
            </button>
        </div>

        <!-- Topic Header with Banner Image -->
        <div class="topic-header" id="topicHeader">
            <div class="topic-banner">
                <img id="topicBanner"
                    src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                    alt="Science Topic Banner"
                    onerror="this.src='https://images.unsplash.com/photo-1635070041078-e363dbe005cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'">
                <div class="topic-banner-overlay">
                    <div class="topic-icon-large" id="topicIcon">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div class="topic-info">
                        <h2 id="topicTitle">TOPIC 1: Scientific Methodology</h2>
                        <div class="topic-meta">
                            <span><i class="fas fa-graduation-cap"></i> <span id="topicForm">Form 4
                                    Science</span></span>
                            <span><i class="fas fa-book"></i> <span id="topicLessons">6 Lessons</span></span>
                            <span><i class="fas fa-clock"></i> <span id="topicDuration">4 hours</span></span>
                            <span><i class="fas fa-chart-bar"></i> <span id="topicDifficulty">Medium
                                    Difficulty</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="topic-content-header">
                <p id="topicDescription">Explore comprehensive learning materials including video lectures, detailed
                    explanations, and key notes for this science topic.</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Video Section -->
            <div class="video-section">
                <div class="video-title">
                    <i class="fas fa-video"></i>
                    <span id="videoTitle">VIDEO: Introduction to Scientific Methodology</span>
                </div>

                <div class="video-player">
                    <div class="video-placeholder">
                        <i class="fas fa-play-circle"></i>
                        <h3>Science Lecture Video</h3>
                        <p>This video explains the fundamentals of scientific methodology with practical examples and
                            demonstrations.</p>
                        <div
                            style="margin-top: 20px; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                            <i class="fas fa-info-circle"></i> Click play button to start video lecture
                        </div>
                    </div>
                </div>

                <div class="video-controls">
                    <button class="play-pause-btn" id="playPauseBtn">
                        <i class="fas fa-play" id="playIcon"></i>
                    </button>

                    <div class="seek-bar-container">
                        <div class="seek-bar" id="seekBar">
                            <div class="seek-progress" id="seekProgress"></div>
                        </div>
                        <div class="time-display">
                            <span id="currentTime">0:00</span>
                            <span id="totalTime">15:30</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Notes Section -->
                <div class="notes-section">
                    <div class="notes-header">
                        <i class="fas fa-sticky-note"></i>
                        <h3>Key Notes</h3>
                    </div>

                    <div class="notes-content" id="notesContent">
                        <!-- Notes will be loaded dynamically -->
                    </div>
                </div>

                <!-- Resources Section -->
                <div class="resources-section">
                    <div class="resources-header">
                        <i class="fas fa-download"></i>
                        <h3>Learning Resources</h3>
                    </div>

                    <div class="resource-item" onclick="downloadResource('notes')">
                        <div class="resource-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div class="resource-text">
                            <h4>Topic Notes (PDF)</h4>
                            <p>Download detailed notes for offline study</p>
                        </div>
                    </div>

                    <div class="resource-item" onclick="downloadResource('worksheet')">
                        <div class="resource-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="resource-text">
                            <h4>Practice Worksheet</h4>
                            <p>Test your understanding with exercises</p>
                        </div>
                    </div>

                    <div class="resource-item" onclick="downloadResource('experiment')">
                        <div class="resource-icon">
                            <i class="fas fa-vial"></i>
                        </div>
                        <div class="resource-text">
                            <h4>Experiment Guide</h4>
                            <p>Step-by-step experiment instructions</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Explanation Section -->
            <div class="explanation-section">
                <div class="explanation-header">
                    <i class="fas fa-book-open"></i>
                    <h3>EXPLANATION OF TOPIC 1</h3>
                </div>

                <div class="explanation-content" id="explanationContent">
                    <!-- Explanation will be loaded dynamically -->
                </div>
            </div>
        </div>

        <!-- Navigation Buttons - KEEP AS "Back to Topics" (goes back to previous page) -->
        <div class="navigation-buttons">
            <a href="#" class="nav-button prev-btn" id="bottomBackBtn">
                <i class="fas fa-arrow-left"></i>
                Back to Topics
            </a>

            <a href="test.php" class="nav-button test-btn">
                <i class="fas fa-pencil-alt"></i>
                Take Test on This Topic
            </a>

            <button class="nav-button next-btn" id="nextTopicBtn">
                Next Topic
                <i class="fas fa-arrow-right"></i>
            </button>
        </div>

        <!-- Page Info -->
        <div class="page-info">
            <div class="page-number">PAGE NUMBER: 8</div>
            <div class="page-description">
                <p>This page provides focused learning on the selected topic with video lecture and detailed text
                    explanation. Users can watch the video while reading notes for comprehensive learning experience.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Topic data with images
        const topicDetails = {
            4: {
                1: {
                    title: "Scientific Methodology",
                    icon: "fas fa-clipboard-check",
                    image: "https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Learn systematic approaches to scientific investigation, hypothesis testing, and experimental design.",
                    form: "Form 4 Science",
                    lessons: "6 Lessons",
                    duration: "4 hours",
                    difficulty: "Medium Difficulty",
                    videoTitle: "Introduction to Scientific Methodology",
                    notes: [
                        {
                            title: "Scientific Method Steps",
                            content: "Observation → Question → Hypothesis → Experiment → Analysis → Conclusion"
                        },
                        {
                            title: "Variables",
                            content: "Independent variable (changed), Dependent variable (measured), Controlled variable (kept constant)"
                        },
                        {
                            title: "Hypothesis Formulation",
                            content: "Must be testable and falsifiable. Written as 'If...then...' statement"
                        },
                        {
                            title: "Data Collection",
                            content: "Use appropriate instruments, record systematically, repeat measurements for accuracy"
                        }
                    ],
                    explanation: `
                        <h3>Introduction to Scientific Methodology</h3>
                        <p>Scientific methodology refers to the systematic approach scientists use to investigate natural phenomena. It is the foundation of all scientific research and discovery.</p>
                        
                        <h3>The Scientific Method</h3>
                        <p>The scientific method consists of several key steps that guide scientific investigation:</p>
                        <ul>
                            <li><strong>Observation:</strong> Noticing and describing natural phenomena</li>
                            <li><strong>Question:</strong> Formulating a research question based on observations</li>
                            <li><strong>Hypothesis:</strong> Proposing a testable explanation for the phenomenon</li>
                            <li><strong>Experiment:</strong> Designing and conducting tests to validate the hypothesis</li>
                            <li><strong>Analysis:</strong> Interpreting experimental data and results</li>
                            <li><strong>Conclusion:</strong> Drawing conclusions and communicating findings</li>
                        </ul>
                        
                        <h3>Importance of Variables</h3>
                        <p>In scientific experiments, controlling variables is crucial:</p>
                        <ul>
                            <li><strong>Independent Variable:</strong> The factor that is deliberately changed by the investigator</li>
                            <li><strong>Dependent Variable:</strong> The factor that is measured or observed as a result</li>
                            <li><strong>Controlled Variables:</strong> Factors that are kept constant throughout the experiment</li>
                        </ul>
                        
                        <h3>Experimental Design</h3>
                        <p>A well-designed experiment includes:</p>
                        <ul>
                            <li>Clear objective and hypothesis</li>
                            <li>Appropriate materials and methods</li>
                            <li>Control setup for comparison</li>
                            <li>Adequate sample size and repetitions</li>
                            <li>Proper data recording and analysis methods</li>
                        </ul>
                        
                        <h3>Applications in Daily Life</h3>
                        <p>Scientific methodology is not limited to laboratories. We use it daily when:</p>
                        <ul>
                            <li>Troubleshooting electronic devices</li>
                            <li>Testing recipes in cooking</li>
                            <li>Solving technical problems</li>
                            <li>Making informed decisions based on evidence</li>
                        </ul>
                    `
                },
                2: {
                    title: "Body Coordination",
                    icon: "fas fa-brain",
                    image: "https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Study of nervous system, brain functions, hormones, and coordination between body systems.",
                    form: "Form 4 Science",
                    lessons: "8 Lessons",
                    duration: "5 hours",
                    difficulty: "Hard Difficulty",
                    videoTitle: "Understanding Body Coordination Systems",
                    notes: [
                        { title: "Nervous System", content: "Central and peripheral nervous systems work together" },
                        { title: "Neurons", content: "Basic units that transmit nerve impulses" },
                        { title: "Reflex Actions", content: "Automatic responses without brain involvement" },
                        { title: "Endocrine System", content: "Hormones regulate body functions slowly" }
                    ],
                    explanation: `
                        <h3>Body Coordination Systems</h3>
                        <p>The human body maintains coordination through two main systems: the nervous system and the endocrine system.</p>
                        
                        <h3>The Nervous System</h3>
                        <p>Consists of the brain, spinal cord, and nerves. It enables rapid communication and response to stimuli.</p>
                        <ul>
                            <li><strong>Central Nervous System (CNS):</strong> Brain and spinal cord</li>
                            <li><strong>Peripheral Nervous System (PNS):</strong> Nerves connecting CNS to body parts</li>
                            <li><strong>Neurons:</strong> Specialized cells that transmit nerve impulses</li>
                        </ul>
                        
                        <h3>Types of Neurons</h3>
                        <ul>
                            <li><strong>Sensory Neurons:</strong> Carry impulses from receptors to CNS</li>
                            <li><strong>Motor Neurons:</strong> Carry impulses from CNS to effectors</li>
                            <li><strong>Interneurons:</strong> Connect sensory and motor neurons within CNS</li>
                        </ul>
                        
                        <h3>The Endocrine System</h3>
                        <p>Uses hormones secreted by glands to regulate body functions more slowly but with longer-lasting effects.</p>
                    `
                },
                3: {
                    title: "Heredity and Variation",
                    icon: "fas fa-dna",
                    image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Understanding genetics, DNA, inheritance patterns, and genetic variation in organisms.",
                    form: "Form 4 Science",
                    lessons: "7 Lessons",
                    duration: "6 hours",
                    difficulty: "Hard Difficulty",
                    videoTitle: "Genetics and Inheritance Patterns",
                    notes: [
                        { title: "DNA Structure", content: "Double helix containing genetic information" },
                        { title: "Genes and Alleles", content: "Units of inheritance with different forms" },
                        { title: "Mendelian Genetics", content: "Laws of inheritance discovered by Gregor Mendel" },
                        { title: "Genetic Variation", content: "Differences caused by mutation and recombination" }
                    ],
                    explanation: "Detailed explanation of heredity and variation..."
                },
                4: {
                    title: "Matter in Nature",
                    icon: "fas fa-atom",
                    image: "https://images.unsplash.com/photo-1500916434205-0c77489c6cf7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Properties of matter, atomic structure, states of matter, and chemical reactions.",
                    form: "Form 4 Science",
                    lessons: "9 Lessons",
                    duration: "7 hours",
                    difficulty: "Medium Difficulty",
                    videoTitle: "Properties and Structure of Matter",
                    notes: [
                        { title: "Atomic Structure", content: "Protons, neutrons, electrons arrangement" },
                        { title: "States of Matter", content: "Solid, liquid, gas, plasma characteristics" },
                        { title: "Chemical Bonds", content: "Ionic, covalent, metallic bonding" },
                        { title: "Periodic Table", content: "Organization of elements by properties" }
                    ],
                    explanation: "Detailed explanation of matter in nature..."
                },
                5: {
                    title: "Energy and Chemical Changes",
                    icon: "fas fa-bolt",
                    image: "https://images.unsplash.com/photo-1576086213369-97a306d36557?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Energy transformations, chemical energy, heat, light, and conservation of energy.",
                    form: "Form 4 Science",
                    lessons: "6 Lessons",
                    duration: "4 hours",
                    difficulty: "Easy Difficulty",
                    videoTitle: "Energy Transformations in Chemical Reactions",
                    notes: [
                        { title: "Forms of Energy", content: "Kinetic, potential, thermal, chemical, electrical" },
                        { title: "Energy Conservation", content: "Energy cannot be created or destroyed" },
                        { title: "Exothermic Reactions", content: "Release heat to surroundings" },
                        { title: "Endothermic Reactions", content: "Absorb heat from surroundings" }
                    ],
                    explanation: "Detailed explanation of energy and chemical changes..."
                }
            },
            5: {
                1: {
                    title: "Microorganisms & Biotechnology",
                    icon: "fas fa-bacteria",
                    image: "https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Study of microorganisms and their applications in biotechnology and genetic engineering.",
                    form: "Form 5 Science",
                    lessons: "7 Lessons",
                    duration: "5 hours",
                    difficulty: "Medium Difficulty",
                    videoTitle: "Microorganisms in Biotechnology",
                    notes: [
                        { title: "Types of Microbes", content: "Bacteria, viruses, fungi, protozoa" },
                        { title: "Useful Microbes", content: "In food production, medicine, waste treatment" },
                        { title: "Genetic Engineering", content: "Modifying organisms for specific purposes" },
                        { title: "Bioethics", content: "Ethical considerations in biotechnology" }
                    ],
                    explanation: "Detailed explanation of microorganisms and biotechnology..."
                },
                2: {
                    title: "Nutrition & Food Technology",
                    icon: "fas fa-utensils",
                    image: "https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Balanced diet, food processing, preservation methods, and food additives.",
                    form: "Form 5 Science",
                    lessons: "6 Lessons",
                    duration: "4 hours",
                    difficulty: "Easy Difficulty",
                    videoTitle: "Modern Food Technology",
                    notes: [
                        { title: "Balanced Diet", content: "Proper nutrients in correct proportions" },
                        { title: "Food Preservation", content: "Canning, freezing, drying, pasteurization" },
                        { title: "Food Additives", content: "Preservatives, flavor enhancers, coloring agents" },
                        { title: "Food Safety", content: "Preventing contamination and foodborne illnesses" }
                    ],
                    explanation: "Detailed explanation of nutrition and food technology..."
                },
                3: {
                    title: "Synthetic Materials",
                    icon: "fas fa-industry",
                    image: "https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Polymers, plastics, synthetic fibers, and their applications in modern industry.",
                    form: "Form 5 Science",
                    lessons: "5 Lessons",
                    duration: "3 hours",
                    difficulty: "Medium Difficulty",
                    videoTitle: "Synthetic Polymers and Plastics",
                    notes: [
                        { title: "Polymerization", content: "Process of joining monomers to form polymers" },
                        { title: "Types of Plastics", content: "Thermoplastics and thermosetting plastics" },
                        { title: "Synthetic Fibers", content: "Nylon, polyester, acrylic properties" },
                        { title: "Environmental Impact", content: "Biodegradability and recycling challenges" }
                    ],
                    explanation: "Detailed explanation of synthetic materials..."
                },
                4: {
                    title: "Electronics & IT",
                    icon: "fas fa-microchip",
                    image: "https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Electronic components, circuits, semiconductors, and information technology.",
                    form: "Form 5 Science",
                    lessons: "8 Lessons",
                    duration: "6 hours",
                    difficulty: "Hard Difficulty",
                    videoTitle: "Electronic Circuits and Components",
                    notes: [
                        { title: "Circuit Components", content: "Resistors, capacitors, transistors, diodes" },
                        { title: "Logic Gates", content: "AND, OR, NOT, NAND, NOR operations" },
                        { title: "Digital Systems", content: "Binary system and digital electronics" },
                        { title: "IT Applications", content: "Computers, networks, internet, automation" }
                    ],
                    explanation: "Detailed explanation of electronics and IT..."
                },
                5: {
                    title: "Space Exploration",
                    icon: "fas fa-rocket",
                    image: "https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80",
                    description: "Astronomy, space technology, satellites, and the future of space exploration.",
                    form: "Form 5 Science",
                    lessons: "7 Lessons",
                    duration: "5 hours",
                    difficulty: "Medium Difficulty",
                    videoTitle: "Space Technology and Exploration",
                    notes: [
                        { title: "Solar System", content: "Planets, moons, asteroids, comets" },
                        { title: "Space Technology", content: "Rockets, satellites, space stations" },
                        { title: "Astronomical Tools", content: "Telescopes, space probes, observatories" },
                        { title: "Future Exploration", content: "Mars missions, space tourism, colonization" }
                    ],
                    explanation: "Detailed explanation of space exploration..."
                }
            }
        };

        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const form = parseInt(urlParams.get('form')) || 4;
        const topic = parseInt(urlParams.get('topic')) || 1;

        // Video controls
        let isPlaying = false;
        let currentVideoTime = 0;
        const totalVideoTime = 930; // 15:30 in seconds

        // DOM Elements
        const topicBanner = document.getElementById('topicBanner');
        const topicHeader = document.getElementById('topicHeader');
        const topicIcon = document.getElementById('topicIcon');
        const topicTitle = document.getElementById('topicTitle');
        const topicDescription = document.getElementById('topicDescription');
        const topicForm = document.getElementById('topicForm');
        const topicLessons = document.getElementById('topicLessons');
        const topicDuration = document.getElementById('topicDuration');
        const topicDifficulty = document.getElementById('topicDifficulty');
        const videoTitle = document.getElementById('videoTitle');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const playIcon = document.getElementById('playIcon');
        const seekBar = document.getElementById('seekBar');
        const seekProgress = document.getElementById('seekProgress');
        const currentTime = document.getElementById('currentTime');
        const totalTime = document.getElementById('totalTime');
        const notesContent = document.getElementById('notesContent');
        const explanationContent = document.getElementById('explanationContent');
        const nextTopicBtn = document.getElementById('nextTopicBtn');
        const backToTopicsBtn = document.getElementById('backToTopicsBtn');
        const bottomBackBtn = document.getElementById('bottomBackBtn');

        // Format time as MM:SS
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }

        // Update video progress
        function updateVideoProgress(percent) {
            seekProgress.style.width = `${percent}%`;
            currentVideoTime = (percent / 100) * totalVideoTime;
            currentTime.textContent = formatTime(currentVideoTime);
        }

        // Toggle play/pause
        function togglePlayPause() {
            isPlaying = !isPlaying;

            if (isPlaying) {
                playIcon.classList.remove('fa-play');
                playIcon.classList.add('fa-pause');

                // Simulate video playing
                let progress = (currentVideoTime / totalVideoTime) * 100;
                const interval = setInterval(() => {
                    if (isPlaying && progress < 100) {
                        progress += 0.5;
                        updateVideoProgress(progress);
                    } else {
                        clearInterval(interval);
                        if (progress >= 100) {
                            isPlaying = false;
                            playIcon.classList.remove('fa-pause');
                            playIcon.classList.add('fa-play');
                        }
                    }
                }, 500);
            } else {
                playIcon.classList.remove('fa-pause');
                playIcon.classList.add('fa-play');
            }
        }

        // Load topic data
        function loadTopicData(form, topic) {
            const topicData = topicDetails[form]?.[topic] || topicDetails[4][1];

            // Update banner image
            topicBanner.src = topicData.image;

            // Update topic header
            topicTitle.textContent = `TOPIC ${topic}: ${topicData.title}`;
            topicDescription.textContent = topicData.description;
            topicForm.textContent = topicData.form;
            topicLessons.textContent = topicData.lessons;
            topicDuration.textContent = topicData.duration;
            topicDifficulty.textContent = topicData.difficulty;

            // Update icon
            topicIcon.innerHTML = `<i class="${topicData.icon}"></i>`;
            topicIcon.style.background = form === 4 ? 'var(--gradient-blue)' : 'var(--gradient-green)';

            // Update video title
            videoTitle.textContent = `VIDEO: ${topicData.videoTitle}`;

            // Update notes
            notesContent.innerHTML = topicData.notes.map(note => `
                <div class="note-item">
                    <h4><i class="fas fa-star"></i> ${note.title}</h4>
                    <p>${note.content}</p>
                </div>
            `).join('');

            // Update explanation
            explanationContent.innerHTML = topicData.explanation;

            // Update next topic button
            const nextTopic = topic < 5 ? topic + 1 : 1;
            const nextForm = topic < 5 ? form : (form === 4 ? 5 : 4);
            const nextTopicData = topicDetails[nextForm]?.[nextTopic];

            if (nextTopicData) {
                nextTopicBtn.innerHTML = `Topic ${nextTopic}: ${nextTopicData.title} <i class="fas fa-arrow-right"></i>`;
                nextTopicBtn.onclick = () => {
                    window.location.href = `topic-detail.php?form=${nextForm}&topic=${nextTopic}`;
                };
            } else {
                nextTopicBtn.style.display = 'none';
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function () {
            // Highlight current page in navigation
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-btn');
            const currentPageName = currentPage || 'topic-detail.php';

            navLinks.forEach(link => {
                const linkPage = link.getAttribute('href');
                if (linkPage === 'topic.php' && currentPageName === 'topic-detail.php') {
                    link.classList.add('active');
                } else if (linkPage === currentPageName) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // TOP BUTTON: Go to topic.php page
            backToTopicsBtn.addEventListener('click', function () {
                window.location.href = 'topic.php';
            });

            // BOTTOM BUTTON: Go back to previous page (browser history)
            bottomBackBtn.addEventListener('click', function (e) {
                e.preventDefault();
                window.history.back();
            });

            // Load topic data
            loadTopicData(form, topic);

            // Set total time
            totalTime.textContent = formatTime(totalVideoTime);

            // Event listeners for video controls
            playPauseBtn.addEventListener('click', togglePlayPause);

            // Seek bar click
            seekBar.addEventListener('click', function (e) {
                const rect = this.getBoundingClientRect();
                const percent = ((e.clientX - rect.left) / rect.width) * 100;
                updateVideoProgress(Math.min(100, Math.max(0, percent)));
            });
        });

        // Resource download function
        function downloadResource(type) {
            const resourceNames = {
                'notes': 'Topic Notes PDF',
                'worksheet': 'Practice Worksheet',
                'experiment': 'Experiment Guide'
            };

            alert(`Downloading ${resourceNames[type]}...\n\nIn a real application, this would download the resource file.`);
        }
    </script>
</body>

</html>