<?php
// edit.php
// 이 페이지는 게시글 수정페이지 입니다.
// 기능 : 입력되어있는 폼 제공 (제목, 내용) -> POST process로 전송
session_start();
require_once '../core/init.php';

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    fail('로그인 후 수정 가능!', "./login.php");
}

// GET id값 유효값 검증
$post_id = $_GET['id'] ? (intval($_GET['id'])) : 0;
if ($post_id <= 0) {
    fail('해당 게시글이 존재하지 않습니다.', "./index.php");
}

// step1. db 연결 후 아이디 검증을 위한 sql문 작성
try {
    $mysqli = db_con();
    $sql = "SELECT user_id FROM posts WHERE id = $post_id";

    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    // id 행 개수 확인
    if ($result->num_rows <= 0) {
        fail('해당 아이디가 존재하지 않습니다..', "./view.php?id=$post_id");
    }
    // 맞는 아이디인지 확인
    if ($row['user_id'] !== $_SESSION['user_id']) {
        fail('작성한 글만 수정할 수 있습니다.', "./view.php?id=$post_id");
    }
    // step2. 검증 완료 시 title + content 데이터 가져오기
    $sql = "SELECT id, title, content FROM posts WHERE id=$post_id";
    $result = $mysqli->query($sql);
    $post = $result->fetch_assoc();
} catch (Exception) {
    // 예외처리
    fail('알 수 없는 오류', "./welcome.php");
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
    <title>게시글 수정하기</title>
</head>

<body>
    <?php // header 출력
    require_once '../core/header.php'; ?>
    <h2>게시글 수정하기</h2>
    <form action="./edit_process.php" method="post">
        <!-- 아이디 값은 hidden으로 전송 -->
        <input type="hidden" name="id" value="<?=$post['id']?>">
        <fieldset style="width: 300px;">
            <legend>글 수정</legend>
            제목: <input type="text" name="title" value="<?= $post['title'] ?>"><br><br>
            내용: <textarea name="content"><?= $post['content'] ?></textarea><br><br>
            <button type="submit">수정하기</button>
        </fieldset>
    </form>
    <button onclick="location.href='./view.php?id=<?= $post_id ?>'">취소하기</button>
</body>
</html>