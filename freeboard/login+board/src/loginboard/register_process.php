<?php
// 회원가입 처리 페이지
session_start();
require_once '../core/init.php';

// step1. 입력값 수집 및 전처리 & 유효성 검사
$username = trim($_POST['username'] ?? '');
$password_raw = trim($_POST['password'] ?? '');
$name = trim($_POST['name'] ?? '');

if ($username === '' || $password_raw === '' || $name === ''){
    fail('값을 모두 입력해주세요.', "./register.php");
}
// step2. (try문) db연결
try {
    $mysqli = db_con();
    // step3. 중복아이디 검사
    $sql = "SELECT username FROM users WHERE username='$username'";
    $result = $mysqli->query($sql);
    
    // 중복 아이디 있음
    if ($result->num_rows>0) {
        fail('중복 아이디', "./register.php");
    }

    // step4. 비밀번호 해시화
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // step5. sql문 작성 및 입력
    $sql = "INSERT INTO users (username, password, name)
    VALUES ('$username', '$password', '$name')";
    $result = $mysqli->query($sql);
    $mysqli->close();

    // 회원가입 성공 시 success메시지 저장 후
    // login 페이지로 리디렉션
    $_SESSION['success'] = "회원가입 성공!";
    header("Location: ./login.php");
    exit;
}
// (catch문) 예외처리
catch (Exception) {
    fail('오류: 회원가입 실패', "./register.php");
}
?>