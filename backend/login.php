<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCS Sit-in Monitoring System</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="/frontend/login.css">
</head>
<body>
    <!-- HEADER SECTION -->
    <header>
        <div class="logo-area">
            <h1>College of Computer Studies Sit-in Monitoring System</h1>
        </div>
        <nav class="nav-menu">
            <a href="home.php">Home</a>  <!-- Changed from login.php to home.php -->
            <a href="#">Community</a>
            <a href="#">About</a>
            <a href="login.php" class="active">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </header>

    <!-- MAIN CONTENT - Simple two-column layout -->
    <div class="main-content">
        <!-- LEFT SIDE - Logo -->
        <div class="right-side">
            <img src="/images/UC.png" alt="College Logo" class="main-logo">
        </div>

        <!-- RIGHT SIDE - Login Form -->
        <div class="left-side">
            <div class="login-form">
                <form action="authenticate.php" method="POST">
                    <div class="form-group">
                        <label>ID NUMBER</label>
                        <input type="text" name="id_number" placeholder="Enter a valid id number" required>
                    </div>

                    <div class="form-group">
                        <label>PASSWORD</label>
                        <input type="password" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-btn">Login</button>

                    <div class="register-link">
                        Don't have an account? <a href="register.php">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 College of Computer Studies</p>
    </footer>
</body>
</html> 