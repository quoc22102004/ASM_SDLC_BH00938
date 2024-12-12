<?php
session_start();
require_once 'db.php';

// Kiểm tra quyền truy cập (chỉ giáo viên và admin được phép)
if ($_SESSION['user']['role'] !== 'teacher' && $_SESSION['user']['role'] !== 'admin') {
    header('Location: home.php');
    exit();
}

// Lấy danh sách điểm
$scores = $conn->query("
    SELECT scores.id AS score_id, users.name AS student_name, subjects.name AS subject_name, scores.score
    FROM scores
    JOIN users ON scores.student_id = users.id
    JOIN subjects ON scores.subject_id = subjects.id
");

// Xử lý thêm/sửa điểm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score_id = $_POST['score_id'];
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $score = $_POST['score'];

    if (empty($score_id)) { // Nếu không có ID, thêm mới
        $conn->query("INSERT INTO scores (student_id, subject_id, score) VALUES ($student_id, $subject_id, $score)");
    } else { // Nếu có ID, cập nhật
        $conn->query("UPDATE scores SET student_id = $student_id, subject_id = $subject_id, score = $score WHERE id = $score_id");
    }
    header('Location: manage_scores.php');
}

// Xóa điểm
if (isset($_GET['delete'])) {
    $score_id = $_GET['delete'];
    $conn->query("DELETE FROM scores WHERE id = $score_id");
    header('Location: manage_scores.php');
}

// Lấy danh sách học sinh và môn học
$students = $conn->query("SELECT id, name FROM users WHERE role = 'student'");
$subjects = $conn->query("SELECT id, name FROM subjects");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="diem.css">
</head>
<body>
    <h2>Quản lý điểm</h2>
    <button onclick="window.location.href='home.php'" class="btn-home">Thoát về Trang chủ</button>

    <!-- Form thêm/sửa điểm -->
    <form method="POST">
        <h3>Thêm/Sửa điểm</h3>
        <select name="score_id">
            <option value="">Thêm điểm mới</option>
            <?php
            $all_scores = $conn->query("
                SELECT scores.id, users.name AS student_name, subjects.name AS subject_name
                FROM scores
                JOIN users ON scores.student_id = users.id
                JOIN subjects ON scores.subject_id = subjects.id
            ");
            while ($score = $all_scores->fetch_assoc()) {
                echo "<option value='{$score['id']}'>Sửa: {$score['student_name']} - {$score['subject_name']}</option>";
            }
            ?>
        </select>
        <select name="student_id" required>
            <option value="">Chọn học sinh</option>
            <?php while ($student = $students->fetch_assoc()): ?>
                <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <select name="subject_id" required>
            <option value="">Chọn môn học</option>
            <?php while ($subject = $subjects->fetch_assoc()): ?>
                <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="number" name="score" placeholder="Điểm" required>
        <button type="submit">Lưu thông tin</button>
    </form>

    <!-- Danh sách điểm -->
    <h3>Danh sách điểm</h3>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Tên học sinh</th>
                <th>Môn học</th>
                <th>Điểm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $scores->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['score']); ?></td>
                    <td>
                        <a href="manage_scores.php?delete=<?php echo $row['score_id']; ?>">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
