<?php
// 변수 설정
const DB_HOST = 'db';
const DB_USER = 'root';
const DB_PASS = 'root';
const DB_NAME = 'login';

// 연결 설정
function db_con() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    return $mysqli;
}

// 예외 설정
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// 세션 설정
// if (session_status() !== PHP_SESSION_ACTIVE) {
//     session_start();}
// 공통 헬퍼
// 기본값 설정
function fail(string $msg, string $to = 'index.php') {
    $_SESSION['error'] = $msg;
    header("Location: {$to}");
    exit;
}
?>