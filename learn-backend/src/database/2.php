<?php

// 1. DBMS와의 연결 설정
$db_conn = new mysqli('db', 'root', 'root', 'gsc');

// 2. SQL 전송
$sql = "SELECT * FROM student";
$result = $db_conn->query($sql);

// 3. 반환 값 처리
$field_info = $result->fetch_field();
foreach ($field_info as $key => $value) {
    echo "$key: $value.<br>" ; // 각 필드의 정보 출력
}

// 4. 연결 종료
$db_conn->close();
?>