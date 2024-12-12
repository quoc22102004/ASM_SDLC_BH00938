<?php
$host = 'localhost';
$user = 'root';
$password = '';
$db_name = 'student_management';

$conn = new mysqli($host, $user, $password, $db_name);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
} else {
    echo "Kết nối thành công!";
}
?>
