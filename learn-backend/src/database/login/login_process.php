<?php
// 세션 시작 (로그인 정보 유지 또는 오류 메시지 전달용)
session_start();

// DB 접속 정보 포함 (클래스 db_info에 상수로 정의되어 있음)
require_once('./db_conf.php');

// MySQL 데이터베이스 연결 시도
$db_conn = new mysqli(db_info::DB_URL, db_info::USER_ID, db_info::PASSWD, db_info::DB);

// 연결 실패 시: 세션에 오류 메시지를 저장하고 로그인 처리 페이지로 이동
if ($db_conn->connect_errno) {
    $_SESSION['error'] = "DB 연결 실패";
    header("Location: login_process.php");
    exit;
}

// 사용자 입력값 전처리 (공백 제거 및 기본값 처리)
$username_raw = trim($_POST['username'] ?? '');
$password_raw = trim($_POST['password'] ?? '');

// 입력값이 비어 있는 경우: 오류 메시지 설정 후 로그인 페이지로 리디렉션
if ($username_raw === '' || $password_raw === '') {
    $_SESSION['error'] = "아이디와 비밀번호를 모두 입력하세요.";
    header("Location: login.php");
    exit;
}

// SQL Injection 방지를 위한 문자열 이스케이프 처리 (실습용, 실무에선 prepared 사용 권장)
$username = $db_conn->real_escape_string($username_raw);

// 사용자 정보 조회 쿼리 실행
$query = "SELECT * FROM users WHERE username = '$username'";
$result = $db_conn->query($query);

// DB 연결 종료 (리소스 반환)
$db_conn->close();

// 조회 결과가 존재하고 사용자 정보가 있을 경우
if ($result && $row = $result->fetch_assoc()) {
    // 비밀번호 일치 여부 확인 (password_hash()와 함께 사용되는 함수)
    if (password_verify($password_raw, $row['password'])) {
        // 로그인 성공: 세션에 사용자 정보 저장 후 웰컴 페이지로 이동
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        header("Location: welcome.php");
        exit;
    } else {
        // 비밀번호 불일치
        $_SESSION['error'] = "비밀번호가 틀렸습니다.";
        header("Location: login.php");
        exit;
    }
} else {
    // 사용자 아이디가 존재하지 않음
    $_SESSION['error'] = "아이디가 존재하지 않습니다.";
    header("Location: login.php");
    exit;
}
