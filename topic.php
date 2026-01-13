<?php
require_once 'config.php';

// Check if user is logged in (optional for topics)
$user = getCurrentUser();
$isLoggedIn = ($user !== null);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeworkHub - Science Topics</title>
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
            background-color: #f0f9ff;
            color: var(--dark);
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.1) 0%, transparent 20%),
                radial-gradient(circle at 90% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 20%);
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
            background: #f8fafc;
            padding: 8px;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
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

        .nav-btn.active {
            background: var(--gradient-blue);
            color: white;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
        }

        .nav-btn:hover {
            background: rgba(59, 130, 246, 0.1);
            color: var(--science-blue);
            transform: translateY(-3px);
        }

        /* Page Header */
        .page-header {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            text-align: center;
            position: relative;
        }

        .subject-title {
            font-size: 48px;
            margin-bottom: 15px;
            background: var(--gradient-blue);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .subject-subtitle {
            font-size: 20px;
            color: #6c757d;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        /* Form Dropdown */
        .form-dropdown-container {
            position: relative;
            display: inline-block;
            margin-bottom: 40px;
        }

        .form-dropdown-btn {
            background: var(--gradient-blue);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 200px;
            justify-content: space-between;
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
            transition: var(--transition);
        }

        .form-dropdown-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .form-dropdown-content {
            display: none;
            position: absolute;
            background: white;
            min-width: 250px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            z-index: 100;
            top: 100%;
            left: 0;
            margin-top: 10px;
            overflow: hidden;
        }

        .form-dropdown-content.show {
            display: block;
            animation: dropdownFade 0.3s ease;
        }

        @keyframes dropdownFade {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-option {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: var(--transition);
            border-bottom: 1px solid #f1f5f9;
        }

        .form-option:last-child {
            border-bottom: none;
        }

        .form-option:hover {
            background: #f8fafc;
        }

        .form-option.active {
            background: #e0f2fe;
        }

        .form-option-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .form-4-icon {
            background: var(--gradient-blue);
        }

        .form-5-icon {
            background: var(--gradient-green);
        }

        .form-option-text h4 {
            font-size: 16px;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .form-option-text p {
            font-size: 12px;
            color: #6c757d;
        }

        /* Topics Grid */
        .topics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .topic-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            border: 3px solid transparent;
        }

        .topic-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border-color: var(--science-blue);
        }

        .topic-image {
            width: 100%;
            height: 180px;
            overflow: hidden;
        }

        .topic-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
            display: block;
        }

        .topic-card:hover .topic-image img {
            transform: scale(1.05);
        }

        .topic-number {
            position: absolute;
            top: 15px;
            left: 20px;
            background: rgba(255, 255, 255, 0.9);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            z-index: 2;
        }

        .topic-header {
            background: linear-gradient(135deg, var(--science-blue), var(--science-teal));
            color: rgb(118, 118, 118);
            padding: 15px 20px;
            text-align: center;
            position: relative;
            margin: 0;
        }

        .topic-icon {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .topic-card h3 {
            font-size: 20px;
            margin: 0 0 3px 0;
            color: rgb(0, 0, 0);
            line-height: 1.2;
        }

        .topic-form {
            font-size: 13px;
            opacity: 0.9;
            color: rgb(0, 0, 0);
            margin: 0;
        }

        .topic-content {
            padding: 20px;
        }

        .topic-description {
            color: #6c757d;
            line-height: 1.5;
            margin-bottom: 15px;
            font-size: 13px;
        }

        .topic-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            color: #6c757d;
            font-size: 12px;
        }

        .meta-item i {
            color: var(--science-blue);
            font-size: 16px;
        }

        .topic-actions {
            display: flex;
            gap: 10px;
        }

        .topic-btn {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            flex: 1;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--gradient-blue);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: var(--science-blue);
            border: 2px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-3px);
        }

        /* Preview Modal - UPDATED */
        .preview-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .preview-modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 450px; /* Smaller width for better focus */
            padding: 30px;
            position: relative;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-preview-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: var(--dark);
            transition: var(--transition);
        }

        .close-preview-modal:hover {
            color: var(--science-blue);
        }

        /* Preview Title - UPDATED to show description as title */
        .preview-title {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid #22578c;
        }

        .preview-title-text {
            font-size: 18px;
            line-height: 1.6;
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .preview-form-badge {
            display: inline-block;
            background: var(--gradient-blue);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }

        /* Preview Stats - UPDATED layout */
        .preview-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }

        .preview-stat {
            background: #f8fafc;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .preview-stat i {
            font-size: 20px;
            color: var(--science-blue);
            margin-bottom: 8px;
        }

        .preview-stat-value {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .preview-stat-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Preview Buttons - UPDATED to match your image */
        .preview-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .preview-buttons .btn-primary,
        .preview-buttons .btn-secondary {
            padding: 12px 20px;
            font-size: 14px;
            border-radius: 8px;
        }

        /* Selected Form Display */
        .selected-form-display {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .selected-form-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .selected-form-text h3 {
            font-size: 24px;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .selected-form-text p {
            color: #6c757d;
            font-size: 14px;
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
            .topics-grid {
                grid-template-columns: repeat(2, 1fr);
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

            .subject-title {
                font-size: 36px;
            }

            .subject-subtitle {
                font-size: 18px;
            }

            .topics-grid {
                grid-template-columns: 1fr;
            }

            .topic-image {
                height: 200px;
            }

            .topic-actions {
                flex-direction: column;
            }

            .selected-form-display {
                flex-direction: column;
                text-align: center;
            }

            .page-info {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .preview-buttons {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            .form-dropdown-btn {
                width: 100%;
            }

            .form-dropdown-content {
                width: 100%;
            }

            .topic-image {
                height: 160px;
            }

            .preview-stats {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>
<body>
    <!-- Update navigation to use PHP files -->
    <nav>
        <a href="index.php" class="nav-btn home-btn">
            <i class="fas fa-home"></i> HOME
        </a>
        <a href="topic.php" class="nav-btn topic-btn active">
            <i class="fas fa-book-open"></i> TOPIC
        </a>
        <a href="test.php" class="nav-btn test-btn">
            <i class="fas fa-clipboard-check"></i> TEST
        </a>
        <a href="result.php" class="nav-btn result-btn">
            <i class="fas fa-chart-line"></i> RESULT
        </a>
    </nav>
    
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
                <a href="index.html" class="nav-btn home-btn">
                    <i class="fas fa-home"></i> HOME
                </a>
                <a href="topic.html" class="nav-btn topic-btn active">
                    <i class="fas fa-book-open"></i> TOPIC
                </a>
                <a href="test.html" class="nav-btn test-btn">
                    <i class="fas fa-clipboard-check"></i> TEST
                </a>
                <a href="result.html" class="nav-btn result-btn">
                    <i class="fas fa-chart-line"></i> RESULT
                </a>
            </nav>
        </header>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="subject-title">SCIENCE TOPICS</h1>
            <p class="subject-subtitle">Select your form level and explore interactive science topics with video
                lectures and detailed notes.</p>

            <!-- Form Dropdown -->
            <div class="form-dropdown-container">
                <button class="form-dropdown-btn" id="formDropdownBtn">
                    <span>
                        <i class="fas fa-graduation-cap"></i>
                        <span id="selectedFormText">Select Form Level</span>
                    </span>
                    <i class="fas fa-chevron-down" id="dropdownArrow"></i>
                </button>

                <div class="form-dropdown-content" id="formDropdown">
                    <div class="form-option active" data-form="4">
                        <div class="form-option-icon form-4-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="form-option-text">
                            <h4>Form 4 Science</h4>
                            <p>Foundation level science topics</p>
                        </div>
                    </div>
                    <div class="form-option" data-form="5">
                        <div class="form-option-icon form-5-icon">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <div class="form-option-text">
                            <h4>Form 5 Science</h4>
                            <p>Advanced level science topics</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selected Form Display -->
        <div class="selected-form-display" id="selectedFormDisplay" style="display: none;">
            <div class="selected-form-icon" id="selectedFormIcon">
                <!-- Icon will be set by JavaScript -->
            </div>
            <div class="selected-form-text">
                <h3 id="selectedFormTitle">Form 4 Science</h3>
                <p id="selectedFormDesc">Currently viewing Form 4 science topics. Select a topic below to start
                    learning.</p>
            </div>
        </div>

        <!-- Topics Grid -->
        <div class="topics-grid" id="topicsContainer">
            <!-- Topics will be loaded dynamically by JavaScript -->
        </div>

        <!-- Page Info -->
        <div class="page-info">
            <div class="page-number">PAGE NUMBER: 6</div>
            <div class="page-description">
                <p>This page displays the science topic list for selected form (Form 4 or Form 5). Click the dropdown to
                    select form level, then choose topics 1-5 to access detailed learning content with video lectures.
                </p>
            </div>
        </div>
    </div>

    <!-- Preview Modal - UPDATED to match your image -->
    <div class="preview-modal" id="previewModal">
        <div class="preview-modal-content">
            <span class="close-preview-modal" id="closePreviewModal">&times;</span>
            
            <!-- Title section showing the description as title -->
            <div class="preview-title">
                <div class="preview-title-text" id="previewTitle">
                    <!-- The topic description will go here -->
                </div>
                <span class="preview-form-badge" id="previewForm">Form 5</span>
            </div>
            
            <!-- Stats section -->
            <div class="preview-stats">
                <div class="preview-stat">
                    <i class="fas fa-book"></i>
                    <div class="preview-stat-value" id="previewLessons">7</div>
                    <div class="preview-stat-label">Lessons</div>
                </div>
                <div class="preview-stat">
                    <i class="fas fa-vial"></i>
                    <div class="preview-stat-value" id="previewExperiments">4</div>
                    <div class="preview-stat-label">Experiments</div>
                </div>
                <div class="preview-stat">
                    <i class="fas fa-clock"></i>
                    <div class="preview-stat-value" id="previewDuration">5 hours</div>
                    <div class="preview-stat-label">Duration</div>
                </div>
                <div class="preview-stat">
                    <i class="fas fa-chart-bar"></i>
                    <div class="preview-stat-value" id="previewDifficulty">Medium</div>
                    <div class="preview-stat-label">Difficulty</div>
                </div>
            </div>
            
            <!-- Buttons section - matching your image -->
            <div class="preview-buttons">
                <a href="#" class="topic-btn btn-primary" id="startLearningFromPreview" style="flex: 2;">
                    <i class="fas fa-play"></i> Start Learning
                </a>
                <button class="topic-btn btn-secondary" id="closePreviewBtn" style="flex: 1;">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        // Topic data for Form 4 and Form 5 with images
        const topicData = {
            4: [
                {
                    id: 1,
                    title: "Scientific Methodology",
                    icon: "fas fa-clipboard-check",
                    image: "https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Introduction to scientific investigation methods, variables, hypothesis formulation, and experimental design.",
                    lessons: 6,
                    experiments: 3,
                    duration: "4 hours",
                    difficulty: "Medium",
                    color: "var(--science-blue)"
                },
                {
                    id: 2,
                    title: "Body Coordination",
                    icon: "fas fa-brain",
                    image: "https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Study of nervous system, hormones, brain functions, and coordination between body systems.",
                    lessons: 8,
                    experiments: 2,
                    duration: "5 hours",
                    difficulty: "Hard",
                    color: "var(--science-green)"
                },
                {
                    id: 3,
                    title: "Heredity and Variation",
                    icon: "fas fa-dna",
                    image: "https://images.unsplash.com/photo-1559757175-0eb30cd8c063?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Understanding genetics, DNA, chromosomes, inheritance patterns, and genetic variation.",
                    lessons: 7,
                    experiments: 4,
                    duration: "6 hours",
                    difficulty: "Hard",
                    color: "var(--science-purple)"
                },
                {
                    id: 4,
                    title: "Matter in Nature",
                    icon: "fas fa-atom",
                    image: "https://images.unsplash.com/photo-1500916434205-0c77489c6cf7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Properties of matter, states of matter, atomic structure, and chemical reactions.",
                    lessons: 9,
                    experiments: 5,
                    duration: "7 hours",
                    difficulty: "Medium",
                    color: "var(--science-red)"
                },
                {
                    id: 5,
                    title: "Energy and Chemical Changes",
                    icon: "fas fa-bolt",
                    image: "https://images.unsplash.com/photo-1576086213369-97a306d36557?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Energy transformations, heat, light, chemical energy, and conservation of energy.",
                    lessons: 6,
                    experiments: 3,
                    duration: "4 hours",
                    difficulty: "Easy",
                    color: "var(--science-orange)"
                }
            ],
            5: [
                {
                    id: 1,
                    title: "Microorganisms & Biotechnology",
                    icon: "fas fa-bacteria",
                    image: "https://images.unsplash.com/photo-1582719508461-905c673771fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Study of microorganisms, their applications in biotechnology, and genetic engineering.",
                    lessons: 7,
                    experiments: 4,
                    duration: "5 hours",
                    difficulty: "Medium",
                    color: "var(--science-blue)"
                },
                {
                    id: 2,
                    title: "Nutrition & Food Technology",
                    icon: "fas fa-utensils",
                    image: "https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Balanced diet, food processing, preservation methods, and food additives.",
                    lessons: 6,
                    experiments: 3,
                    duration: "4 hours",
                    difficulty: "Easy",
                    color: "var(--science-green)"
                },
                {
                    id: 3,
                    title: "Synthetic Materials",
                    icon: "fas fa-industry",
                    image: "https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Polymers, plastics, synthetic fibers, and their applications in modern industry.",
                    lessons: 5,
                    experiments: 2,
                    duration: "3 hours",
                    difficulty: "Medium",
                    color: "var(--science-purple)"
                },
                {
                    id: 4,
                    title: "Electronics & IT",
                    icon: "fas fa-microchip",
                    image: "https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Electronic components, circuits, semiconductors, and information technology.",
                    lessons: 8,
                    experiments: 4,
                    duration: "6 hours",
                    difficulty: "Hard",
                    color: "var(--science-red)"
                },
                {
                    id: 5,
                    title: "Space Exploration",
                    icon: "fas fa-rocket",
                    image: "https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                    description: "Astronomy, space technology, satellites, and future of space exploration.",
                    lessons: 7,
                    experiments: 3,
                    duration: "5 hours",
                    difficulty: "Medium",
                    color: "var(--science-orange)"
                }
            ]
        };

        // DOM Elements
        const formDropdownBtn = document.getElementById('formDropdownBtn');
        const formDropdown = document.getElementById('formDropdown');
        const dropdownArrow = document.getElementById('dropdownArrow');
        const selectedFormText = document.getElementById('selectedFormText');
        const selectedFormDisplay = document.getElementById('selectedFormDisplay');
        const selectedFormIcon = document.getElementById('selectedFormIcon');
        const selectedFormTitle = document.getElementById('selectedFormTitle');
        const selectedFormDesc = document.getElementById('selectedFormDesc');
        const topicsContainer = document.getElementById('topicsContainer');
        
        // Preview Modal Elements
        const previewModal = document.getElementById('previewModal');
        const closePreviewModal = document.getElementById('closePreviewModal');
        const closePreviewBtn = document.getElementById('closePreviewBtn');
        const previewTitle = document.getElementById('previewTitle');
        const previewForm = document.getElementById('previewForm');
        const previewLessons = document.getElementById('previewLessons');
        const previewExperiments = document.getElementById('previewExperiments');
        const previewDuration = document.getElementById('previewDuration');
        const previewDifficulty = document.getElementById('previewDifficulty');
        const startLearningFromPreview = document.getElementById('startLearningFromPreview');

        let currentForm = 4; // Default form
        let currentPreviewTopicId = null;
        let currentPreviewForm = null;

        // Toggle dropdown
        formDropdownBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            formDropdown.classList.toggle('show');
            dropdownArrow.classList.toggle('fa-chevron-down');
            dropdownArrow.classList.toggle('fa-chevron-up');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function () {
            formDropdown.classList.remove('show');
            dropdownArrow.classList.add('fa-chevron-down');
            dropdownArrow.classList.remove('fa-chevron-up');
        });

        // Prevent dropdown from closing when clicking inside it
        formDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Function to select form
        function selectForm(form) {
            currentForm = form;

            // Update dropdown button text
            selectedFormText.textContent = `Form ${form} Science`;

            // Update active option in dropdown
            document.querySelectorAll('.form-option').forEach(option => {
                option.classList.remove('active');
                if (parseInt(option.getAttribute('data-form')) === form) {
                    option.classList.add('active');
                }
            });

            // Update selected form display
            selectedFormDisplay.style.display = 'flex';
            selectedFormTitle.textContent = `Form ${form} Science`;
            selectedFormDesc.textContent = form === 4
                ? "Currently viewing Form 4 science topics. Select a topic below to start learning."
                : "Currently viewing Form 5 science topics. Select a topic below to start learning.";

            // Update icon
            selectedFormIcon.innerHTML = form === 4
                ? '<i class="fas fa-flask"></i>'
                : '<i class="fas fa-microscope"></i>';
            selectedFormIcon.style.background = form === 4
                ? 'var(--gradient-blue)'
                : 'var(--gradient-green)';

            // Load topics for selected form
            loadTopics(form);

            // Close dropdown
            formDropdown.classList.remove('show');
            dropdownArrow.classList.add('fa-chevron-down');
            dropdownArrow.classList.remove('fa-chevron-up');
        }

        // Function to load topics
        function loadTopics(form) {
            const topics = topicData[form];
            const defaultImage = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80";

            topicsContainer.innerHTML = topics.map(topic => `
                <div class="topic-card">
                    <!-- Topic Image -->
                    <div class="topic-image">
                        <img src="${topic.image}" 
                             alt="${topic.title}" 
                             onerror="this.src='${defaultImage}'">
                        <div class="topic-number">${topic.id}</div>
                    </div>
                    
                    <!-- Topic Header -->
                    <div class="topic-header" style="background: linear-gradient(135deg, ${topic.color}, ${topic.color}99);">
                        <div class="topic-icon">
                            <i class="${topic.icon}"></i>
                        </div>
                        <h3>${topic.title}</h3>
                        <p class="topic-form">Form ${form} Science</p>
                    </div>
                    
                    <!-- Topic Content -->
                    <div class="topic-content">
                        <p class="topic-description">${topic.description}</p>
                        
                        <div class="topic-meta">
                            <div class="meta-item">
                                <i class="fas fa-book"></i>
                                <span>${topic.lessons} Lessons</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-vial"></i>
                                <span>${topic.experiments} Experiments</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>${topic.duration}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-chart-bar"></i>
                                <span>${topic.difficulty}</span>
                            </div>
                        </div>
                        
                        <div class="topic-actions">
                            <a href="topic-detail.html?form=${form}&topic=${topic.id}" class="topic-btn btn-primary">
                                <i class="fas fa-play"></i> Start Learning
                            </a>
                            <button class="topic-btn btn-secondary preview-btn" data-form="${form}" data-topic-id="${topic.id}">
                                <i class="fas fa-info-circle"></i> Preview
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
            
            // Add event listeners to preview buttons
            document.querySelectorAll('.preview-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = parseInt(this.getAttribute('data-form'));
                    const topicId = parseInt(this.getAttribute('data-topic-id'));
                    showTopicPreview(form, topicId);
                });
            });
        }

        // Function to show topic preview
        function showTopicPreview(form, topicId) {
            const topic = topicData[form][topicId - 1];
            currentPreviewForm = form;
            currentPreviewTopicId = topicId;
            
            // Update modal content - USING DESCRIPTION AS TITLE
            previewTitle.textContent = topic.description; // This is the key change
            previewForm.textContent = `Form ${form}`;
            previewLessons.textContent = topic.lessons;
            previewExperiments.textContent = topic.experiments;
            previewDuration.textContent = topic.duration;
            previewDifficulty.textContent = topic.difficulty;
            
            // Update the Start Learning link
            startLearningFromPreview.href = `topic-detail.html?form=${form}&topic=${topic.id}`;
            
            // Show the modal
            previewModal.style.display = 'flex';
        }

        // Function to view topic preview (old alert version - kept for reference)
        function viewTopicPreview(form, topicId) {
            const topic = topicData[form][topicId - 1];
            showTopicPreview(form, topicId);
        }

        // Close preview modal when X is clicked
        closePreviewModal.addEventListener('click', function () {
            previewModal.style.display = 'none';
        });

        // Close preview modal when Close button is clicked
        closePreviewBtn.addEventListener('click', function () {
            previewModal.style.display = 'none';
        });

        // Close preview modal when clicking outside
        window.addEventListener('click', function (event) {
            if (event.target === previewModal) {
                previewModal.style.display = 'none';
            }
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function () {
            // Get current page
            const currentPage = window.location.pathname.split('/').pop();
            
            // Remove active class from all buttons first
            document.querySelectorAll('.nav-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Highlight current page
            if (currentPage === 'topic.html') {
                document.querySelector('.topic-btn').classList.add('active');
            }

            // Add event listeners to form options
            document.querySelectorAll('.form-option').forEach(option => {
                option.addEventListener('click', function() {
                    const form = parseInt(this.getAttribute('data-form'));
                    selectForm(form);
                });
            });

            // Load initial topics for Form 4
            selectForm(4);
        });
    </script>

</body>
</html>