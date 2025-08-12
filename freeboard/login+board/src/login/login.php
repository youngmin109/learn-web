<?php
// 회원가입 페이지
session_start();
?>
<!-- step1. 폼 부터 작성 -->
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>
<body>
    <p style='color:red'><?php
    // 세션 에러메시지
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }?></p>
    <h2>로그인</h2>
    <fieldset>
        <legend>정보 입력</legend>
        <form action="./login_process.php" method="post">
            아이디: <input type="text" name="username"><br><br>
            비밀번호: <input type="password" name="password"><br><br>
            <button type="submit">로그인</button>
            <button type="reset">초기화</button>
        </form>
        <p>아이디가 없습니까? <a href="./register.php">회원가입</a></p>
    </fieldset>
</body>

</html>