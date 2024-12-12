<?php
session_start();
require_once 'db.php';

// Kiểm tra quyền truy cập
if ($_SESSION['user']['role'] !== 'teacher' && $_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit();
}

// Lấy danh sách môn học từ cơ sở dữ liệu
$subjects = $conn->query("SELECT subject_name FROM subjects");

// Thêm môn học mới
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_subject'])) {
    $subject_name = $_POST['subject_name'];
    $conn->query("INSERT INTO subjects (subject_name) VALUES ('$subject_name')");
    header('Location: manage_subjects.php');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý môn học</title>
    <link rel="stylesheet" href="monhoc.css">
</head>
<body>
    <div class="container">
        <h2>Quản lý môn học</h2>

        <!-- Form thêm môn học -->
        <form method="POST">
            <input type="text" name="subject_name" placeholder="Tên môn học" required>
            <button type="submit" name="add_subject">Thêm môn học</button>
        </form>

        <h3>Danh sách môn học</h3>
        <table>
            <tr>
                <th>Tên môn học</th>
            </tr>
            <?php while ($row = $subjects->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['subject_name']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Nút quay lại trang chủ -->
        <a href="home.php" class="back-btn">Quay lại trang chủ</a>
    </div>
</body>
</html>
