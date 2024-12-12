<?php
session_start();
require_once 'db.php';

if ($_SESSION['user']['role'] !== 'student') {
    header('Location: home.php');
    exit();
}

$student_id = $_SESSION['user']['id'];
$result = $conn->query("SELECT * FROM scores WHERE student_id = $student_id");

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h2>Điểm của bạn</h2>
    <table border="1">
        <tr>
            <th>Môn học</th>
            <th>Điểm</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['subject_name']; ?></td>
                <td><?php echo $row['score']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <link rel="stylesheet" href="styles.css">
</body>
</html>
