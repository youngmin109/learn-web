<?php
$host = "localhost";
$user = "user";  // 기본 XAMPP 계정
$password = "12345";  // 기본 XAMPP 비밀번호 없음
$database = "basic";

// MySQL 연결
$con = mysqli_connect($host, $user, $password, $database);

// 연결 오류 확인
if (!$con) {
    die("MySQL 연결 실패: " . mysqli_connect_error());
}
?>