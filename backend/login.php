<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCS Sit-in Monitoring System</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="/frontend/login.css">
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- HEADER SECTION -->
    <header>
        <div class="logo-area">
            <h1>College of Computer Studies Sit-in Monitoring System</h1>
        </div>
        <nav class="nav-menu">
            <a href="dashboard.php">Home</a>  <!-- Changed to dashboard.php -->
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
                    <?php
                    // Get error type and preserve ID number
                    $error_type = isset($_GET['error']) ? $_GET['error'] : '';
                    $id_error_class = ($error_type == 'notfound') ? 'field-error-indicator' : '';
                    $pass_error_class = ($error_type == 'wrongpass') ? 'field-error-indicator' : '';
                    
                    // Preserve entered ID number if coming from form
                    $id_value = isset($_POST['id_number']) ? htmlspecialchars($_POST['id_number']) : '';
                    ?>
                    
                    <!-- Error Container - Shows at the top of form -->
                    <div class="error-container">
                        <?php
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                            $error_message = '';
                            $error_class = '';
                            
                            if ($error == 'notfound') {
                                $error_message = 'ID Number not found. Please check and try again.';
                                $error_class = 'error-id';
                            } elseif ($error == 'wrongpass') {
                                $error_message = 'Incorrect password. Please try again.';
                                $error_class = 'error-password';
                            } elseif ($error == 'invalid') {
                                $error_message = 'Invalid ID Number or Password.';
                                $error_class = 'error-generic';
                            }
                            
                            echo '<div class="error-message ' . $error_class . '">';
                            echo '<i class="fas fa-exclamation-circle"></i>';
                            echo '<span>' . $error_message . '</span>';
                            echo '</div>';
                        }
                        
                        if (isset($_GET['registered'])) {
                            echo '<div class="success-message">';
                            echo '<i class="fas fa-check-circle"></i>';
                            echo '<span>Registered successfully! Please log in.</span>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <!-- ID Number Field with error indicator -->
                    <div class="form-group <?php echo $id_error_class; ?>">
                        <label>ID NUMBER</label>
                        <input type="text" 
                               name="id_number" 
                               placeholder="Enter a valid id number" 
                               value="<?php echo $id_value; ?>"
                               required>
                    </div>

                    <!-- Password Field with error indicator -->
                    <div class="form-group <?php echo $pass_error_class; ?>">
                        <label>PASSWORD</label>
                        <input type="password" 
                               name="password" 
                               placeholder="Enter password" 
                               required>
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