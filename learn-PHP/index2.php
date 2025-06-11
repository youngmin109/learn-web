<?php
$servername = "localhost"; // 오타 수정
$username = "user";
$password = "12345";
$dbname = "user";  // 사용할 DB s이름

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) { // 수정된 연결 확인 방식
    die("연결 실패: " . $conn->connect_error);
}
echo "MySQL 연결 성공!";
?>
