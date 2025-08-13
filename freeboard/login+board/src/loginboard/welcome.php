<?php
session_start();
$username = $_SESSION['username'];
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
</head>

<body>
    <h2><?= $_SESSION['name'] ?>상! 환영합니다.</h2>
    <fieldset style=width:250px;>
        <legend>회원 정보</legend>
        아이디 : <?= $_SESSION['username'] ?><br>
        닉네임 : <?= $_SESSION['name'] ?>
    </fieldset>
    <form action="./edit.php" method="POST">
        <button type="submit">회원정보 수정</button>
    </form>
    <p><a href="./index.php">>> 게시판으로</a> | <a href="./write.php">>> 첫 글쓰기</a></p>
</body>
</html>