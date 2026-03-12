<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CCS Sit-in System - Registration</title>
    <!-- Link to MAIN CSS (header, footer, login styles) -->
    <link rel="stylesheet" href="/frontend/login.css">
    <!-- Link to REGISTRATION CSS (registration page only) -->
    <link rel="stylesheet" href="/frontend/register.css">
</head>
<body class="registration-body">
    <!-- HEADER SECTION -->
    <header>
        <div class="logo-area">
            <h1>College of Computer Studies Sit-in Monitoring System</h1>
        </div>
        <nav class="nav-menu">
            <a href="home.php">Home</a>
            <a href="#">Community</a>
            <a href="#">About</a>
            <a href="login.php">Login</a>
            <a href="register.php" class="active">Register</a>
        </nav>
    </header>

    <!-- REGISTRATION PAGE CONTENT -->
    <div class="registration-page">
    <!-- LEFT SIDE - Registration Form -->
    <div class="form-side">
        <div class="register-form-wrapper">
            <h1>REGISTRATION</h1>
            <h2>Sign up</h2>

            <form action="register_process.php" method="POST" class="register-form">
                <!-- ID Number -->
                <div class="form-group">
                    <label for="id_number">ID Number</label>
                    <input type="text" id="id_number" name="id_number" placeholder="Enter ID Number" required>
                </div>

                <!-- Last Name -->
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                </div>

                <!-- First Name -->
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter First Name" required>
                </div>

                <!-- Middle Name -->
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" placeholder="Enter Middle Name (Optional)">
                </div>

                <!-- Course Level (Dropdown) -->
                <div class="form-group">
                    <label for="course_level">Course Level</label>
                    <select id="course_level" name="course_level" required>
                        <option value="" disabled selected>Select Course Level</option>
                        <option value="1st Year">1st Year</option>
                        <option value="2nd Year">2nd Year</option>
                        <option value="3rd Year">3rd Year</option>
                        <option value="4th Year">4th Year</option>
                    </select>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </div>

                <!-- Repeat Password -->
                <div class="form-group">
                    <label for="confirm_password">Repeat your password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" required>
                </div>

                <!-- BSIT Course (Checkbox) -->
                <div class="form-group checkbox-group">
                    <label>
                        <input type="checkbox" name="bsit_course" value="BSIT">
                        BSIT Course
                    </label>
                </div>

                <!-- Address -->
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3" placeholder="Enter Complete Address" required></textarea>
                </div>

                <!-- Register Button -->
                <button type="submit" class="register-btn">Register</button>

                <!-- Sign In Link -->
                <div class="signup-link">
                    Already have an account? <a href="login.php">Sign in</a>
                </div>
            </form>
        </div>
    </div>

    <!-- RIGHT SIDE - Logo (No Container) -->
    <div class="logo-side">
        <img src="/images/logo2.png" alt="College Logo" class="registration-logo">
    </div>
    </div>
</body>
</html>