<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, age, phone, role, username, password) 
            VALUES ('$name', $age, '$phone', '$role', '$username', '$password')";
    if ($conn->query($sql)) {
        echo "Đăng ký thành công! <a href='login.php'>Đăng nhập</a>";
    } else {
        echo "Đăng ký thất bại: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Đăng ký</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Họ và Tên" required>
        <input type="number" name="age" placeholder="Tuổi" required>
        <input type="text" name="phone" placeholder="Số điện thoại" required>
        <select name="role">
            <option value="student">Học sinh</option>
            <option value="teacher">Giáo viên</option>
            <option value="admin">Admin</option>
        </select>
        <input type="text" name="username" placeholder="Tài khoản" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng ký</button>
    </form>
    <link rel="stylesheet" href="styles.css">
</body>
</html>
