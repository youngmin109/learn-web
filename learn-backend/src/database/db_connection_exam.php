<?php
require_once ('./db_conf.php');

// API를 이용하여 MySQL 데이터베이스에 연결
// 이 클래스 안에 있는 생성자에 접근하여 MySQL 데이터베이스에 연결
// 프로그램 안에서는 DBMS를 연결하여 데이터베이스에 접근가능。
// db 라는 주소를 가지는 mysql에 접속
// 인증 ID : root
// 패스워드 : root
// 선택DB : gsc
// 내부적으로 mysql이 돌아감
// API를 사용할 때 어떤 sql문이 실행되는지 알 수 없음   

// CLI 상에서!
// mysql -u root -p
// root
// use gsc;
// mysqli라는 클래스는 어떤 메소드를 가지고 있는지 확인할 수 있다.
// var_dump($db_conn);

// 1번 작업 : DBMS와의 연결 설정
# DBMS와의 연결을 위해 mysqli 객체를 생성
$db_conn = new mysqli(db_info::DB_URL, db_info::DB_USER, db_info::DB_PASS, db_info::DB_NAME);

// 연결 오류 확인
if ($db_conn->connect_error) {
    echo "DB 연결 실패";
    exit(-1);
}
// 연결 성공
echo "DBMS 연결 성공, gsc db 선택 완료";
$db_conn->close(); // 연결 종료