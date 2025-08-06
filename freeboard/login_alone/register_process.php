<?php

session_start();

// a. 입력값 수집과 전처리
// username, password, name
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$name = trim($_POST['name'] ?? '');

// 유효성 검사
if ($username=='' || $password=='' || $name=='') {
    $_SESSION['error'] = "입력값을 모두 작성해주세요!";
    header("Location: register.php");
    echo "여기까지 실행됨";
    exit;
}

// b. DB 연결
// db_connect 불러오기

// 예외 처리


// c. 중복 아이디 검사
// username(U) 이스케이프

// sql문 작성 후 예외처리 (if-else)
// 중복 아이디 & 쿼리자체 오류 시 register.php로 리디렉션


// d. 비밀번호 해시화


// e. INSERT 회원가입 진행
// sql 쿼리문 작성

// 예외처리 (try-catch)
// 회원가입 성공 시 로그인 페이지 이동
// 회원가입 실패 시 register.php 리디렉션
?>