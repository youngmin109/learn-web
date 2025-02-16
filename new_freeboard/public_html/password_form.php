<?php

include __DIR__ . "/../includes/session.php";

session_unset(); // 모든 세션 변수 제거
session_destroy(); // 세션 종료

header("Location: login.php"); // 로그인 페이지로 이동
exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php" method="get">
        <button type="submit">홈으로</button> <!-- 인덱스로 이동하는 버튼 추가 -->
    </form>
</body>

</html>