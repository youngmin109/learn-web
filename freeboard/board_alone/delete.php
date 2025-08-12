<?php
// delete.php
// 작성자, 게시글 출력한 후
// 비밀번호 입력 -> delete_process.php
// 1. 공통 설정
require_once './init.php';
$post = null;
$error = null;

session_start();
if (isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}

// id 검증
if (!isset($_GET['id'])) {
    $error = '존재하지 않는 글입니다.';
} else {
    $id = $_GET['id'];
}
// 2. (try문) DB 연결
try {
    if (!$error) {
        $mysqli = db_con();
        // 3. 쿼리 작성 후 name, content 가져오기
        $sql = "SELECT id, name, title, content FROM posts WHERE id = $id";
        // 4. 값 저장
        $result = $mysqli->query($sql);
        if ($result->num_rows === 0) {
            $error ="존재하지 않는 글입니다.";
        } else {
        $post = $result->fetch_assoc();
        }
    }
}
// 5. (catch문) 예외처리
catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    $error = '글을 불러오는 중 오류가 발생했습니다.';
}
// 6. finally문
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
    <title>Document</title>
</head>

<body>
    <!-- 에러 출력 -->
    <?php if($error): ?>
    <?php http_response_code(404); ?>
    <p class="error"><?=htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>

    <?php else: ?>
    <!-- 제목, 작성 가져와서 출력하고 
     ID(hidden) 및 비밀번호 입력 폼 작성 -->
    <p>제목: <?php echo $post['title']; ?></p>
    <p>작성자: <?php echo $post['name']; ?></p><br>
    정말 삭제하시겠습니까?
    <form action="./delete_process.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>"><br>
        비밀번호 확인: <input type="password" name="password" >
        <button>삭제</button><br>
        <a href="view.php?id=<?= $post['id']?>">취소</a>
    </form>
    <?php endif ?>
</body>
</html>