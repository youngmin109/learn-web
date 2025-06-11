<?php
include __DIR__ . "/../includes/session.php"; // 로그인 상태 확인
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>홈</title>
</head>
<body>
    <fieldset style="width: 300px; margin: auto; padding: 15px; border-radius: 10px;">
        <legend>홈</legend>
        <ul>
            <li><a href="list.php">게시판</a></li>

            <?php if (is_logged_in()): ?>
                <li><a href="logout.php">로그아웃</a></li>
            <?php else: ?>
                <li><a href="login.php">로그인</a></li>
                <li><a href="register.php">회원가입</a></li>
            <?php endif; ?>
        </ul>
    </fieldset>
</body>
</html>
