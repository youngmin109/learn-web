<?php

session_start();

// 에러 메시지 함수
function fail(string $msg) {
    $_SESSION['error'] = $msg;
    header('Location: register.php');
    exit;
}

// a. 입력값 수집과 전처리
// username, password, name
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$name = trim($_POST['name'] ?? '');

// 유효성 검사
if ($username=='' || $password=='' || $name=='') {
    fail('입력값을 모두 작성해주세요!');
}

// b. DB 연결
// db_connect 불러오기
require_once 'db_connect.php';

// 예외 처리
try {
    $mysql = connect_mysql();
} catch (mysqli_sql_exception $e) {
    // 연결 실패
    error_log('DB 연결 오류: ' . $e->getMessage());
    fail("데이터 베이스 연결 오류");
}

// c. 중복 아이디 검사
// 입력값 이스케이프
$username_esp = $mysql->real_escape_string($username);
$password_esp = $mysql->real_escape_string($password);
$name_esp = $mysql->real_escape_string($name);

// sql문 작성 후 예외처리 (if-else)
// 중복 아이디 & 쿼리자체 오류 시 register.php로 리디렉션
$sql = "SELECT * FROM login WHERE username = '{$username_esp}'";
$result = $mysql->query($sql);

if (!$result) {
    // 쿼리 자체 오류 -> DB 이상
    fail('데이터 베이스 쿼리 오류');
    $mysqli->close();

} else if ($result->num_rows > 0){
    // 중복 아이디 있음
    fail('중복 아이디');
    $mysqli->close();
}
// d. 비밀번호 해시화
$password_hsd = password_hash($password_esp, PASSWORD_DEFAULT);

// e. INSERT 회원가입 진행
try {
    // sql 쿼리문 작성
    $sql = "INSERT INTO login 
        (username, password, name) VALUES 
        ('$username_esp', '$password_hsd', '$name_esp')";
    // 예외처리 (try-catch)
    // 회원가입 성공 시 로그인 페이지 이동
    $result = $mysql -> query($sql);
    $_SESSION['success'] = "회원가입 성공!";
    header("Location: login.php");
    $mysql->close();
    exit;
} catch (mysqli_sql_exception) {
    // 회원가입 실패 시 register.php 리디렉션
    fail("회원가입 실패");
    $mysql->close();
}

?>