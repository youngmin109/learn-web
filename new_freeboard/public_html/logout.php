<?php
include __DIR__ . "/../includes/session.php";

session_unset(); // 모든 세션 변수 제거
session_destroy(); // 세션 종료

header("Location: index.php"); // 로그인 페이지로 이동
exit();
?>
