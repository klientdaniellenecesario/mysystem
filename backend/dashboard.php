<?php
session_start();
require_once 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user details from database
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// Get session count
$session_count = 30;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CCS Sit-in System</title>
    <link rel="stylesheet" href="../frontend/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Top Navigation Bar - Fills spaces left and right -->
        <nav class="top-nav">
            <div class="nav-left">
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
                <span class="nav-brand">CCS Sit-in System</span>
            </div>
            <div class="nav-center">
                <a href="dashboard.php" class="active">Home</a>
                <a href="edit_profile.php">Edit Profile</a>
                <a href="history.php">History</a>
                <a href="reservation.php">Reservation</a>
            </div>
            <div class="nav-right">
                <a href="logout.php" class="logout">Log out</a>
            </div>
        </nav>

        <!-- Dashboard Grid - Two Columns -->
        <div class="dashboard-grid">
            <!-- LEFT COLUMN -->
            <div class="left-col">
                <!-- Student Information Card with Header and Picture Box -->
                <div class="card student-card">
                    <div class="card-header">
                        <h2><i class="fas fa-user-graduate"></i> Student Information</h2>
                    </div>
                    <div class="card-content">
                        <div class="student-info-container">
                            <!-- Picture Box -->
                            <div class="student-picture-box">
                                <i class="fas fa-user-circle"></i>
                                <span class="picture-label">Profile</span>
                            </div>
                            
                            <!-- Student Details -->
                            <div class="student-details">
                                <div class="info-row">
                                    <span class="label">Name:</span>
                                    <span class="value"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Course:</span>
                                    <span class="value">BSIT</span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Year:</span>
                                    <span class="value"><?php echo htmlspecialchars($user['course_level']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Email:</span>
                                    <span class="value"><?php echo htmlspecialchars($user['email']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Address:</span>
                                    <span class="value"><?php echo htmlspecialchars($user['address']); ?></span>
                                </div>
                                <div class="info-row">
                                    <span class="label">Session:</span>
                                    <span class="value session-value"><?php echo $session_count; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Announcements Card with Header -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-bullhorn"></i> Announcement</h2>
                    </div>
                    <div class="card-content">
                        <!-- First Announcement -->
                        <div class="announcement-item">
                            <div class="announcement-header">
                                <span class="admin"><i class="fas fa-user-shield"></i> CCS Admin</span>
                                <span class="date"><i class="far fa-calendar-alt"></i> 2026-Feb-11</span>
                            </div>
                            <div class="announcement-text">
                                CCS Admin | 2026-Feb-11
                            </div>
                        </div>

                        <!-- Second Announcement -->
                        <div class="announcement-item">
                            <div class="announcement-header">
                                <span class="admin"><i class="fas fa-user-shield"></i> CCS Admin</span>
                                <span class="date"><i class="far fa-calendar-alt"></i> 2024-May-08</span>
                            </div>
                            <div class="announcement-text">
                                Important Announcement: We are excited to announce the launch of our new website! Explore our latest products and services now!
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="right-col">
                <!-- Rules and Regulation Card with Header -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-gavel"></i> Rules and Regulation</h2>
                    </div>
                    <div class="card-content">
                        <div class="university-header">
                            <h3>University of Cebu</h3>
                            <h4>COLLEGE OF INFORMATION & COMPUTER STUDIES</h4>
                        </div>

                        <div class="rules-title">LABORATORY RULES AND REGULATIONS</div>
                        
                        <div class="rules-meta">
                            <span><i class="fas fa-user-shield"></i> CCS Admin</span>
                            <span><i class="far fa-calendar-alt"></i> 2024-May-08</span>
                        </div>

                        <p class="rules-intro">
                            To avoid embarrassment and maintain camaraderie with your friends and superiors at our laboratories, please observe the following:
                        </p>

                        <ol class="rules-list">
                            <li>Maintain silence, proper decorum, and discipline inside the laboratory. Mobile phones, walkmans and other personal pieces of equipment must be switched off.</li>
                            <li>Games are not allowed inside the lab. This includes computer-related games, card games and other games that may disturb the operation of the lab.</li>
                            <li>Surfing the Internet is allowed only with the permission of the instructor. Downloading and installing of software are strictly prohibited.</li>
                            <li>Food and drinks are not allowed inside the laboratory.</li>
                            <li>Always log your sit-in sessions before using any computer.</li>
                            <li>Report any technical issues to the lab supervisor immediately.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Popup -->
    <div class="popup-overlay" id="successPopup">
        <div class="popup-box">
            <i class="fas fa-check-circle"></i>
            <div class="success-text">Successful Login!</div>
            <div class="welcome-text">Welcome! <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></div>
            <button class="ok-btn" onclick="hidePopup()">OK</button>
        </div>
    </div>

    <script>
        window.onload = function() {
            document.getElementById('successPopup').style.display = 'flex';
        }

        function hidePopup() {
            document.getElementById('successPopup').style.display = 'none';
        }
    </script>
</body>
</html>