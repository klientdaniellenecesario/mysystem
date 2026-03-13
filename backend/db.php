<?php
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/mysystem.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create users table if it doesn't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        id_number TEXT NOT NULL UNIQUE,
        last_name TEXT NOT NULL,
        first_name TEXT NOT NULL,
        middle_name TEXT,
        course_level TEXT NOT NULL,
        password TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        bsit_course INTEGER DEFAULT 0,
        address TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Create sessions table for sit-in tracking
    $pdo->exec("CREATE TABLE IF NOT EXISTS sessions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        session_date DATE NOT NULL,
        time_in TIME NOT NULL,
        time_out TIME,
        purpose TEXT,
        status TEXT DEFAULT 'active',
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
    )");
    
    // Create announcements table
    $pdo->exec("CREATE TABLE IF NOT EXISTS announcements (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT,
        content TEXT NOT NULL,
        admin_name TEXT DEFAULT 'CCS Admin',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert sample announcement if table is empty
    $count = $pdo->query("SELECT COUNT(*) FROM announcements")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO announcements (content, created_at) VALUES 
            ('Important Announcement: We are excited to announce the launch of our new website! Explore our latest products and services now!', '2024-05-08 10:00:00'),
            ('Welcome to CCS Sit-in System! Please read the laboratory rules carefully.', '2026-02-11 09:00:00')");
    }
    
    // Create sample sessions for testing (optional)
    $count_sessions = $pdo->query("SELECT COUNT(*) FROM sessions")->fetchColumn();
    if ($count_sessions == 0) {
        // This will only work if you have users, so it's optional
        // $pdo->exec("INSERT INTO sessions (user_id, session_date, time_in, purpose) VALUES ...");
    }
    
} catch (PDOException $e) {
    // Log error for debugging
    error_log("Database connection failed: " . $e->getMessage());
    die("System unavailable. Please try again later.");
}
?>