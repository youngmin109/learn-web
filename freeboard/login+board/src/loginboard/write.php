<?php
// 아이디 검사
session_start();
require_once '../core/init.php';
if (!isset($_SESSION['username'])) {
    fail('로그인 후 글쓰기가 가능합니다', "./index.php");
}
// 헤더 출력
require_once '../core/header.php';
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글쓰기</title>
</head>

<body>
    <p style='color:red'><?php
    // 세션 에러 & 성공 메시지
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
    // 세션 old 저장
    $old = $_SESSION['old'] ?? [];
    unset($_SESSION['old']);
    ?></p><br>
    <fieldset>
        <legend>글 양식</legend>
        <form action="./write_process.php" method="post">
            제목: <input type="text" name="title" value="<?=$old['title'] ?? ''?>" required><br><br>
            내용: <textarea name="content" name="content" required><?=$old['content'] ?? ''?></textarea>
            <button type="submit">작성하기</button>
        </form>
    </fieldset><br>
    <a href="./index.php">취소하기</a>
</body>

</html>