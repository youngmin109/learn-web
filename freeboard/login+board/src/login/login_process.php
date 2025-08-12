<?php
// 로그인 처리 페이지
session_start();
require_once '../core/init.php';

// step1. 입력값 수집 및 전처리 & 유효성 검사
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === ''){
    fail('값을 모두 입력해주세요.', "./login.php");
}
// step2. (try문) db연결
try {
    $mysqli = db_con();
    // step3. 아이디 검증
    $sql = "SELECT username, password, name FROM users WHERE username='$username'";
    $result = $mysqli->query($sql);
    
    // 해당 아이디가 없음
    if ($result->num_rows==0) {
        fail('해당 아이디가 없습니다.', "./login.php");
    }
    $row = $result->fetch_assoc();
    
    // step4. 비밀번호 검증
    $hash_pw = $row['password'];
    if (!password_verify($password, $hash_pw)) {
        fail('비밀번호가 틀립니다.', "./login.php");
    }

    $mysqli->close();

    // 회원가입 성공 시 success메시지 저장 후
    $_SESSION['success'] = "로그인 성공!";
    // 세션에 username, name 저장
    $_SESSION['username'] = $row['username'];
    $_SESSION['name'] = $row['name'];

    // 그 후, welcome 페이지로 리디렉션
    header("Location: ./welcome.php");
    exit;
}
// (catch문) 예외처리
catch (Exception) {
    fail('오류: 로그인 실패', "./login.php");
}
?>