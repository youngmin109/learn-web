<?php
require_once './init.php';

// 글 목록 보기
// 세션 에러 출력
if (isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
    exit;
}

$rows = [];
// 1. DB 연결
// (try문) DB 객체 생성 (실패시 -> catch문)
try {
    $mysqli = db_con();

    // 2. 게시판 불러 오기
    // sql 문 작성
    // 비밀번호/content는 X
    $sql = "SELECT id, title, name, created_at
    FROM posts ORDER BY created_at DESC";
    $result = $mysqli->query($sql);

    // 게시글 없음
    if ($result->num_rows === 0) {
        echo '<a href="write.php">게시글이 없습니다.<br>첫 글을 작성해보세요!</a>';
    } else {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }
    // 3. catch문 예외 처리
} catch (mysqli_sql_exception $e) {
    // html 작성
    // 출력시 항상 이스케이프

    // 로그 남기기
    error_log("데이터 베이스 연결 오류" . $e->getMessage());
    fail('게시글 목록을 불러오는 중 오류 발생');
} finally {
    if (isset($mysqli)) {
        $mysqli->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
</head>

<body>
    <h2>글 목록 보기</h2>
    <table border="1">
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= htmlspecialchars($r['id']) ?></td>
                    <td><?= htmlspecialchars($r['title']) ?></td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- 작성하기 버튼 -->
    <p><a href="./write.php">작성하기</a></p>
</body>

</html>