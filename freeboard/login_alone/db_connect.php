<?php
// DB 연결 로직
// db.conf 불러오기
require_once './db_conf.php';

// 예외 전역 설정
// ERROR는 경고만 남기고 코드 실행 계속, STRICT는 경고 대신 예외를 던짐
// 에러보고도 켜 두는게 안전
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

// 함수
function connect_mysql() {
    // db 연결
    $db_conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // return
    return $db_conn;
}
?>