<?php
session_start();
require_once 'db.php';

if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit();
}

// Lấy danh sách giáo viên
$teachers = $conn->query("SELECT * FROM users WHERE role = 'teacher'");

// Thêm giáo viên mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_teacher'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = password_hash('123456', PASSWORD_BCRYPT); // Mặc định mật khẩu
    $conn->query("INSERT INTO users (name, age, phone, role, username, password) VALUES ('$name', $age, '$phone', 'teacher', '$username', '$password')");
    header('Location: manage_teachers.php');
}

// Xóa giáo viên
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $id");
    header('Location: manage_teachers.php');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Quản lý giáo viên</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Họ và Tên" required>
        <input type="number" name="age" placeholder="Tuổi" required>
        <input type="text" name="phone" placeholder="Số điện thoại" required>
        <input type="text" name="username" placeholder="Tài khoản" required>
        <button type="submit" name="add_teacher">Thêm giáo viên</button>
    </form>
    <h3>Danh sách giáo viên</h3>
    <table border="1">
        <tr>
            <th>Họ và Tên</th>
            <th>Tuổi</th>
            <th>Số điện thoại</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $teachers->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td>
                    <a href="manage_teachers.php?delete=<?php echo $row['id']; ?>">Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <link rel="stylesheet" href="styles.css">
</body>
</html>
