<?php
// DB 연결 로직
// db.conf 불러오기
require_once './db_conf.php';

// 함수
    function connect_sql() {
    // db 연결
    $db_conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


    // return
    return $db_conn;
}
?>