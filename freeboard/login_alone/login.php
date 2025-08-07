<?php
// 세션 성공 메시지
session_start();

if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}

// 세션 에러 메시지
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
    <h2>로그인 화면</h2>
    <fieldset>
        <legend>로그인</legend>
        <form action="./login_process.php" method="POST">
            <label for="username">아이디: <input type="username" id="username" name="username"></label><br><br>
            <label for="password">비밀번호: <input type="password" id="password" name="password"></label><br><br>
            <input type="submit" value="로그인"><br>
        </form>
        <p>계정이 없으신가요?<a href="./register.php">회원가입</a></p>
    </fieldset>
</body>
</html>