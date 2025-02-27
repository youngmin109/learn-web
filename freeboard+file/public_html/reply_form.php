<?php
include __DIR__ . "/../includes/db_connect.php";  // DB 연결

// GET 방식으로 parent_id와 post_id를 받아옴
if (!isset($_GET["parent_id"]) || !isset($_GET["post_id"])) {
    die("잘못된 접근입니다.");
}
$parent_id = (int)$_GET["parent_id"];
$post_id = (int)$_GET["post_id"];
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>답글 작성</title>
</head>
<body>
    <h2>답글 작성</h2>
    <form action="comment_insert.php" method="POST">
        <input type="hidden" name="post_id" value="<?= $post_id ?>">
        <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
        <input type="text" name="author" placeholder="이름" required>
        <input type="password" name="password" placeholder="비밀번호" required>
        <textarea name="content" placeholder="답글을 입력하세요" required></textarea>
        <button type="submit">등록</button>
    </form>
    <a href="view.php?id=<?= $post_id ?>">취소</a>
</body>
</html>
