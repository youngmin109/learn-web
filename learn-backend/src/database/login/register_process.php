<?php
session_start();
require_once('./db_conf.php');

// 1. DB 연결
$db_conn = new mysqli(db_info::DB_URL, db_info::USER_ID, db_info::PASSWD, db_info::DB);
if ($db_conn->connect_errno) {
    $_SESSION['error'] = "DB 연결에 실패했습니다.";
    header("Location: register.php");
    exit;
}

// 2. 사용자 입력 전처리
$username_raw = trim($_POST['username'] ?? '');
$password_raw = trim($_POST['password'] ?? '');
$name_raw     = trim($_POST['name'] ?? '');

// 3. 입력값 검증
if ($username_raw === '' || $password_raw === '' || $name_raw === '') {
    $_SESSION['error'] = "모든 필드를 입력하세요.";
    header("Location: register.php");
    exit;
}

// 4. 비밀번호 해싱
$password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

// 5. SQL 인젝션 방지를 위한 이스케이프 처리 (실습용)
$username = $db_conn->real_escape_string($username_raw);
$password = $db_conn->real_escape_string($password_hashed);
$name     = $db_conn->real_escape_string($name_raw);

// 6. SQL 실행
$sql = "
    INSERT INTO users (username, password, name)
    VALUES ('$username', '$password', '$name')
";

if ($db_conn->query($sql)) {
    // 회원가입 성공
    $db_conn->close();
    header("Location: login.php");
    exit;
} else {
    // 회원가입 실패: 중복 아이디 또는 기타 오류
    if ($db_conn->errno === 1062) {
        $_SESSION['error'] = "이미 사용 중인 아이디입니다.";
    } else {
        $_SESSION['error'] = "회원가입에 실패했습니다. 관리자에게 문의하세요.";
        error_log("[REGISTER ERROR] " . $db_conn->error);
    }
    $db_conn->close();
    header("Location: register.php");
    exit;
}
