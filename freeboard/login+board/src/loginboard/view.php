<?php
// 이 페이지는 '글 상세보기' 페이지 입니다.
// 기능 -> index에서 해당 글을 클릭 시 GET으로 id 저장 후 로드
session_start();
require_once '../core/init.php';
// header 출력
require_once '../core/header.php';

// step1. id (GET) 유효성 검사
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($post_id <= 0) {
    fail('잘못된 접근 입니다.', "index.php");
}

// step2. (try) DB연결
try {
    $mysqli = db_con();
// step3. sql문 작성 [매우 중요]
    $sql = "SELECT p.id, u.name, p.title, p.content, p.created_at
        FROM posts AS p JOIN users AS u ON u.id = p.user_id WHERE p.id = $post_id";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

} catch (Exception) {
    fail('상세보기 중 오류 발생했습니다.', "./index.php");

} finally {
    if ($mysqli && $mysqli instanceof mysqli) {
        $mysqli->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글 상세보기</title>
</head>
<body>
    <h2>글 상세보기</h2>
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

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>제목</th>
        <td><?= $row['title']?></td>
    </tr>
    <tr>
        <th>작성자</th>
        <td><?= $row['name']?></td>
    </tr>
    <tr>
        <th>작성일</th>
        <td><?= $row['created_at']?></td>
    </tr>
    <tr>
        <th>작성글</th>
        <td><?= $row['content']?></td>
    </tr>
</table><br>
<!-- 버튼 설정 (수정/삭제/목록으로) -->
<button onclick="location.href='edit.php?id=<?= $post_id ?>'">수정</button>
<button onclick="location.href='delete.php?id=<?= $post_id ?>'">삭제</button>
<button onclick="location.href='index.php'">목록으로</button>
</body>
</html>