<?php
// read_session.php
// 세션을 시작하지 않으면 
// $_SESSION 변수가 비어있게 된다.

// session_start();

print_r($_SESSION);

// read
$name = $_SESSION['std_info']['name'] ?? 'null';
echo "학생 이름: $name<br>";

// delete (파이썬에서 del과 같은 역할)
unset($_SESSION['std_info']['name']);
print_r($_SESSION);

// 메모리 상 삭제
$_SESSION['std_info'] = null;

// 세션을 완전히 제거 (세션 파일 삭제)
session_destroy();

// 세션 쿠키 삭제
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', 
    time() - 3600, '/');
}

?>