<?php
// 세션 에러 메시지 출력
session_start();

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
    <title>회원가입</title>
</head>
<body>
    <h2>회원가입</h2>
    <fieldset>
        <legend>회원가입 정보 입력</legend>
        <form action="register_process.php" method="post">
            <label for="username">아이디: <input type="text" id="username" name="username"></label><br><br>
            <label for="password">비밀번호: <input type="password" id="password" name="password"></label><br><br>
            <label for="name">닉네임: <input type="text" id="name" name="name"></label><br><br>
            <button type="submit">회원가입</button>
        </form>
            <p>이미 계정이 있으신가요?<a href="./login.php">로그인</a></p>
    </fieldset>
</body>
</html>