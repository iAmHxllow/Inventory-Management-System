<?php
// Include the head.php file
include('include/head.php');

// Database configuration
$host = 'localhost';
$dbname = 'daniel_db';
$username = 'root';
$password = '';


// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (!$data) {
            throw new Exception("No data received");
        }

        $email = trim($data['email']);
        $password = $data['password'];

        // Validate data
        if (empty($email) || empty($password)) {
            throw new Exception("All fields are required");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Check if the user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            throw new Exception("Invalid email or password");
        }

        // Successful login
        session_start();
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Login successful"
        ]);
        exit;

    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php setHead('Login'); ?>
</head>
<body>
    <header class="header">
        <div class="logo">
            QuickBuy <img src="assets/img/logo.svg" class="cart-icon">
        </div>
        <a href="register" class="sign-up-btn">Sign Up</a>
    </header>

    <main class="main-content">
        <h1>Welcome Back <img src="assets/img/handshake.svg" alt="img"></h1>
        <p class="subtitle">Let's get you to your work orders</p>

        <!-- Login Form -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Your work email</label>
                <div class="input-container">
                    <img src="assets/img/email.svg" alt="email icon" class="input-icon">
                    <input type="email" id="email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Your Password</label>
                <div class="input-container">
                    <img src="assets/img/lock.svg" alt="lock icon" class="input-icon">
                    <input type="password" id="password" required>
                </div>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </main>
    <!-- js files -->
    <script src="assets/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const submitButton = document.querySelector('.login-btn');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Show loading state
        submitButton.classList.add('loading');
        submitButton.textContent = 'Loading...';

        const response = await fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: emailInput.value,
                password: passwordInput.value
            })
        });

        const result = await response.json();

        // Handle response
        if (result.success) {
            // Redirect to dashboard
            window.location.href = 'dashboard';
        } else {
            // Show error message
            alert(result.message);
        }

        // Reset button state
        submitButton.classList.remove('loading');
        submitButton.textContent = 'Login';
    });
});
    </script>
</body>
</html>