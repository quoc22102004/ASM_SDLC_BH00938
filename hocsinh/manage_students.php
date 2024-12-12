<?php
session_start();
require_once 'db.php';

if ($_SESSION['user']['role'] !== 'teacher' && $_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit();
}

// Lấy danh sách học sinh
$students = $conn->query("SELECT * FROM users WHERE role = 'student'");

// Xử lý thêm hoặc sửa học sinh
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];

    if (empty($student_id)) { // Nếu không có ID, thêm mới
        $username = $_POST['username'];
        $password = password_hash('123456', PASSWORD_BCRYPT); // Mặc định mật khẩu
        $conn->query("INSERT INTO users (name, age, phone, role, username, password) 
                      VALUES ('$name', $age, '$phone', 'student', '$username', '$password')");
    } else { // Nếu có ID, cập nhật
        $conn->query("UPDATE users SET name = '$name', age = $age, phone = '$phone' 
                      WHERE id = $student_id AND role = 'student'");
    }
    header('Location: manage_students.php');
}

// Xóa học sinh
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id = $id AND role = 'student'");
    header('Location: manage_students.php');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Quản lý học sinh</h2>
    <button onclick="window.location.href='home.php'" class="btn-home">Thoát về Trang chủ</button>

    <!-- Form thêm hoặc sửa học sinh -->
    <form method="POST">
        <h3>Thêm/Sửa học sinh</h3>
        <select name="student_id">
            <option value="">Thêm học sinh mới</option>
            <?php
            $all_students = $conn->query("SELECT id, name FROM users WHERE role = 'student'");
            while ($student = $all_students->fetch_assoc()) {
                echo "<option value='{$student['id']}'>Sửa: {$student['name']}</option>";
            }
            ?>
        </select>
        <input type="text" name="name" placeholder="Họ và Tên" required>
        <input type="number" name="age" placeholder="Tuổi" required>
        <input type="text" name="phone" placeholder="Số điện thoại" required>
        <input type="text" name="username" placeholder="Tài khoản (chỉ khi thêm mới)">
        <button type="submit">Lưu thông tin</button>
    </form>

    <!-- Danh sách học sinh -->
    <h3>Danh sách học sinh</h3>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Họ và Tên</th>
                <th>Tuổi</th>
                <th>Số điện thoại</th>
                <th>Tài khoản</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $students->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <a href="manage_students.php?delete=<?php echo $row['id']; ?>">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <link rel="stylesheet" href="styles.css">

</body>
</html>
