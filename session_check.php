<?php
// Session management helper functions

function requireLogin() {
    session_start();
    
    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
        // Store the requested URL to redirect back after login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        
        // Redirect to login page
        header('Location: Login.php');
        exit();
    }
    
    return [
        'user_id' => $_SESSION['user_id'] ?? null,
        'user_email' => $_SESSION['user_email'] ?? 'Guest',
        'user_name' => $_SESSION['user_name'] ?? 'User'
    ];
}

function isLoggedIn() {
    session_start();
    return isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
}

function getUserInfo() {
    session_start();
    
    if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true) {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'email' => $_SESSION['user_email'] ?? 'Guest',
            'name' => $_SESSION['user_name'] ?? 'User'
        ];
    }
    
    return null;
}

function checkUserRole($requiredRole = 'student') {
    session_start();
    
    // Get user role from session (you need to store this during login)
    $userRole = $_SESSION['user_role'] ?? 'student';
    
    // Define role hierarchy
    $roleHierarchy = [
        'admin' => 3,
        'teacher' => 2,
        'student' => 1
    ];
    
    if (isset($roleHierarchy[$userRole]) && $roleHierarchy[$userRole] >= $roleHierarchy[$requiredRole]) {
        return true;
    }
    
    return false;
}
