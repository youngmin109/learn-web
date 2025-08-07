<?php
// 공통
session_start();
// 1. fail 함수
function fail(String $msg) {
    $_SESSION['error'] = $msg;
    header("Location: login.php");
    exit;
}

// a. 입력값 수집 및 전처리 & 유효성 검사
// a-1 입력값 수집 [trim] + 공백 처리
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

// a-2 유효성 검사
// 빈 값인지 체크 [if(fail) - else)]
if ($username==='' || $password==='') {
    fail("모든 값을 입력 하세요.");
}

// try
try {
    // b. DB연결
    // b-1 db_connect 불러와서 객체 생성
    require_once './db_connect.php';
    $mysqli = connect_mysql();

    // c. 로그인 처리
    // c-1 아이디 검증
    $sql = "SELECT * 
        FROM login WHERE username = '{$username}'";
    $result = $mysqli->query($sql);
    
    // DB 연결 종료
    $mysqli->close();

    if ($result->num_rows===0) {
            fail("아이디가 없습니다.");
        }
    // c-2 비밀번호 검증
    $row = $result->fetch_assoc();
    $hash = $row['password'];

    // 비밀번호 비교
    if (!password_verify($password, $hash)){
        fail("비밀번호가 틀립니다.");
    }
    // d. 검증 완료 - 로그인 성공
    // 세션에 username, name 저장
    $_SESSION['username'] = $row['username'];
    $_SESSION['name'] = $row['name'];

    // welcome.php로 redirection
    $_SESSION['success'] = "로그인 성공!";
    header("Location: welcome.php");


} // catch 예외
catch(mysqli_sql_exception $e) {
// b-2 DB 연결 실패
    // 에러 log 기록
    error_log("데이터 베이스 연결 오류" . $e->getMessage());
    fail("데이터 베이스 연결 오류");
    $mysqli->close();
}
?>