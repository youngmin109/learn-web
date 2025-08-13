<?php
session_start();
require_once '../core/init.php';
// header 출력
require_once '../core/header.php';
// 이 페이지는 게시판 목록을 보여줍니다.
// step1. 세션 목록 가져오기 & 변수 저장
$name = $_SESSION['name'];
// step2. (try문) db연결
try {
    $mysqli = db_con();

    // step3. 게시글 가져오기
    $sql = "SELECT * FROM posts ORDER BY id DESC";
    $result = $mysqli->query($sql);

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
    <title>게시판 목록</title>
</head>

<body>
    <p style='color:red'><?php
    // 세션 에러 & 성공 메시지
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    }
    ?></p>
    <h2>게시판 목록</h2>
    <!-- 테이블 -->
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>번호</th>
                <th>작성자</th>
                <th>제목</th>
                <th>작성일</th>
                <th>수정일</th>
            </tr>
        </thead>
        <tbody>
        <!-- 게시글이 하나라도 있을시 출력 -->
        <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
        <td><?=$row['id']?></td>
        <td><?=$name?></td>
        <td><a href="./view.php?id=<?=$row['id']?>"><?=$row['title']?></a></td>
        <td><?=$row['created_at']?></td>
        <td><?=$row['updated_at']?></td>
        <?php endwhile;?>
        <?php else :?>
        게시글이 없습니다.
        <?php endif;?>
        </tbody>
    </table>
</body>

</html>