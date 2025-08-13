<?php
// 이 페이지는 '글 상세보기' 페이지 입니다.
// 기능 -> index에서 해당 글을 클릭 시 GET으로 id 저장 후 로드
session_start();
require_once '../core/init.php';
// header 출력
require_once '../core/header.php';

// step2. (try) DB연결
try {
    $mysqli = db_con();
// step3. sql문 작성
    // $sql =
    // $mysqli->query($sql);

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
        <td>안녕</td>
    </tr>
    <tr>
        <th>작성자</th>
        <td>영민</td>
    </tr>
    <tr>
        <th>작성일</th>
        <td></td>
    </tr>
    <tr>
        <th>작성글</th>
        <td>하이</td>
    </tr>
</table><br>
<!-- 버튼 설정 (수정/삭제/목록으로) -->
<button onclick="location.href='edit.php?id=<?= $id ?>'">수정</button>
<button onclick="location.href='delete.php?id=<?= $id ?>'">삭제</button>
<button onclick="location.href='index.php'">목록으로</button>
</body>
</html>