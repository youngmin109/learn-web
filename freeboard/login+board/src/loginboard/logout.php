<?php
session_start();

// 1. 세션 변수 비우기
$_SESSION = [];

// 2. 세션 쿠키 삭제
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $p['path'], $p['domain'],
        $p['secure'], $p['httponly']
    );
}

// 3. 세션 종료
session_destroy();
$_SESSION['success'] = '로그아웃 완료';

// 로그인 페이지로 리디렉션
header("Location: login.php");
exit;
?>