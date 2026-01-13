
-- Create database
CREATE DATABASE IF NOT EXISTS homeworkhub_db;
USE homeworkhub_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    bio TEXT,
    user_type ENUM('student', 'teacher', 'admin') DEFAULT 'student',
    is_active BOOLEAN DEFAULT TRUE,
    remember_token VARCHAR(100) DEFAULT NULL,
    token_expiry DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_user_type (user_type)
);

-- User login history
CREATE TABLE IF NOT EXISTS user_logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    login_time DATETIME NOT NULL,
    logout_time DATETIME DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    user_agent TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_login (user_id, login_time),
    INDEX idx_login_time (login_time)
);

-- Test results table
CREATE TABLE IF NOT EXISTS test_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    test_type VARCHAR(50) NOT NULL,
    topic VARCHAR(100) NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    percentage DECIMAL(5,2) NOT NULL,
    grade VARCHAR(10) NOT NULL,
    time_spent INT DEFAULT 0 COMMENT 'Time spent in minutes',
    test_data JSON DEFAULT NULL COMMENT 'Stores questions and answers in JSON format',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_test (user_id, created_at),
    INDEX idx_test_type (test_type),
    INDEX idx_topic (topic)
);

-- User progress table
CREATE TABLE IF NOT EXISTS user_progress (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    progress_percent INT DEFAULT 0,
    completed_topics INT DEFAULT 0,
    total_topics INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_subject (user_id, subject),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_progress (user_id, subject)
);

-- Insert demo user (password: 123)
INSERT INTO users (full_name, email, password, user_type) VALUES
('Ali Student', 'ali@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student');

-- Insert some test results for demo user
INSERT INTO test_results (user_id, test_type, topic, score, total_questions, percentage, grade, time_spent, created_at) VALUES
(1, 'quiz', 'body-coordination', 4, 5, 80.00, 'A', 8, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(1, 'quiz', 'heredity-variation', 3, 5, 60.00, 'C', 10, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(1, 'dragdrop', 'matter-nature', 5, 5, 100.00, 'A+', 5, DATE_SUB(NOW(), INTERVAL 1 DAY));

-- Insert progress data
INSERT INTO user_progress (user_id, subject, progress_percent, completed_topics, total_topics) VALUES
(1, 'Mathematics', 85, 17, 20),
(1, 'Science', 72, 14, 20),
(1, 'Language Arts', 90, 18, 20),
(1, 'Social Studies', 65, 13, 20);
