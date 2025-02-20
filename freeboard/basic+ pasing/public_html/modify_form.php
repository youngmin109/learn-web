<?php
include __DIR__ . "/../includes/db_connect.php"; // DB 연결

// GET 요청으로 글 번호 받기
if (!isset($_GET["id"])) {
    die("잘못된 접근입니다.");
}

$id = $_GET["id"];

// 기존 게시글 데이터 가져오기
$sql = "SELECT * FROM freeboard WHERE id = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("해당 게시글이 존재하지 않습니다.");
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>게시글 수정</title>
</head>
<body>
    <h2>게시글 수정</h2>

    <form action="modify.php" method="post">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label for="name">이름:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($row["name"]) ?>" required>

        <label for="password">비밀번호:</label>
        <input type="password" name="password" required>

        <label for="subject">제목:</label>
        <input type="text" name="subject" value="<?= htmlspecialchars($row["subject"]) ?>" required>

        <label for="content">내용:</label>
        <textarea name="content" rows="5" required><?= htmlspecialchars($row["content"]) ?></textarea>

        <button type="submit">수정 완료</button>
        <button type="button" onclick="location.href='index.php'">취소</button>
    </form>
</body>
</html>
