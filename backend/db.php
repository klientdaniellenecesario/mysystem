<?php
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/mysystem.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if role column exists, if not add it
    $stmt = $pdo->query("PRAGMA table_info(users)");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1);
    
    if (!in_array('role', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN role TEXT DEFAULT 'student'");
    }
    
    // Create table if it doesn't exist (original structure + role)
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
        role TEXT DEFAULT 'student',
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
    
    // Insert sample announcements if table is empty
    $count = $pdo->query("SELECT COUNT(*) FROM announcements")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO announcements (content, created_at) VALUES 
            ('Important Announcement: We are excited to announce the launch of our new website! Explore our latest products and services now!', '2024-05-08 10:00:00'),
            ('Welcome to CCS Sit-in System! Please read the laboratory rules carefully.', '2026-02-11 09:00:00')");
    }
    
    // CHECK IF ADMIN ACCOUNT EXISTS - IF NOT, CREATE IT
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id_number = ?");
    $stmt->execute(['admin']);
    $adminExists = $stmt->fetchColumn();
    
    if (!$adminExists) {
        // Create admin account with hashed password
        $adminPassword = password_hash('admin', PASSWORD_BCRYPT);
        $pdo->prepare("INSERT INTO users (id_number, last_name, first_name, password, email, course_level, address, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
            ->execute([
                'admin', 
                'Admin', 
                'System', 
                $adminPassword, 
                'admin@ccs.edu', 
                'Admin', 
                'University of Cebu', 
                'admin'
            ]);
    }
    
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("System unavailable. Please try again later.");
}
?>