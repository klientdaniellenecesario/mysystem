<?php
session_start();
require_once 'db.php';

// Check if user is logged in AND is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get statistics
$totalStudents = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'student' OR role IS NULL")->fetchColumn();
$currentSitins = $pdo->query("SELECT COUNT(*) FROM sessions WHERE status = 'active'")->fetchColumn() ?: 0;
$totalSitins = $pdo->query("SELECT COUNT(*) FROM sessions")->fetchColumn() ?: 15;

// Get announcements
$announcements = $pdo->query("SELECT * FROM announcements ORDER BY created_at DESC")->fetchAll();

// Handle new announcement submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_announcement'])) {
    $content = trim($_POST['announcement_content']);
    if (!empty($content)) {
        $stmt = $pdo->prepare("INSERT INTO announcements (content, admin_name, created_at) VALUES (?, ?, datetime('now'))");
        $stmt->execute([$content, 'CCS Admin']);
        header("Location: admin_dashboard.php?success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CCS Sit-in System</title>
    <link rel="stylesheet" href="../frontend/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Top Navigation Bar -->
        <nav class="top-nav">
            <div class="nav-left">
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </div>
                <span class="nav-brand">CCS Admin Panel</span>
            </div>
            <div class="nav-center">
                <a href="admin_dashboard.php" class="active">Dashboard</a>
                <a href="manage_students.php">Manage Students</a>
                <a href="sit_in_reports.php">Sit-in Reports</a>
                <a href="lab_sessions.php">Lab Sessions</a>
            </div>
            <div class="nav-right">
                <span class="admin-name"><i class="fas fa-user-cog"></i> <?php echo htmlspecialchars($_SESSION['first_name']); ?> (Admin)</span>
                <a href="logout.php" class="logout">Log out</a>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="dashboard-main">
            <!-- Header -->
            <div class="page-header">
                <h1><i class="fas fa-tachometer-alt"></i> College of Computer Studies Admin</h1>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #e3f2fd;">
                        <i class="fas fa-users" style="color: #1976d2;"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Students Registered</h3>
                        <p class="stat-number"><?php echo $totalStudents; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: #e8f5e9;">
                        <i class="fas fa-desktop" style="color: #388e3c;"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Currently Sit-in</h3>
                        <p class="stat-number"><?php echo $currentSitins; ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: #fff3e0;">
                        <i class="fas fa-chart-line" style="color: #f57c00;"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Sit-ins</h3>
                        <p class="stat-number"><?php echo $totalSitins; ?></p>
                    </div>
                </div>
            </div>

            <!-- Programming Languages Section -->
            <div class="languages-section">
                <h2><i class="fas fa-code"></i> Programming Languages</h2>
                <div class="language-tags">
                    <span class="lang-tag" style="background: #9b4d96;">C#</span>
                    <span class="lang-tag" style="background: #b07219;">Java</span>
                    <span class="lang-tag" style="background: #68217a;">ASP.Net</span>
                    <span class="lang-tag" style="background: #787cb5;">PHP</span>
                </div>
            </div>

            <!-- Two Column Layout for Announcements -->
            <div class="announcements-grid">
                <!-- New Announcement Form -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-plus-circle"></i> New Announcement</h2>
                    </div>
                    <div class="card-content">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="announcement_content">Announcement Content</label>
                                <textarea id="announcement_content" name="announcement_content" rows="4" placeholder="Write your announcement here..." required></textarea>
                            </div>
                            <button type="submit" name="new_announcement" class="submit-btn">
                                <i class="fas fa-paper-plane"></i> Submit
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Posted Announcements -->
                <div class="card">
                    <div class="card-header">
                        <h2><i class="fas fa-bullhorn"></i> Posted Announcement</h2>
                    </div>
                    <div class="card-content announcements-list">
                        <?php if (empty($announcements)): ?>
                            <div class="announcement-item">
                                <div class="announcement-header">
                                    <span class="admin">CCS Admin</span>
                                    <span class="date">2026-Feb-11</span>
                                </div>
                                <p class="announcement-text">CCS Admin | 2026-Feb-11</p>
                            </div>
                            <div class="announcement-item">
                                <div class="announcement-header">
                                    <span class="admin">CCS Admin</span>
                                    <span class="date">2024-May-08</span>
                                </div>
                                <p class="announcement-text">Important Announcement: We are excited to announce the launch of our new website! Explore our latest products and services now!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($announcements as $announcement): ?>
                                <div class="announcement-item">
                                    <div class="announcement-header">
                                        <span class="admin"><i class="fas fa-user-shield"></i> <?php echo htmlspecialchars($announcement['admin_name']); ?></span>
                                        <span class="date"><i class="far fa-calendar-alt"></i> <?php echo date('Y-M-d', strtotime($announcement['created_at'])); ?></span>
                                    </div>
                                    <p class="announcement-text"><?php echo htmlspecialchars($announcement['content']); ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
    <div class="success-popup" id="successPopup">
        <div class="popup-content">
            <i class="fas fa-check-circle"></i>
            <p class="success-text">Announcement Posted Successfully!</p>
            <button onclick="hidePopup()" class="ok-btn">OK</button>
        </div>
    </div>
    <script>
        document.getElementById('successPopup').style.display = 'flex';
        setTimeout(function() {
            document.getElementById('successPopup').style.display = 'none';
        }, 3000);
    </script>
    <?php endif; ?>

    <script>
        function hidePopup() {
            document.getElementById('successPopup').style.display = 'none';
        }
    </script>
</body>
</html>