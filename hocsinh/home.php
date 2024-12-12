<?php

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }
        .menu {
            width: 200px;
            background-color: #f4f4f4;
            padding: 10px;
            border-right: 1px solid #ccc;
        }
        .menu a {
            display: block;
            margin: 5px 0;
            text-decoration: none;
            color: #333;
            padding: 8px;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #ddd;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="menu">
        <h3>Menu</h3>
        <?php if ($user['role'] === 'student'): ?>
            <a href="view_scores.php">Xem điểm</a>
        <?php endif; ?>
        <?php if ($user['role'] === 'teacher' || $user['role'] === 'admin'): ?>
            <a href="manage_students.php">Quản lý học sinh</a>
            <a href="manage_scores.php">Quản lý điểm</a>
            <a href="manage_subjects.php">Quản lý môn học</a>
        <?php endif; ?>
        <?php if ($user['role'] === 'admin'): ?>
            <a href="manage_teachers.php">Quản lý giáo viên</a>
        <?php endif; ?>
        <a href="logout.php">Đăng xuất</a>
    </div>
    <div class="content">
        <h2>Chào mừng, <?php echo $user['name']; ?> (<?php echo $user['role']; ?>)</h2>
        <p>Chọn một chức năng từ menu bên trái.</p>
    </div>
</body>
</html>
