<?php
// 이 파일에는 세션관련, DB생성 등
// 공통 함수, 변수가 포함됩니다.

// 1. 세션 & 에러 모드
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

// 2. DB 연결
const DB_HOST = "db";
const DB_USER = "root";
const DB_PASS = "root";
const DB_NAME = "gsc";

function db_con() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $mysqli->set_charset('utf8mb4');
    return $mysqli;
}

// 3. 공통 함수
function fail(string $msg, string $to) {
    $_SESSION['error'] = $msg;
    header("Location: $to");
    exit;
}