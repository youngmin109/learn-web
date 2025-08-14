<?php
session_start();
require_once '../core/init.php';
// 이 페이지는 게시판 목록을 보여줍니다.
// step1. 세션 목록 가져오기 & 변수 저장
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '손';

// p-1 현재 페이지 번호 받아오기
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
// p-2 limit 설정
$limit = 5;
// p-3 OFFSET 설정
$offset = ($page - 1) * $limit;

// step2. (try문) db연결
try {
    $mysqli = db_con();

    // p-4 전체 게시글 수 조회
    $sql = "SELECT COUNT(*) AS total FROM posts";
    $result = $mysqli->query($sql);
    $total_posts = $result->fetch_assoc()['total'];

    // p-5 전체 페이지 수 계산
    $total_pages = ceil($total_posts / $limit);

    // p-6 현재 페이지에 해당하는 게시글만 조회

    // step3. 게시글 가져오기
    $sql = "SELECT p.id, p.title, u.name, p.created_at, p.updated_at
            FROM posts AS p JOIN users AS u ON u.id = p.user_id
            ORDER BY p.id DESC LIMIT $limit OFFSET $offset";
    $posts = $mysqli->query($sql);
    $row = $result->fetch_assoc();
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
    <p style='color:red'>
        <?php
        // 세션 에러 & 성공 메시지
        if (isset($_SESSION['error'])) {
            echo $_SESSION['error'];
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
        // header 출력
        require_once '../core/header.php';
        ?></p>
    <p>안녕하세요. <?= $user_id ?>님!</p>
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
            <?php if ($posts->num_rows > 0): ?>
                <?php while ($post = $posts->fetch_assoc()): ?>
                    <tr>
                        <td><?= $post['id'] ?></td>
                        <td><?= $post['name'] ?></td>
                        <td><a href="./view.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></td>
                        <td><?= $post['created_at'] ?></td>
                        <td><?= $post['updated_at'] ?></td>
                    <tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    게시글이 없습니다.
                <?php endif; ?>
        </tbody>
    </table>
     <?php for ($i = 1; $i <= $total_pages; $i++) {
            echo ($i == $page) ? "<strong>$i</strong> " : "<a href='?page=$i'>$i</a> ";
        } ?>
</body>

</html>
