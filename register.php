<?php
require_once 'conn.php';

// Registration handling logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data) {
            throw new Exception("No data received");
        }

        $username = trim($data['username']);
        $email = trim($data['email']);
        $password = $data['password'];

        // Validate data
        if (empty($username) || empty($email) || empty($password)) {
            throw new Exception("All fields are required");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        if (strlen($password) < 6) {
            throw new Exception("Password must be at least 6 characters long");
        }

        // Check username and email separately
        $stmt = $pdo->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        $existingUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($existingUser) {
            foreach ($existingUser as $user) {
                if ($user['username'] === $username) {
                    throw new Exception("Username '$username' is already taken. Please choose a different username.");
                }
                if ($user['email'] === $email) {
                    throw new Exception("Email address is already registered. Please use a different email or try logging in.");
                }
            }
        }

        // Hash password and insert user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);
            
            echo json_encode([
                "success" => true,
                "message" => "Registration successful"
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $stmt = $pdo->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
                $stmt->execute([$username, $email]);
                $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($existingUser['username'] === $username) {
                    throw new Exception("Username is no longer available. Please choose a different username.");
                } else if ($existingUser['email'] === $email) {
                    throw new Exception("Email address was just registered. Please use a different email.");
                }
            }
            throw new Exception("Registration failed. Please try again.");
        }

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage(),
            "field" => determineErrorField($e->getMessage())
        ]);
    }
    exit;
}

function determineErrorField($errorMessage) {
    if (stripos($errorMessage, 'username') !== false) return 'username';
    if (stripos($errorMessage, 'email') !== false) return 'email';
    if (stripos($errorMessage, 'password') !== false) return 'password';
    return null;
}

// If not a POST request, show the registration form
include('include/head.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
  <?php setHead('Register'); ?>
</head>
<body>
    <!-- header -->
    <header class="header">
        <!-- logo -->
        <div class="logo">
            QuickBuy <img src="assets/img/logo.svg" class="cart-icon">
        </div>
        <a href="login" class="sign-up-btn">Login</a>
    </header>
    <!-- end header -->

    <main class="main-content">
        <h1>Create your  account <img src="assets/img/regIcon.png" alt="img"></h1>
        <p class="subtitle">Lets get you to your work orders</p>
        <!-- form -->
<form action="">
<!-- username -->
    <div class="form-group">
    <label for="user">Your Username</label>
    <div class="input-container">
        <img src="assets/img/user.svg" alt="user icon" class="input-icon">
        <input type="user" id="user" required">
             </div>
              </div>
              <!-- email -->
      <div class="form-group">
    <label for="email">Your work email</label>
    <div class="input-container">
        <img src="assets/img/email.svg" alt="email icon" class="input-icon">
        <input type="email" id="email" required">
             </div>
              </div>
              <!-- password -->
 <div class="form-group">
    <label for="password">Your Password</label>
    <div class="input-container">
        <img src="assets/img/lock.svg" alt="lock icon" class="input-icon">
        <input type="password" id="password" required">
             </div>
              </div>
              <!-- submit -->

            <button type="submit" class="login-btn">Signup</button>
        </form>
    </main>
<!-- js files -->
 <script src="assets/script.js"></script>
</body>
</html>