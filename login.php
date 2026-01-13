<?php
require_once 'config.php';

$error = '';

// Check if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter email and password';
    } else {
        $pdo = getPDO();
        
        // Get user from database
        $stmt = $pdo->prepare("SELECT id, email, password, full_name FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['full_name'] ?? $user['email'];
            $_SESSION['isLoggedIn'] = true;
            
            // Remember me for 30 days
            if ($remember) {
                setcookie('user_email', $user['email'], time() + (30 * 24 * 60 * 60), '/');
            }
            
            header('Location: index.php?login=success');
            exit();
        } else {
            $error = 'Invalid email or password';
        }
    }
}

// Check for remember me cookie
$remembered_email = '';
if (isset($_COOKIE['user_email'])) {
    $remembered_email = $_COOKIE['user_email'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HomeworkHub</title>
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
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            accent-color: #667eea;
        }
        
        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
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
        
        .social-login {
            margin-top: 30px;
            text-align: center;
        }
        
        .social-login p {
            color: #666;
            margin-bottom: 15px;
            position: relative;
        }
        
        .social-login p::before,
        .social-login p::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: #e0e0e0;
        }
        
        .social-login p::before {
            left: 0;
        }
        
        .social-login p::after {
            right: 0;
        }
        
        .social-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        
        .social-btn {
            flex: 1;
            max-width: 150px;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: border-color 0.3s;
        }
        
        .social-btn:hover {
            border-color: #667eea;
        }
        
        .social-btn img {
            width: 20px;
            height: 20px;
        }
        
        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #666;
        }
        
        .register-link a {
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
            <h2 class="form-title">Welcome Back</h2>
            <p class="form-subtitle">Sign in to your account to continue</p>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($remembered_email); ?>" 
                           required placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" 
                           required placeholder="Enter your password">
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember" <?php echo $remembered_email ? 'checked' : ''; ?>>
                    <label for="remember">Remember me for 30 days</label>
                </div>
                
                <button type="submit" class="btn">Sign In</button>
            </form>
            
            <div class="social-login">
                <p>or sign in with</p>
                <div class="social-buttons">
                    <div class="social-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span>Facebook</span>
                    </div>
                    <div class="social-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                            <path fill="#EA4335" d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972a6.033 6.033 0 110-12.064c1.498 0 2.866.549 3.921 1.453l2.814-2.814A9.969 9.969 0 0012.545 2C7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z"/>
                        </svg>
                        <span>Google</span>
                    </div>
                </div>
            </div>
            
            <p class="register-link">
                Don't have an account? <a href="register.php">Sign up</a>
            </p>
        </div>
    </div>
</body>
</html>