<?php
require __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number    = trim($_POST['id_number']);
    $last_name    = trim($_POST['last_name']);
    $first_name   = trim($_POST['first_name']);
    $middle_name  = trim($_POST['middle_name'] ?? '');
    $course_level = $_POST['course_level'];
    $email        = trim($_POST['email']);
    $password     = $_POST['password'];
    $confirm      = $_POST['confirm_password'];
    $bsit_course  = isset($_POST['bsit_course']) ? 1 : 0;
    $address      = trim($_POST['address']);

    if ($password !== $confirm) {
        die("Passwords do not match. <a href='register.php'>Go back</a>");
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users 
            (id_number, last_name, first_name, middle_name, course_level, email, password, bsit_course, address) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $id_number, $last_name, $first_name, $middle_name,
            $course_level, $email, $hashed_password, $bsit_course, $address
        ]);

        header("Location: /backend/login.php?registered=1");
        exit();

    } catch (PDOException $e) {
        if ($e->getCode() == 23000 || strpos($e->getMessage(), 'UNIQUE') !== false) {
            die("ID Number or Email already exists. <a href='register.php'>Go back</a>");
        }
        die("Error: " . $e->getMessage());
    }
}
?>