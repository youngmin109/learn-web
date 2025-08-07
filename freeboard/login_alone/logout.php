<?php
// 세션 시작
session_start();

// 1. 세션 변수 초기화
$_SESSION = [];

// 2. 세션 쿠키 삭제
if (ini_get('session.use.cookies'))  {
    $paramas = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $paramas['path'], $paramas['domain'],
        $paramas['secure'], $paramas['httponly']
    )
}

// 3. 세션 자체 파기
session_destroy();

// 4. 로그인 페이지로 이동
header('Location: login.php');
exit;
?>