<?php
session_start();
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number = trim($_POST['id_number']);
    $password  = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id_number = ?");
    $stmt->execute([$id_number]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: login.php?error=notfound");
        exit();
    } elseif (!password_verify($password, $user['password'])) {
        header("Location: login.php?error=wrongpass");
        exit();
    } else {
        $_SESSION['user_id']    = $user['id'];
        $_SESSION['id_number']  = $user['id_number'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name']  = $user['last_name'];
        $_SESSION['role']       = $user['role'] ?? 'student'; // Default to student if role not set
        
        session_regenerate_id(true);
        
        // Redirect based on role
        if (isset($user['role']) && $user['role'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    }
}
?>