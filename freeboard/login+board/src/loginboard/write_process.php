<?php
// write_process.php (글작성 처리 페이지)
// 기능 - 사용자가 입력한 제목/내용을 검증 후 DB에 저장
session_start();
require_once '../core/init.php';

// 로그인 여부 확인
if (!isset($_SESSION['user_id'])) {
    fail('로그인 후 글 작성 가능합니다.', "./index.php");
}

// step1. 입력값 (title, content) 수집 및 전처리 후 유효성 검사
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');

// 게시글 저장을 위한 유저값 정보 저장
$user_id = intval($_SESSION['user_id']);

// 입력값 세션 old에 저장
if ($title === '') {
    $_SESSION['old'] = ['title'=>$title, 'content'=>$content];
    fail('제목을 입력해주세요.', "./write.php");
} elseif ($content === '') {
    $_SESSION['old'] = ['title'=>$title, 'content'=>$content];
    fail('글을 입력해주세요.', "./write.php");
}
// step2. (try) DB연결
try {
    $mysqli = db_con();
// step3. sql문 작성 후 입력값 INSERT
    $sql = "INSERT INTO posts (user_id, title, content)
        VALUES ($user_id,'$title', '$content')";
    $mysqli->query($sql);
// step4. 글 작성 완료 시 index.php 리디렉션
    $_SESSION['success'] = "글 업로드 성공!";
    header("Location: ./index.php");
    exit;

} catch (Exception) {
    fail('글 작성 중 오류가 발생했습니다.', "./write.php");

} finally {
    if ($mysqli && $mysqli instanceof mysqli) {
        $mysqli->close();
    }
}
?>