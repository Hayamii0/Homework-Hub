<?php
require_once 'config.php';
checkLogin();

$user = getCurrentUser();

// Get test results from POST data
$testType = $_POST['test_type'] ?? 'quiz';
$topic = $_POST['topic'] ?? 'Unknown';
$score = intval($_POST['score'] ?? 0);
$totalQuestions = intval($_POST['total'] ?? 5);
$timeSpent = intval($_POST['time_spent'] ?? 5);

// Calculate percentage
$percentage = $totalQuestions > 0 ? round(($score / $totalQuestions) * 100) : 0;

// Determine grade
if ($percentage >= 90) {
    $grade = 'A+';
} elseif ($percentage >= 80) {
    $grade = 'A';
} elseif ($percentage >= 70) {
    $grade = 'B';
} elseif ($percentage >= 60) {
    $grade = 'C';
} elseif ($percentage >= 50) {
    $grade = 'D';
} else {
    $grade = 'F';
}

// Save to database
$pdo = getPDO();
$stmt = $pdo->prepare("
    INSERT INTO test_results (user_id, test_type, topic, score, total_questions, percentage, grade, time_spent) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([$user['id'], $testType, $topic, $score, $totalQuestions, $percentage, $grade, $timeSpent]);

// Redirect to results page
header('Location: result.php?success=1');
exit();
?>