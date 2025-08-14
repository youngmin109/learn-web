<?php
// delete.php
// 게시글 삭제를 위한 폼 입니다.
session_start();
require_once '../core/init.php';

// step1. 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    fail('로그인 후 이용 가능합니다.', "login.php");
}

// step2. GET 아이디 유효성 검사
$post_id = $_GET['id'] ? intval($_GET['id']) : 0;
if ($post_id <= 0) {
    fail('잘못된 접근', "index.php");
}

// step3. (try) DB연결 및 sql문 작성
try {
    $mysqli = db_con();

    //  게시글의 아이디가 맞는지 검사
    $sql = "SELECT user_id FROM posts WHERE $post_id = id";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();

    // 해당 아이디 행이 없으면 종료
    if ($result->num_rows <= 0) {
        fail('알 수 없는 오류.', "index.php");
    }

    // 아이디 검증
    if (intval($_SESSION['user_id']) !== intval($row['user_id'])){
        fail('자신이 쓴 글만 삭제 할 수 있습니다.', "view.php?id=$post_id");
    }

    // step4. 글 삭제 sql문 작성 후 완료 시 index.php 리디렉션
    $del_sql = "DELETE FROM posts WHERE id = $post_id";
    $mysqli->query($del_sql);

    $_SESSION['success'] = "글 삭제 성공!";
    header("Location: ./index.php");
    exit;

} catch (Exception) {
    fail('글 삭제 중 오류가 발생했습니다.', "./write.php");
} finally {
    if ($mysqli && $mysqli instanceof mysqli) {
        $mysqli->close();
    }
}
?>