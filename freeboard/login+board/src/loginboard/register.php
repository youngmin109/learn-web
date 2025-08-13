<?php
// 회원가입 페이지
session_start();
// header 출력
require_once '../core/header.php';
?>
<!-- step1. 폼 부터 작성 -->
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
</head>
<body>
    <p style='color:red'><?php
    // 세션 에러 & 성공 메시지
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    }?></p>
    <h2>회원가입</h2>
    <fieldset>
        <legend>정보 입력</legend>
        <form action="./register_process.php" method="post">
            아이디: <input type="text" name="username"><br><br>
            비밀번호: <input type="password" name="password"><br><br>
            닉네임: <input type="text" name="name"><br><br>
            <button type="submit">회원가입</button>
            <button type="reset">초기화</button>
        </form>
        <p>이미 아이디가 있습니까? <a href="./login.php">로그인</a></p>
    </fieldset>
</body>

</html>