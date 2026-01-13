<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    
    // Validation
    if (empty($email) || empty($password) || empty($full_name)) {
        $error = 'Please fill in all fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        $pdo = getPDO();
        
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $error = 'Email already registered';
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (email, password, full_name) VALUES (?, ?, ?)");
            $result = $stmt->execute([$email, $hashed_password, $full_name]);
            
            if ($result) {
                $success = 'Registration successful! You can now login.';
                // Clear form
                $email = '';
                $full_name = '';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - HomeworkHub</title>
    <style>
      * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .hero-section {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .form-section {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .tagline {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .features {
            list-style: none;
            margin-top: 40px;
        }
        
        .features li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .features li::before {
            content: "✓";
            background: rgba(255,255,255,0.2);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }
        
        .form-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 10px;
        }
        
        .form-subtitle {
            color: #666;
            margin-bottom: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }
        
        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .hero-section {
                padding: 40px 20px;
            }
            
            .form-section {
                padding: 40px 20px;
            }
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="hero-section">
            <h1>HomeworkHub</h1>
            <p class="tagline">Transform your learning experience with interactive assignments, detailed progress tracking, and personalized study plans.</p>
            
            <ul class="features">
                <li>Interactive Learning Modules</li>
                <li>Real-time Progress Tracking</li>
                <li>Personalized Study Plans</li>
                <li>Expert-curated Content</li>
            </ul>
        </div>
        
        <div class="form-section">
            <h2 class="form-title">Create Account</h2>
            <p class="form-subtitle">Join thousands of students improving their grades</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" 
                           value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>" 
                           required placeholder="Enter your full name">
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" 
                           required placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" 
                           required placeholder="At least 6 characters">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                           required placeholder="Repeat your password">
                </div>
                
                <button type="submit" class="btn">Create Account</button>
            </form>
            
            <p class="login-link">
                Already have an account? <a href="login.php">Sign in</a>
            </p>
        </div>
    </div>
</body>
</html>