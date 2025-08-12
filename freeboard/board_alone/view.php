<?php
// view.php
// 1. 공통 설정
require_once './init.php';
$post = null;
$error = null;

// 2. (try) id 검사 후 저장(정수형 변환)
try {
    if (!isset($_GET['id'])) {
        $error = '해당 게시글을 조회할 수 없습니다.';
    }
    $id = (int)$_GET['id'];

    // 3. DB 연결
    $mysqli = db_con();

    // 4. 쿼리 실행 - 게시글 조회
    $sql = "SELECT * from posts WHERE id = $id";
    $result = $mysqli->query($sql);

    // 5. 해당 글있는지 확인
    if ($result->num_rows === 0) {
        $error = '존재하지 않는 글 입니다.';
    } else {
        // 6. 게시글 정보를 배열로 저장
        $post = $result->fetch_assoc();
    }

// 7. (catch) 예외 발생 시 에러 로그 기록 후 index로 이동
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    $error = '데이터베이스 오류';
} catch (Exception $e) {
    error_log($e->getMessage());
    $error = '알 수 없는 오류';
}
// 8. finally 연결 종료
finally {
    if (isset($mysqli) && $mysqli instanceof mysqli) {
        $mysqli->close();
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>글 상세 보기</title>
</head>
<body>
    <!-- html문 작성
    1. 제목
    2. 작성자, 작성일, 수정일(있는 경우)
    3. 게시글 내용 출력
    4. 수정/삭제/목록 버튼 -->
    <p><a href="./index.php">목록으로</a></p>
    <h2>글 상세보기</h2>
    <!-- error 있는 경우 -->
    <?php if ($error): ?>
        <?php http_response_code(404); ?>
        <p class="error"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    
    <!-- error 없으면 -->
    <?php else: ?>
    <h4>제목: <?=$post['title']?></h4>
    작성자: <?=htmlspecialchars($post['name'])?><br>
    작성일: <?=htmlspecialchars($post['created_at'])?><br>
    <?php if (!empty($post['updated_at'])): ?>
    수정일: <?=htmlspecialchars($post['updated_at'])?><br><br>
    <?php endif; ?>
    내용: <?=htmlspecialchars($post['content'])?><br>
    <a href="./edit.php?id=<?= $post['id']?>">수정</a>
    <a href="./delete.php?id=<?= $post['id']?>">삭제</a>
    <?php endif; ?>
</body>
</html>

