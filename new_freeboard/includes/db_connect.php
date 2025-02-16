<?php
$host = "localhost";
$user = "user";
$password = "12345";
$dbname = "new_freeboard";

// MySQL 연결
$con = mysqli_connect($host, $user, $password, $dbname);

// 연결 확인
if (!$con) {
    die("DB 연결 실패: " . mysqli_connect_error());
}
?>
